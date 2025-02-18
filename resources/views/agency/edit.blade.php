@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Trip</h1>
    <form action="{{ route('trips.update', $trip->id) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $trip->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $trip->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $trip->start_date }}" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $trip->end_date }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $trip->price }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">None</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $trip->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="guide_id" class="form-label">Guide</label>
            <select name="guide_id" id="guide_id" class="form-control">
                <option value="">None</option>
                @foreach($guides as $guide)
                <option value="{{ $guide->id }}" {{ $trip->guide_id == $guide->id ? 'selected' : '' }}>
                    {{ $guide->first_name }} {{ $guide->last_name }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
