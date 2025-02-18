<div class="container">
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
                        <button class="btn btn-danger btn-sm cancel-trip-btn" data-id="{{ $booking->id }}">Cancel</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.cancel-trip-btn').forEach(button => {
        button.addEventListener('click', function () {
            const tripId = this.getAttribute('data-id'); // Pobierz ID wycieczki

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
                    // Wyślij żądanie do serwera
                    fetch(`/profile/trips/${tripId}/cancel`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to cancel trip');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Wyświetl potwierdzenie sukcesu
                            Swal.fire(
                                'Canceled!',
                                data.success,
                                'success'
                            );

                            // Usuń wiersz wycieczki z tabeli
                            document.getElementById(`trip-row-${tripId}`).remove();

                            // Jeśli tabela pusta, pokaż wiadomość
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                document.querySelector('.container').innerHTML = `
                                    <h2>My Trips</h2>
                                    <p>You have not signed up for any trips yet.</p>
                                `;
                            }
                        } else {
                            Swal.fire(
                                'Error!',
                                data.error || 'An error occurred.',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'Error!',
                            'An error occurred while canceling the trip.',
                            'error'
                        );
                    });
                }
            });
        });
    });
</script>
