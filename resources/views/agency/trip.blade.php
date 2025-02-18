@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $trip->name }}</h1>
    <p>Category: {{ $trip->category->name ?? 'No Category' }}</p>
    <p>Price: ${{ $trip->price }}</p>
    <p>Start Date: {{ $trip->start_date }}</p>
    <p>End Date: {{ $trip->end_date }}</p>
    <p>Description: {{ $trip->description }}</p>

    <h2>Guide</h2>
    @if ($trip->guide)
    <p>{{ $trip->guide->first_name }} {{ $trip->guide->last_name }}</p>
    <p>Email: {{ $trip->guide->email }}</p>
    @else
    <p>No guide assigned.</p>
    @endif
</div>
@endsection
