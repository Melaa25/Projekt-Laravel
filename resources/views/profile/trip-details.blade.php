@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trip Details</h1>

    <h2>Trip Information</h2>
    <p><strong>Name:</strong> {{ $trip->name }}</p>
    <p><strong>Start Date:</strong> {{ $trip->start_date }}</p>
    <p><strong>End Date:</strong> {{ $trip->end_date }}</p>
    <p><strong>Description:</strong> {{ $trip->description }}</p>

    <h2>Your Personal Information</h2>
    <p><strong>Address:</strong> {{ $personalData->address ?? 'N/A' }}</p>
    <p><strong>City:</strong> {{ $personalData->city ?? 'N/A' }}</p>
    <p><strong>Postal Code:</strong> {{ $personalData->postal_code ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $personalData->phone ?? 'N/A' }}</p>
    <p><strong>Date of Birth:</strong> {{ $personalData->birth_date ?? 'N/A' }}</p>

    <h2>Selected Packages</h2>
    <h3>Insurance Packages</h3>
    @if($insurances->isEmpty())
        <p>No insurance packages selected.</p>
    @else
        <ul>
            @foreach($insurances as $insurance)
                <li>{{ $insurance->name }} - ${{ $insurance->price }}</li>
            @endforeach
        </ul>
    @endif

    <h3>Internet Packages</h3>
    @if($internetPackages->isEmpty())
        <p>No internet packages selected.</p>
    @else
        <ul>
            @foreach($internetPackages as $internetPackage)
                <li>{{ $internetPackage->name }} - ${{ $internetPackage->price }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('profile.edit') }}" class="btn btn-secondary mt-3">Back to My Trips</a>
</div>
@endsection
