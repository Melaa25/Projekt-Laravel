<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalData;
use App\Models\TripBooking;
use App\Models\InsuranceBooking;
use App\Models\InternetPackageBooking;

class PersonalDataController extends Controller
{
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'trip_id' => 'required|exists:trips,id',
            'insurance_packages' => 'array', // Optional
            'insurance_packages.*' => 'exists:insurances,id',
            'internet_packages' => 'array', // Optional
            'internet_packages.*' => 'exists:internet_packages,id',
        ]);

        $userId = auth()->id();
        $tripId = $validated['trip_id'];

        // Check if the user is already signed up for this trip
        $existingBooking = TripBooking::where('user_id', $userId)
            ->where('trip_id', $tripId)
            ->first();

        if ($existingBooking) {
            return redirect()->route('home')->with('error', 'You are already signed up for this trip.');
        }

        // Save or update personal data
        PersonalData::updateOrCreate(
            ['user_id' => $userId],
            [
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'phone' => $validated['phone'],
                'birth_date' => $validated['birth_date'],
            ]
        );

        // Save trip booking
        $tripBooking = TripBooking::create([
            'trip_id' => $tripId,
            'user_id' => $userId,
            'booking_date' => now(),
        ]);

        // Save selected insurance packages
        if (!empty($validated['insurance_packages'])) {
            foreach ($validated['insurance_packages'] as $insuranceId) {
                InsuranceBooking::create([
                    'booking_id' => $tripBooking->id,
                    'insurance_id' => $insuranceId,
                ]);
            }
        }

        // Save selected internet packages
        if (!empty($validated['internet_packages'])) {
            foreach ($validated['internet_packages'] as $internetPackageId) {
                InternetPackageBooking::create([
                    'booking_id' => $tripBooking->id,
                    'internet_package_id' => $internetPackageId,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'You have successfully signed up for the trip!');
    }
}
