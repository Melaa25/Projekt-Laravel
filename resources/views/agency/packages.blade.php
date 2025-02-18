@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Available Packages</h1>

    <!-- Insurance Packages Section -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">Insurance Packages</h2>
        </div>
        <div class="card-body">
            @if($insurancePackages->isEmpty())
                <p class="text-muted">No insurance packages available.</p>
            @else
                <div class="row">
                    @foreach($insurancePackages as $insurance)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $insurance->name }}</h5>
                                <p class="card-text text-muted">Price: ${{ $insurance->price }}</p>
                                <p class="card-text">{{ $insurance->description ?? 'No description available.' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Internet Packages Section -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h2 class="h4 mb-0">Internet Packages</h2>
        </div>
        <div class="card-body">
            @if($internetPackages->isEmpty())
                <p class="text-muted">No internet packages available.</p>
            @else
                <div class="row">
                    @foreach($internetPackages as $internet)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $internet->name }}</h5>
                                <p class="card-text text-muted">Price: ${{ $internet->price }}</p>
                                <p class="card-text">{{ $internet->description ?? 'No description available.' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
