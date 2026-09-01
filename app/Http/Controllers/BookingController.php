<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:booking-list')
            ->only(['index', 'show']);

        $this->middleware('permission:booking-create')
            ->only(['create', 'store']);

        $this->middleware('permission:booking-edit')
            ->only(['edit', 'update']);

        $this->middleware('permission:booking-delete')
            ->only(['destroy']);

        $this->middleware('permission:booking-status-update')
            ->only(['updateStatus']);

        $this->middleware('permission:booking-today')
            ->only(['today']);

        $this->middleware('permission:booking-tomorrow')
            ->only(['tomorrow']);

        $this->middleware('permission:booking-pdf-download')
            ->only(['downloadPdf']);

        $this->middleware('permission:booking-pdf-view')
            ->only(['viewPdf']);

        $this->middleware('permission:booking-export')
            ->only(['export']);
    }


    // Show all records
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'driver']);


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('date_range')) {

            $today = now();

            switch ($request->date_range) {

                case 'today':

                    $query->whereDate(
                        'pick_up_time',
                        $today
                    );

                    break;

                case 'yesterday':

                    $query->whereDate(
                        'pick_up_time',
                        $today->copy()->subDay()
                    );

                    break;

                case 'this_week':

                    $query->whereBetween('pick_up_time', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek(),
                    ]);

                    break;

                case 'last_week':

                    $query->whereBetween('pick_up_time', [
                        $today->copy()->subWeek()->startOfWeek(),
                        $today->copy()->subWeek()->endOfWeek(),
                    ]);

                    break;

                case 'this_month':

                    $query->whereBetween('pick_up_time', [
                        $today->copy()->startOfMonth(),
                        $today->copy()->endOfMonth(),
                    ]);

                    break;

                case 'last_month':

                    $query->whereBetween('pick_up_time', [
                        $today->copy()->subMonth()->startOfMonth(),
                        $today->copy()->subMonth()->endOfMonth(),
                    ]);

                    break;

                case 'this_year':

                    $query->whereBetween('pick_up_time', [
                        $today->copy()->startOfYear(),
                        $today->copy()->endOfYear(),
                    ]);

                    break;
            }

        } else {


            if ($request->filled('start_date')) {

                $query->whereDate(
                    'pick_up_time',
                    '>=',
                    $request->start_date
                );
            }

            if ($request->filled('end_date')) {

                $query->whereDate(
                    'pick_up_time',
                    '<=',
                    $request->end_date
                );
            }
        }


        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'guest_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'guest_contact_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'id',
                    'like',
                    "%{$search}%"
                );

            });
        }


        $bookings = $query
            ->orderBy('pick_up_time', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'bookings.index',
            compact('bookings')
        );
    }


    // Show create form
    public function create()
    {
        $vehicles = Vehicle::where('status', 'active')->get();

        $drivers = Driver::where('status', 'active')->get();

        return view(
            'bookings.create',
            compact('vehicles', 'drivers')
        );
    }


    // Save new record
    public function store(Request $request)
    {
        $validated = $request->validate([

            'guest_name' => 'required|string|max:255',

            'guest_contact_number' => 'nullable|string|max:20',

            'pick_up_time' => 'required|date',

            'drop_off_time' => 'nullable|date|after:pick_up_time',

            'pick_up_location' => 'required|string',

            'drop_off_location' => 'nullable|string',

            'service' => 'nullable|string',

            'vehicle_id' => 'nullable|exists:vehicles,id',

            'driver_id' => 'nullable|exists:drivers,id',

            'basic_amount' => 'required|numeric|min:0',

            'no_of_extra_hrs' => 'nullable|numeric|min:0',

            'extra_hrs_amount' => 'nullable|numeric|min:0',

            'other_amounts' => 'nullable|numeric|min:0',

            'payment_method' => 'nullable|string',

            'special_instructions' => 'nullable|string',
        ]);

        $validated['gross_total'] =
            $validated['basic_amount']
            + ($validated['extra_hrs_amount'] ?? 0)
            + ($validated['other_amounts'] ?? 0);

        $validated['status'] = 'pending';

        $validated['created_by'] = auth()->id();

        $validated['updated_by'] = auth()->id();


        if (
            !empty($validated['vehicle_id']) &&
            !Booking::where(
                'vehicle_id',
                $validated['vehicle_id']
            )
            ->where('status', '!=', 'cancelled')
            ->where(
                'pick_up_time',
                $validated['pick_up_time']
            )
            ->doesntExist()
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Selected vehicle is not available at the requested pick-up time.'
                );
        }


        if (
            !empty($validated['driver_id']) &&
            !Booking::where(
                'driver_id',
                $validated['driver_id']
            )
            ->where('status', '!=', 'cancelled')
            ->where(
                'pick_up_time',
                $validated['pick_up_time']
            )
            ->doesntExist()
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Selected driver is not available at the requested pick-up time.'
                );
        }

        $booking = Booking::create($validated);

        return redirect()
            ->route('bookings.show', $booking)
            ->with(
                'success',
                'Booking created successfully.'
            );
    }


    // Show record details
    public function show(Booking $booking)
    {
        $booking->load([
            'vehicle',
            'driver'
        ]);

        return view(
            'bookings.show',
            compact('booking')
        );
    }


    // Show edit form
    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::where('status', 'active')->get();

        $drivers = Driver::where('status', 'active')->get();

        return view(
            'bookings.edit',
            compact(
                'booking',
                'vehicles',
                'drivers'
            )
        );
    }


    // Update existing record
    public function update(
        Request $request,
        Booking $booking
    ) {

        $validated = $request->validate([

            'guest_name' => 'required|string|max:255',

            'guest_contact_number' => 'nullable|string|max:20',

            'pick_up_time' => 'required|date',

            'drop_off_time' => 'nullable|date|after:pick_up_time',

            'pick_up_location' => 'required|string',

            'drop_off_location' => 'nullable|string',

            'service' => 'nullable|string',

            'vehicle_id' => 'nullable|exists:vehicles,id',

            'driver_id' => 'nullable|exists:drivers,id',

            'basic_amount' => 'required|numeric|min:0',

            'no_of_extra_hrs' => 'nullable|numeric|min:0',

            'extra_hrs_amount' => 'nullable|numeric|min:0',

            'other_amounts' => 'nullable|numeric|min:0',

            'payment_method' => 'nullable|string',

            'special_instructions' => 'nullable|string',
        ]);

        $validated['gross_total'] =
            $validated['basic_amount']
            + ($validated['extra_hrs_amount'] ?? 0)
            + ($validated['other_amounts'] ?? 0);

        $validated['updated_by'] = auth()->id();


        if (
            !empty($validated['vehicle_id']) &&
            (
                $booking->vehicle_id != $validated['vehicle_id'] ||
                $booking->pick_up_time != $validated['pick_up_time']
            )
        ) {

            if (
                !Booking::where(
                    'vehicle_id',
                    $validated['vehicle_id']
                )
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(
                    'pick_up_time',
                    $validated['pick_up_time']
                )
                ->doesntExist()
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Selected vehicle is not available at the requested pick-up time.'
                    );
            }
        }


        if (
            !empty($validated['driver_id']) &&
            (
                $booking->driver_id != $validated['driver_id'] ||
                $booking->pick_up_time != $validated['pick_up_time']
            )
        ) {

            if (
                !Booking::where(
                    'driver_id',
                    $validated['driver_id']
                )
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(
                    'pick_up_time',
                    $validated['pick_up_time']
                )
                ->doesntExist()
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Selected driver is not available at the requested pick-up time.'
                    );
            }
        }

        $booking->update($validated);

        return redirect()
            ->route('bookings.show', $booking)
            ->with(
                'success',
                'Booking updated successfully.'
            );
    }


    // Delete selected record
    public function destroy(Booking $booking)
    {
        if ($booking->status === 'completed') {

            return back()->with(
                'error',
                'Cannot delete completed bookings.'
            );
        }

        $booking->delete();

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Booking deleted successfully.'
            );
    }


    // Update record status
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([

            'status' =>
                'required|in:pending,confirmed,in_progress,completed,cancelled',

            'cancel_reason' =>
                'required_if:status,cancelled|nullable|string|max:500',
        ]);

        $transitions = [

            'pending' => [
                'confirmed',
                'cancelled'
            ],

            'confirmed' => [
                'in_progress',
                'cancelled'
            ],

            'in_progress' => [
                'completed',
                'cancelled'
            ],

            'completed' => [
                'cancelled'
            ],

            'cancelled' => [
                'pending'
            ],
        ];

        $currentStatus = $booking->status;

        $newStatus = $validated['status'];

        if (
            !isset($transitions[$currentStatus]) ||
            !in_array(
                $newStatus,
                $transitions[$currentStatus]
            )
        ) {

            return back()->with(
                'error',
                'Invalid booking status transition.'
            );
        }

        $booking->update([

            'status' => $newStatus,

            'cancel_reason' =>
                $newStatus === 'cancelled'
                    ? ($validated['cancel_reason'] ?? null)
                    : null,

            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with(
                'success',
                'Booking status updated successfully.'
            );
    }


    // Show today's bookings
    public function today()
    {
        $bookings = Booking::with([
            'vehicle',
            'driver'
        ])
        ->whereDate(
            'pick_up_time',
            today()
        )
        ->orderBy('pick_up_time')
        ->paginate(10);

        return view(
            'bookings.today',
            compact('bookings')
        );
    }


    // Show tomorrow's bookings
    public function tomorrow()
    {
        $bookings = Booking::with([
            'vehicle',
            'driver'
        ])
        ->whereDate(
            'pick_up_time',
            now()->addDay()
        )
        ->orderBy('pick_up_time')
        ->paginate(10);

        return view(
            'bookings.tomorrow',
            compact('bookings')
        );
    }


    // Download booking PDF
    public function downloadPdf(Booking $booking)
    {
        $booking->load([
            'vehicle',
            'driver'
        ]);

        $pdf = Pdf::loadView(
            'bookings.trip-sheet',
            compact('booking')
        )
        ->setPaper(
            'A4',
            'portrait'
        );

        return $pdf->download(
            "Invoice-Trip-Sheet-{$booking->id}.pdf"
        );
    }


    // View booking PDF
    public function viewPdf(Booking $booking)
    {
        $booking->load([
            'vehicle',
            'driver'
        ]);

        $pdf = Pdf::loadView(
            'bookings.trip-sheet',
            compact('booking')
        )
        ->setPaper(
            'A4',
            'portrait'
        );

        return $pdf->stream(
            "Invoice-Trip-Sheet-{$booking->id}.pdf"
        );
    }


    // Export records
    public function export(Request $request)
    {

        $query = Booking::with([
            'vehicle',
            'driver'
        ]);


        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        if ($request->filled('date_range')) {

            $today = now();

            switch ($request->date_range) {

                case 'today':

                    $query->whereDate(
                        'pick_up_time',
                        $today
                    );

                    break;

                case 'yesterday':

                    $query->whereDate(
                        'pick_up_time',
                        $today->copy()->subDay()
                    );

                    break;

                case 'this_week':

                    $query->whereBetween(
                        'pick_up_time',
                        [
                            $today->copy()->startOfWeek(),
                            $today->copy()->endOfWeek(),
                        ]
                    );

                    break;

                case 'last_week':

                    $query->whereBetween(
                        'pick_up_time',
                        [
                            $today
                                ->copy()
                                ->subWeek()
                                ->startOfWeek(),

                            $today
                                ->copy()
                                ->subWeek()
                                ->endOfWeek(),
                        ]
                    );

                    break;

                case 'this_month':

                    $query->whereBetween(
                        'pick_up_time',
                        [
                            $today->copy()->startOfMonth(),
                            $today->copy()->endOfMonth(),
                        ]
                    );

                    break;

                case 'last_month':

                    $query->whereBetween(
                        'pick_up_time',
                        [
                            $today
                                ->copy()
                                ->subMonth()
                                ->startOfMonth(),

                            $today
                                ->copy()
                                ->subMonth()
                                ->endOfMonth(),
                        ]
                    );

                    break;

                case 'this_year':

                    $query->whereBetween(
                        'pick_up_time',
                        [
                            $today->copy()->startOfYear(),
                            $today->copy()->endOfYear(),
                        ]
                    );

                    break;
            }

        } else {


            if ($request->filled('start_date')) {

                $query->whereDate(
                    'pick_up_time',
                    '>=',
                    $request->start_date
                );
            }


            if ($request->filled('end_date')) {

                $query->whereDate(
                    'pick_up_time',
                    '<=',
                    $request->end_date
                );
            }
        }


        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'guest_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'guest_contact_number',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'id',
                    'like',
                    "%{$search}%"
                );

            });
        }


        $bookings = $query
            ->orderBy(
                'pick_up_time',
                'desc'
            )
            ->get();


        $filename =
            'bookings-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';


        return response()->streamDownload(

            function () use ($bookings) {

                $file = fopen(
                    'php://output',
                    'w'
                );


                fwrite(
                    $file,
                    "\xEF\xBB\xBF"
                );


                fputcsv(
                    $file,
                    [
                        'Booking ID',
                        'Guest Name',
                        'Guest Contact',
                        'Pickup Time',
                        'Drop-off Time',
                        'Pickup Location',
                        'Drop-off Location',
                        'Vehicle',
                        'Driver',
                        'Status',
                        'Payment Method',
                        'Basic Amount (AED)',
                        'Extra Hours Amount (AED)',
                        'Other Amounts (AED)',
                        'Total Amount (AED)',
                        'Service Type',
                    ]
                );


                foreach ($bookings as $booking) {

                    fputcsv(
                        $file,
                        [

                            $booking->id,

                            $booking->guest_name,

                            $booking->guest_contact_number ?? '',

                            $booking->pick_up_time
                                ? $booking
                                    ->pick_up_time
                                    ->format('Y-m-d H:i')
                                : '',

                            $booking->drop_off_time
                                ? $booking
                                    ->drop_off_time
                                    ->format('Y-m-d H:i')
                                : '',

                            $booking->pick_up_location ?? '',

                            $booking->drop_off_location ?? '',

                            $booking->vehicle?->vehicle_name
                                ?? 'N/A',

                            $booking->driver?->name
                                ?? 'N/A',

                            $booking->status
                                ? ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $booking->status
                                    )
                                )
                                : 'N/A',

                            $booking->payment_method
                                ? ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $booking->payment_method
                                    )
                                )
                                : 'N/A',

                            number_format(
                                $booking->basic_amount ?? 0,
                                2,
                                '.',
                                ''
                            ),

                            number_format(
                                $booking->extra_hrs_amount ?? 0,
                                2,
                                '.',
                                ''
                            ),

                            number_format(
                                $booking->other_amounts ?? 0,
                                2,
                                '.',
                                ''
                            ),

                            number_format(
                                $booking->gross_total ?? 0,
                                2,
                                '.',
                                ''
                            ),

                            $booking->service ?? 'N/A',
                        ]
                    );
                }

                fclose($file);
            },

            $filename,

            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' .
                    $filename .
                    '"',

                'Cache-Control' =>
                    'no-cache, no-store, must-revalidate',

                'Pragma' =>
                    'no-cache',

                'Expires' =>
                    '0',
            ]
        );
    }
}