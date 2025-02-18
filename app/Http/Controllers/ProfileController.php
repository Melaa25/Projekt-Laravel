<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\TripBooking; 
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        
    
        // Pobierz wszystkie zapisane wycieczki użytkownika
        $bookedTrips = TripBooking::where('user_id', auth()->id())->with('trip')->get();

        // Przekaż zmienną do widoku
        return view('profile.edit', compact('bookedTrips'));
    
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    public function trips()
{
    $bookedTrips = TripBooking::where('user_id', auth()->id())->with('trip')->get();

    return view('profile.trips', compact('bookedTrips'));
}
public function cancelTrip($bookingId)
{
    $booking = TripBooking::where('id', $bookingId)
                          ->where('user_id', auth()->id())
                          ->first();

    if (!$booking) {
        return response()->json(['error' => 'Trip not found or you are not authorized to cancel it'], 404);
    }

    $booking->delete();

    return response()->json(['success' => 'Trip successfully canceled']);
}




public function tripDetails(TripBooking $booking)
{
    // Upewnij się, że użytkownik jest właścicielem rezerwacji
    if ($booking->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Pobierz dane wycieczki, dane osobowe i pakiety
    $trip = $booking->trip;
    $personalData = auth()->user()->personalData;
    $insurances = $booking->insurances; // Ubezpieczenia
    $internetPackages = $booking->internetPackages; // Pakiety internetowe

    return view('profile.trip-details', compact('trip', 'personalData', 'insurances', 'internetPackages'));
}


}
