<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\TripBooking;
use App\Models\Insurance;
use App\Models\Internet;

class TripBookingController extends Controller
{
    public function store($id)
    {
        $trip = Trip::findOrFail($id);

        // Sprawdź, czy użytkownik już zapisał się na tę wycieczkę
        $existingBooking = TripBooking::where('trip_id', $id)
                                       ->where('user_id', auth()->id())
                                       ->first();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You have already signed up for this trip.');
        }

        // Zapisz rezerwację z datą
        TripBooking::create([
            'trip_id' => $id,
            'user_id' => auth()->id(),
            'booking_date' => now()->toDateString(), // Dodaj datę zapisu
        ]);

        return redirect()->back()->with('success', 'You have successfully signed up for the trip!');
    }
    public function index()
{
    $trips = Trip::all(); // Pobierz listę wycieczek
    $insurancePackages = Insurance::all(); // Pobierz pakiety ubezpieczeń
    $internetPackages = Internet::all(); // Pobierz pakiety internetu

    return view('trips.index', compact('trips', 'insurancePackages', 'internetPackages'));
}
}
