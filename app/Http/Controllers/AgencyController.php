<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Category;
use App\Models\Guide;
use App\Models\Insurance;
use App\Models\InternetPackage;
use App\Models\InternetPackageBooking;
use App\Models\InsuranceBooking;
use App\Models\PersonalData;
use App\Models\Review;
use App\Models\TripBooking;

class AgencyController extends Controller
{
    
    public function index(Request $request)
{
    $trips = Trip::with('category')
        ->when($request->name, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($request->price, function ($query, $price) {
            $query->where('price', '<=', $price);
        })
        ->when($request->start_date, function ($query, $start_date) {
            $query->where('start_date', '>=', $start_date);
        })
        ->orderBy('start_date', 'asc')
        ->paginate(9);

    $insurancePackages = Insurance::all();
    $internetPackages = InternetPackage::all();

    return view('agency.index', compact('trips', 'insurancePackages', 'internetPackages'));
}



    public function show($id)
    {
        $trip = Trip::with(['category', 'guide', 'reviews.user'])->findOrFail($id);
        $alreadyBooked = auth()->check() && TripBooking::where('trip_id', $id)
            ->where('user_id', auth()->id())
            ->exists();

        $insurancePackages = Insurance::all();
        $internetPackages = InternetPackage::all();

        return view('agency.show', compact('trip', 'alreadyBooked', 'insurancePackages', 'internetPackages'));
    }

    public function bookTrip(Request $request)
{
    $validated = $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'phone' => 'required|string|max:20',
        'birth_date' => 'required|date',
    ]);

    $userId = auth()->id();
    $tripId = $request->input('trip_id');

    // Check if the user is already signed up for this trip
    $existingBooking = TripBooking::where('user_id', $userId)
        ->where('trip_id', $tripId)
        ->first();

    if ($existingBooking) {
        return redirect()->route('agency.index')->with('error', 'You are already signed up for this trip.');
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

    // Create a new trip booking
    $tripBooking = TripBooking::create([
        'trip_id' => $tripId,
        'user_id' => $userId,
    ]);

    // Save selected insurance packages
    if ($request->has('insurance_packages') && is_array($request->insurance_packages)) {
        foreach ($request->input('insurance_packages') as $insuranceId) {
            InsuranceBooking::create([
                'booking_id' => $tripBooking->id,
                'insurance_id' => $insuranceId,
            ]);
        }
    }

    // Save selected internet packages
    if ($request->has('internet_packages') && is_array($request->internet_packages)) {
        foreach ($request->input('internet_packages') as $internetPackageId) {
            InternetPackageBooking::create([
                'booking_id' => $tripBooking->id,
                'internet_package_id' => $internetPackageId,
            ]);
        }
    }

    return response()->json(['success' => true]);
}


    public function create()
    {
        $categories = Category::all();
        $guides = Guide::all();

        return view('agency.create', compact('categories', 'guides'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        Trip::create($validated);

        return redirect()->route('trips.index')->with('success', 'Trip created successfully!');
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $categories = Category::all();
        $guides = Guide::all();

        return view('agency.edit', compact('trip', 'categories', 'guides'));
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully!');
    }

    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->route('agency.index')->with('success', 'Trip deleted successfully!');
    }
    public function packages()
{
    $insurancePackages = Insurance::all();
    $internetPackages = InternetPackage::all();

    return view('agency.packages', compact('insurancePackages', 'internetPackages'));
}

}
