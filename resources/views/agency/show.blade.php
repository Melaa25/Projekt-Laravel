@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $trip->name }}</h1>

    <!-- Trip Details -->
    <div class="row">
        <div class="col-md-6">
            <h3>Trip Details</h3>
            <p><strong>Price:</strong> ${{ $trip->price }}</p>
            <p><strong>Start Date:</strong> {{ $trip->start_date }}</p>
            <p><strong>End Date:</strong> {{ $trip->end_date }}</p>
            <p><strong>Description:</strong> {{ $trip->description }}</p>
        </div>

        <!-- Guide Details -->
        @if($trip->guide)
        <div class="col-md-6">
            <h3>Guide Information</h3>
            <p><strong>Name:</strong> {{ $trip->guide->name }}</p>
            <p><strong>Email:</strong> {{ $trip->guide->email }}</p>
            <p><strong>Phone:</strong> {{ $trip->guide->phone }}</p>
            <p><strong>Experience:</strong> {{ $trip->guide->experience }} years</p>
        </div>
        @endif
    </div>

    <!-- Buttons -->
    <div class="mt-4">
        @auth
            @if($alreadyBooked)
                <p class="text-success">You are already signed up for this trip.</p>
            @else
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#personalDataModal">
                    Sign Up
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-secondary">Sign Up</a>
        @endauth
        <a href="{{ route('home') }}" class="btn btn-light mt-3">Back to Home</a>
    </div>

    <!-- Reviews Section -->
    <div class="mt-5">
        <h3>Reviews</h3>
        @if($trip->reviews->isEmpty())
            <p>No reviews yet. Be the first to leave a review!</p>
        @else
            @foreach($trip->reviews as $review)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rating: {{ $review->rating }} / 5</h5>
                    <p class="card-text">{{ $review->comment }}</p>
                    <p class="text-muted small">By {{ $review->user->name }} on {{ $review->created_at->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <!-- Add Review Form -->
    @auth
    <div class="mt-4">
        <h4>Leave a Review</h4>
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="">Select a rating</option>
                    <option value="1">1 - Very Poor</option>
                    <option value="2">2 - Poor</option>
                    <option value="3">3 - Average</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your review..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
    @endauth
</div>

<!-- Personal Data Modal -->
<div class="modal fade" id="personalDataModal" tabindex="-1" aria-labelledby="personalDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personalDataModalLabel">Enter Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="personalDataForm" action="{{ route('personal_data.store') }}" method="POST">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                
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

        showPackagesButton.addEventListener("click", function () {
            const form = document.getElementById("personalDataForm");
            if (form.checkValidity()) {
                personalDataSection.style.display = "none";
                packagesSection.style.display = "block";
            } else {
                form.reportValidity();
            }
        });

        backToPersonalDataButton.addEventListener("click", function () {
            packagesSection.style.display = "none";
            personalDataSection.style.display = "block";
        });
    });
</script>
@endsection
