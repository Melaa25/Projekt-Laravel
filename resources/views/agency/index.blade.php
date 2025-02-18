@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Trips</h1>

    <!-- Search Form -->
    <form action="{{ route('trips.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    placeholder="Search by trip name" 
                    value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <input 
                    type="number" 
                    name="price" 
                    class="form-control" 
                    placeholder="Max Price" 
                    value="{{ request('price') }}">
            </div>
            <div class="col-md-3">
                <input 
                    type="date" 
                    name="start_date" 
                    class="form-control" 
                    placeholder="Start Date" 
                    value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Create New Trip Button (only for employees) -->
    @auth
        @if(auth()->user()->role === 'employee')
            <a href="{{ route('trips.create') }}" class="btn btn-success mb-4">Create New Trip</a>
        @endif
    @endauth

    <!-- Display Trips -->
    <div class="row">
        @if($trips->isEmpty())
            <p class="text-center">No trips found matching your criteria.</p>
        @else
            @foreach($trips as $trip)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $trip->name }}</h5>
                        <p class="card-text">Price: ${{ $trip->price }}</p>
                        <p class="card-text">Start Date: {{ $trip->start_date }}</p>
                        <p class="card-text">End Date: {{ $trip->end_date }}</p>

                        <!-- Buttons -->
                        <a href="{{ route('trips.show', $trip->id) }}" class="btn btn-info">Details</a>

                        @auth
                            <!-- Modal Trigger -->
                            <button 
                                type="button" 
                                class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#personalDataModal" 
                                data-trip-id="{{ $trip->id }}">
                                Sign Up
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary">Sign Up</a>
                        @endauth

                        @if(auth()->user() && auth()->user()->role === 'employee')
                            <!-- Show the edit button only for employees -->
                            <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-warning">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $trips->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="personalDataModal" tabindex="-1" aria-labelledby="personalDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personalDataModalLabel">Enter Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="personalDataForm" action="{{ route('trips.book') }}" method="POST">
                @csrf
                <input type="hidden" name="trip_id" id="tripIdInput">

                <!-- Personal Data Section -->
                <div id="personalDataSection">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Date of Birth</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="showPackages">Next</button>
                    </div>
                </div>

                <!-- Packages Section -->
                <div id="packagesSection" style="display: none;">
                    <div class="modal-body">
                        <h5 class="mb-3">You can add extra packages</h5>

                        <h6>Insurance Packages</h6>
                        @foreach($insurancePackages as $insurance)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="insurance_packages[]" value="{{ $insurance->id }}" id="insurance-{{ $insurance->id }}">
                            <label class="form-check-label" for="insurance-{{ $insurance->id }}">
                                {{ $insurance->name }} ({{ $insurance->price }} $)
                            </label>
                        </div>
                        @endforeach

                        <h6 class="mt-3">Internet Packages</h6>
                        @foreach($internetPackages as $internet)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="internet_packages[]" value="{{ $internet->id }}" id="internet-{{ $internet->id }}">
                            <label class="form-check-label" for="internet-{{ $internet->id }}">
                                {{ $internet->name }} ({{ $internet->price }} $)
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="backToPersonalData">Back</button>
                        <button type="submit" class="btn btn-success">Confirm and Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const showPackagesButton = document.getElementById("showPackages");
        const backToPersonalDataButton = document.getElementById("backToPersonalData");
        const personalDataSection = document.getElementById("personalDataSection");
        const packagesSection = document.getElementById("packagesSection");

        // Move to the packages section
        showPackagesButton.addEventListener("click", function () {
            const form = document.getElementById("personalDataForm");
            if (form.checkValidity()) {
                personalDataSection.style.display = "none";
                packagesSection.style.display = "block";
            } else {
                form.reportValidity();
            }
        });

        // Go back to the personal data section
        backToPersonalDataButton.addEventListener("click", function () {
            packagesSection.style.display = "none";
            personalDataSection.style.display = "block";
        });
    });
</script>

@endsection
