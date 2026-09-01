<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:driver-list')->only(['index', 'show']);
        $this->middleware('permission:driver-create')->only(['create', 'store']);
        $this->middleware('permission:driver-edit')->only(['edit', 'update']);
        $this->middleware('permission:driver-delete')->only(['destroy']);
        $this->middleware('permission:driver-export')->only(['exportBookings']);
    }

    // Show all records
    public function index()
    {
        $drivers = Driver::with('vehicles')
            ->latest()
            ->get();

        return view('drivers.index', compact('drivers'));
    }

    // Show create form
    public function create()
    {
        $vehicles = Vehicle::where('status', 'active')->get();

        return view('drivers.create', compact('vehicles'));
    }

    // Save new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'exists:vehicles,id',
            'primary_vehicle' => 'nullable|exists:vehicles,id',
        ]);

        $validated['created_by'] = auth()->id();

        $driver = Driver::create($validated);

        $this->syncVehicles($driver, $request);

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    // Show record details
    public function show(Driver $driver)
    {
        $driver->load([
            'vehicles',
            'bookings.vehicle',
            'documents',
            'creator',
            'updater',
        ]);

        return view('drivers.show', compact('driver'));
    }

    // Show edit form
    public function edit(Driver $driver)
    {
        $vehicles = Vehicle::where('status', 'active')->get();

        $driver->load('vehicles');

        return view('drivers.edit', compact('driver', 'vehicles'));
    }

    // Update existing record
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
            'vehicles' => 'nullable|array',
            'vehicles.*' => 'exists:vehicles,id',
            'primary_vehicle' => 'nullable|exists:vehicles,id',
        ]);

        $validated['updated_by'] = auth()->id();

        $driver->update($validated);

        $this->syncVehicles($driver, $request);

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    // Delete selected record
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }

    // Export booking history
    public function exportBookings(Driver $driver)
    {
        $bookings = $driver->bookings()
            ->with('vehicle')
            ->latest('pick_up_time')
            ->get();

        $fileName = 'driver-bookings-' . str_replace(' ', '-', $driver->name) . '-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($bookings, $driver) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Driver',
                $driver->name,
                'Contact',
                $driver->contact_no,
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
                'Vehicle',
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
                    $booking->vehicle?->vehicle_name ?? 'N/A',
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

    // Sync assigned vehicles
    private function syncVehicles(Driver $driver, Request $request)
    {
        $vehicles = [];

        foreach ($request->input('vehicles', []) as $vehicleId) {
            $vehicles[$vehicleId] = [
                'is_primary' => $vehicleId == $request->primary_vehicle,
            ];
        }

        $driver->vehicles()->sync($vehicles);
    }
}