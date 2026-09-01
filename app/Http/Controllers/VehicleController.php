<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:vehicle-list')->only(['index', 'show']);
        $this->middleware('permission:vehicle-create')->only(['create', 'store']);
        $this->middleware('permission:vehicle-edit')->only(['edit', 'update']);
        $this->middleware('permission:vehicle-delete')->only(['destroy']);
        $this->middleware('permission:vehicle-export')->only(['exportBookings']);
    }

    // Show all records
    public function index()
    {
        $vehicles = Vehicle::with('drivers')
            ->latest()
            ->get();

        return view('vehicles.index', compact('vehicles'));
    }

    // Show create form
    public function create()
    {
        $drivers = Driver::where('status', 'active')->get();

        return view('vehicles.create', compact('drivers'));
    }

    // Save new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'vehicle_plate_no' => 'required|string|max:255|unique:vehicles,vehicle_plate_no',
            'vehicle_model' => 'required|string|max:255',
            'vehicle_color' => 'required|string|max:255',
            'mulkiya_expiry_date' => 'nullable|date',
            'status' => 'required|in:active,maintenance,inactive',
            'drivers' => 'nullable|array',
            'drivers.*' => 'exists:drivers,id',
            'primary_driver' => 'nullable|exists:drivers,id',
        ]);

        $validated['created_by'] = auth()->id();

        $vehicle = Vehicle::create($validated);

        $this->syncDrivers($vehicle, $request);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    // Show record details
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['drivers', 'bookings.driver', 'bookings.vehicle']);

        return view('vehicles.show', compact('vehicle'));
    }

    // Show edit form
    public function edit(Vehicle $vehicle)
    {
        $drivers = Driver::where('status', 'active')->get();

        $vehicle->load('drivers');

        return view('vehicles.edit', compact('vehicle', 'drivers'));
    }

    // Update existing record
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'vehicle_name' => 'required|string|max:255',
            'vehicle_plate_no' => 'required|string|max:255|unique:vehicles,vehicle_plate_no,' . $vehicle->id,
            'vehicle_model' => 'required|string|max:255',
            'vehicle_color' => 'required|string|max:255',
            'mulkiya_expiry_date' => 'nullable|date',
            'status' => 'required|in:active,maintenance,inactive',
            'drivers' => 'nullable|array',
            'drivers.*' => 'exists:drivers,id',
            'primary_driver' => 'nullable|exists:drivers,id',
        ]);

        $validated['updated_by'] = auth()->id();

        $vehicle->update($validated);

        $this->syncDrivers($vehicle, $request);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    // Delete selected record
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    // Export booking history
    public function exportBookings(Vehicle $vehicle)
    {
        $bookings = $vehicle->bookings()
            ->with('driver')
            ->latest('pick_up_time')
            ->get();

        $fileName = 'bookings-' . $vehicle->vehicle_plate_no . '-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($bookings, $vehicle) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Vehicle',
                $vehicle->vehicle_name,
                'Plate',
                $vehicle->vehicle_plate_no,
                'Export Date',
                now()->format('Y-m-d H:i:s'),
            ]);

            fputcsv($handle, []);

            fputcsv($handle, [
                'Booking ID',
                'Guest Name',
                'Guest Contact',
                'Pickup Time',
                'Drop-off Time',
                'Pickup Location',
                'Drop-off Location',
                'Driver',
                'Status',
                'Payment Method',
                'Service Type',
                'Basic Amount',
                'Extra Hours',
                'Extra Hours Amount',
                'Other Amounts',
                'Total Amount',
                'Created Date',
            ]);

            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->id,
                    $booking->guest_name,
                    $booking->guest_contact_number,
                    $booking->pick_up_time?->format('Y-m-d H:i'),
                    $booking->drop_off_time?->format('Y-m-d H:i'),
                    $booking->pick_up_location,
                    $booking->drop_off_location,
                    $booking->driver?->name ?? 'N/A',
                    ucfirst($booking->status),
                    ucfirst(str_replace('_', ' ', $booking->payment_method)),
                    $booking->service,
                    $booking->basic_amount,
                    $booking->no_of_extra_hrs,
                    $booking->extra_hrs_amount,
                    $booking->other_amounts,
                    $booking->gross_total,
                    $booking->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    // Sync assigned drivers
    private function syncDrivers(Vehicle $vehicle, Request $request)
    {
        $drivers = [];

        foreach ($request->input('drivers', []) as $driverId) {
            $drivers[$driverId] = [
                'is_primary' => $driverId == $request->primary_driver,
            ];
        }

        $vehicle->drivers()->sync($drivers);
    }
}