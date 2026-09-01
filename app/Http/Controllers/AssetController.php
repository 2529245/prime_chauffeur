<?php

namespace App\Http\Controllers;

use App\Models\PosMachine;
use App\Models\MobilePhone;
use App\Models\SimCard;
use App\Models\AssetAssignment;
use App\Models\Staff;
use App\Models\Driver;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pos-machine-list', ['only' => ['posMachinesIndex', 'posMachinesShow']]);
        $this->middleware('permission:pos-machine-create', ['only' => ['posMachinesCreate', 'posMachinesStore']]);
        $this->middleware('permission:pos-machine-edit', ['only' => ['posMachinesEdit', 'posMachinesUpdate']]);
        $this->middleware('permission:pos-machine-delete', ['only' => ['posMachinesDestroy']]);
        $this->middleware('permission:mobile-phone-list', ['only' => ['mobilePhonesIndex', 'mobilePhonesShow']]);
        $this->middleware('permission:mobile-phone-create', ['only' => ['mobilePhonesCreate', 'mobilePhonesStore']]);
        $this->middleware('permission:mobile-phone-edit', ['only' => ['mobilePhonesEdit', 'mobilePhonesUpdate']]);
        $this->middleware('permission:mobile-phone-delete', ['only' => ['mobilePhonesDestroy']]);
        $this->middleware('permission:sim-card-list', ['only' => ['simCardsIndex', 'simCardsShow']]);
        $this->middleware('permission:sim-card-create', ['only' => ['simCardsCreate', 'simCardsStore']]);
        $this->middleware('permission:sim-card-edit', ['only' => ['simCardsEdit', 'simCardsUpdate']]);
        $this->middleware('permission:sim-card-delete', ['only' => ['simCardsDestroy']]);
        $this->middleware('permission:asset-assign', ['only' => ['assignAsset']]);
        $this->middleware('permission:asset-return', ['only' => ['returnAsset']]);
    }

    // Show POS machines
    public function posMachinesIndex()
    {
        $posMachines = PosMachine::orderBy('machine_id')->get();

        return view('assets.pos-machines.index', compact('posMachines'));
    }

    // Show POS create form
    public function posMachinesCreate()
    {
        return view('assets.pos-machines.create');
    }

    // Save new POS machine
    public function posMachinesStore(Request $request)
    {
        $validated = $request->validate([
            'machine_id' => 'required|string|max:255|unique:pos_machines',
            'machine_model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'status' => 'required|in:active,inactive,maintenance',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        PosMachine::create($validated);

        return redirect()->route('assets.pos-machines.index')->with('success', 'POS Machine created successfully.');
    }

    // Show POS details
    public function posMachinesShow(PosMachine $posMachine)
    {
        $posMachine->load(['assetAssignments' => function ($query) {
            $query->with(['assignable']);
        }]);

        $staff = Staff::where('status', 'active')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('assets.pos-machines.show', compact('posMachine', 'staff', 'drivers'));
    }

    // Show POS edit form
    public function posMachinesEdit(PosMachine $posMachine)
    {
        return view('assets.pos-machines.edit', compact('posMachine'));
    }

    // Update POS machine
    public function posMachinesUpdate(Request $request, PosMachine $posMachine)
    {
        $validated = $request->validate([
            'machine_id' => 'required|string|max:255|unique:pos_machines,machine_id,' . $posMachine->id,
            'machine_model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_expiry' => 'nullable|date',
            'status' => 'required|in:active,inactive,maintenance',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $posMachine->update($validated);

        return redirect()->route('assets.pos-machines.index')->with('success', 'POS Machine updated successfully.');
    }

    // Delete POS machine
    public function posMachinesDestroy(PosMachine $posMachine)
    {
        $posMachine->delete();

        return redirect()->route('assets.pos-machines.index')->with('success', 'POS Machine deleted successfully.');
    }

    // Show mobile phones
    public function mobilePhonesIndex()
    {
        $mobilePhones = MobilePhone::orderBy('phone_model')->get();

        return view('assets.mobile-phones.index', compact('mobilePhones'));
    }

    // Show phone create form
    public function mobilePhonesCreate()
    {
        return view('assets.mobile-phones.create');
    }

    // Save new mobile phone
    public function mobilePhonesStore(Request $request)
    {
        $validated = $request->validate([
            'phone_model' => 'required|string|max:255',
            'imei_number' => 'nullable|string|max:255|unique:mobile_phones',
            'phone_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,broken,retired',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        MobilePhone::create($validated);

        return redirect()->route('assets.mobile-phones.index')->with('success', 'Mobile Phone created successfully.');
    }

    // Show phone details
    public function mobilePhonesShow(MobilePhone $mobilePhone)
    {
        $mobilePhone->load(['assetAssignments' => function ($query) {
            $query->with(['assignable']);
        }]);

        $staff = Staff::where('status', 'active')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('assets.mobile-phones.show', compact('mobilePhone', 'staff', 'drivers'));
    }

    // Show phone edit form
    public function mobilePhonesEdit(MobilePhone $mobilePhone)
    {
        return view('assets.mobile-phones.edit', compact('mobilePhone'));
    }

    // Update mobile phone
    public function mobilePhonesUpdate(Request $request, MobilePhone $mobilePhone)
    {
        $validated = $request->validate([
            'phone_model' => 'required|string|max:255',
            'imei_number' => 'nullable|string|max:255|unique:mobile_phones,imei_number,' . $mobilePhone->id,
            'phone_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,broken,retired',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $mobilePhone->update($validated);

        return redirect()->route('assets.mobile-phones.index')->with('success', 'Mobile Phone updated successfully.');
    }

    // Delete mobile phone
    public function mobilePhonesDestroy(MobilePhone $mobilePhone)
    {
        $mobilePhone->delete();

        return redirect()->route('assets.mobile-phones.index')->with('success', 'Mobile Phone deleted successfully.');
    }

    // Show SIM cards
    public function simCardsIndex()
    {
        $simCards = SimCard::orderBy('sim_number')->get();

        return view('assets.sim-cards.index', compact('simCards'));
    }

    // Show SIM create form
    public function simCardsCreate()
    {
        return view('assets.sim-cards.create');
    }

    // Save new SIM card
    public function simCardsStore(Request $request)
    {
        $validated = $request->validate([
            'sim_number' => 'required|string|max:255|unique:sim_cards',
            'telecom_provider' => 'nullable|string|max:255',
            'plan_details' => 'nullable|string|max:255',
            'activation_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        SimCard::create($validated);

        return redirect()->route('assets.sim-cards.index')->with('success', 'SIM Card created successfully.');
    }

    // Show SIM details
    public function simCardsShow(SimCard $simCard)
    {
        $simCard->load(['assetAssignments' => function ($query) {
            $query->with(['assignable']);
        }]);

        $staff = Staff::where('status', 'active')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('assets.sim-cards.show', compact('simCard', 'staff', 'drivers'));
    }

    // Show SIM edit form
    public function simCardsEdit(SimCard $simCard)
    {
        return view('assets.sim-cards.edit', compact('simCard'));
    }

    // Update SIM card
    public function simCardsUpdate(Request $request, SimCard $simCard)
    {
        $validated = $request->validate([
            'sim_number' => 'required|string|max:255|unique:sim_cards,sim_number,' . $simCard->id,
            'telecom_provider' => 'nullable|string|max:255',
            'plan_details' => 'nullable|string|max:255',
            'activation_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();

        $simCard->update($validated);

        return redirect()->route('assets.sim-cards.index')->with('success', 'SIM Card updated successfully.');
    }

    // Delete SIM card
    public function simCardsDestroy(SimCard $simCard)
    {
        $simCard->delete();

        return redirect()->route('assets.sim-cards.index')->with('success', 'SIM Card deleted successfully.');
    }

    // Assign asset to user
    public function assignAsset(Request $request)
    {
        $validated = $request->validate([
            'assignable_type' => 'required|in:staff,driver',
            'assignable_id' => 'required|integer',
            'asset_type' => 'required|in:pos_machine,mobile_phone,sim_card',
            'asset_id' => 'required|integer',
            'date_assigned' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $assignableModel = match ($validated['assignable_type']) {
            'staff' => Staff::class,
            'driver' => Driver::class,
        };

        $assignableExists = $assignableModel::where('id', $validated['assignable_id'])->exists();

        if (!$assignableExists) {
            return redirect()->back()->with('error', 'Selected ' . $validated['assignable_type'] . ' does not exist.');
        }

        $assetModel = match ($validated['asset_type']) {
            'pos_machine' => PosMachine::class,
            'mobile_phone' => MobilePhone::class,
            'sim_card' => SimCard::class,
        };

        $assetExists = $assetModel::where('id', $validated['asset_id'])->exists();

        if (!$assetExists) {
            return redirect()->back()->with('error', 'Selected asset does not exist.');
        }

// Check current assignment
        $existingAssignment = AssetAssignment::where('asset_type', $validated['asset_type'])->where('asset_id', $validated['asset_id'])->whereNull('date_returned')->exists();

        if ($existingAssignment) {
            return redirect()->back()->with('error', 'This asset is already assigned to someone.');
        }

        $validated['created_by'] = auth()->id();

        AssetAssignment::create($validated);

        return redirect()->back()->with('success', 'Asset assigned successfully.');
    }

    // Mark asset returned
    public function returnAsset(AssetAssignment $assignment)
    {
        if (!$assignment || $assignment->date_returned) {
            return redirect()->back()->with('error', 'Invalid assignment or asset already returned.');
        }

        $assignment->update(['date_returned' => now(), 'updated_by' => auth()->id()]);

        return redirect()->back()->with('success', 'Asset returned successfully.');
    }
}