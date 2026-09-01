@extends('layouts.app')

@section('title', 'Edit SIM Card')
@section('header', 'Edit SIM Card')

@section('content')

<div class="assets-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-sim-card"></i>
                Edit SIM Card: {{ $simCard->sim_number }}
            </h1>
            <div class="header-actions">
                <a href="{{ route('assets.sim-cards.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All SIM Cards
                </a>
                <a href="{{ route('assets.sim-cards.show', $simCard->id) }}" class="btn btn-info ml-2">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('assets.sim-cards.update', $simCard->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sim_number">SIM Number *</label>
                                    <input type="text" class="form-control @error('sim_number') is-invalid @enderror" 
                                           id="sim_number" name="sim_number" value="{{ old('sim_number', $simCard->sim_number) }}" required
                                           placeholder="Enter SIM card number">
                                    @error('sim_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telecom_provider">Telecom Provider</label>
                                    <select class="form-control @error('telecom_provider') is-invalid @enderror" 
                                            id="telecom_provider" name="telecom_provider">
                                        <option value="">Select Provider</option>
                                        <option value="Etisalat" {{ old('telecom_provider', $simCard->telecom_provider) == 'Etisalat' ? 'selected' : '' }}>Etisalat</option>
                                        <option value="Du" {{ old('telecom_provider', $simCard->telecom_provider) == 'Du' ? 'selected' : '' }}>Du</option>
                                        <option value="Virgin Mobile" {{ old('telecom_provider', $simCard->telecom_provider) == 'Virgin Mobile' ? 'selected' : '' }}>Virgin Mobile</option>
                                        <option value="Other" {{ old('telecom_provider', $simCard->telecom_provider) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('telecom_provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_details">Package Amount</label>
                                    <input type="text" class="form-control @error('plan_details') is-invalid @enderror" 
                                           id="plan_details" name="plan_details" value="{{ old('plan_details', $simCard->plan_details) }}"
                                           placeholder="e.g., 5GB Data, 100 mins">
                                    @error('plan_details')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="activation_date">Activation Date</label>
                                    <input type="date" class="form-control @error('activation_date') is-invalid @enderror" 
                                           id="activation_date" name="activation_date" value="{{ old('activation_date', $simCard->activation_date ? $simCard->activation_date->format('Y-m-d') : '') }}">
                                    @error('activation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $simCard->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $simCard->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ old('status', $simCard->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" placeholder="Any additional notes about this SIM card">{{ old('notes', $simCard->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-4">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('assets.sim-cards.index') }}" class="btn btn-secondary mr-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update SIM Card
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection