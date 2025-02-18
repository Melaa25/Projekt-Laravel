@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Profile</h1>

    <!-- Tabs navigation -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="trips-tab" data-bs-toggle="tab" data-bs-target="#trips" type="button" role="tab" aria-controls="trips" aria-selected="true">My Trips</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="profileTabsContent">
        <!-- My Trips Tab -->
        <div class="tab-pane fade show active" id="trips" role="tabpanel" aria-labelledby="trips-tab">
            <h2>My Trips</h2>
            @if($bookedTrips->isEmpty())
                <p>You have not signed up for any trips yet.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookedTrips as $booking)
                        <tr id="trip-row-{{ $booking->id }}">
                            <td>{{ $booking->trip->name }}</td>
                            <td>{{ $booking->trip->start_date }}</td>
                            <td>{{ $booking->trip->end_date }}</td>
                            <td>
                                <!-- Show Details Button -->
                                <a href="{{ route('profile.trips.details', $booking->id) }}" class="btn btn-info btn-sm">
                                    Show Details
                                </a>
                                <!-- Cancel Button -->
                                <button 
                                    class="btn btn-danger btn-sm cancel-trip-btn" 
                                    data-id="{{ $booking->id }}">
                                    Cancel
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Settings Tab -->
        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <h2>Edit Profile</h2>

            <!-- Update Profile Form -->
            <form id="update-profile-form" action="{{ route('profile.update') }}" method="POST" class="mb-5">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>

                <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update</button>
            </form>

            <!-- Change Password Form -->
            <h2>Change Password</h2>
            <form id="update-password-form" action="{{ route('password.update') }}" method="POST" class="mb-5">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="button" class="btn btn-primary" onclick="confirmPasswordChange()">Change Password</button>
            </form>

            <!-- Delete Account Form -->
            <h2>Delete Account</h2>
            <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-danger">Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.</p>
                <button type="button" class="btn btn-danger" onclick="confirmAccountDeletion()">Delete Account</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 and Cancel Trip JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Show the "My Trips" tab on load
        const tripsTab = document.querySelector('#trips-tab');
        tripsTab.click();

        // Handle Cancel Button with SweetAlert
        document.querySelectorAll('.cancel-trip-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tripId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to cancel this trip.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/profile/trips/${tripId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Canceled!', data.success, 'success');
                                document.getElementById(`trip-row-${tripId}`).remove();

                                if (document.querySelectorAll('tbody tr').length === 0) {
                                    document.querySelector('#trips').innerHTML = `
                                        <h2>My Trips</h2>
                                        <p>You have not signed up for any trips yet.</p>
                                    `;
                                }
                            } else {
                                Swal.fire('Error!', data.error || 'An error occurred.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'An error occurred while canceling the trip.', 'error');
                        });
                    }
                });
            });
        });
    });

    function confirmUpdate() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to update your profile.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-profile-form').submit();
            }
        });
    }

    function confirmPasswordChange() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to change your password.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-password-form').submit();
            }
        });
    }

    function confirmAccountDeletion() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Your account and all related data will be permanently deleted. This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-account-form').submit();
            }
        });
    }
</script>
@endsection
