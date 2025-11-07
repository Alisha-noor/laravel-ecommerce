@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Edit Address</h2>

        <form method="POST" action="{{ route('address.update', $address->id) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $address->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $address->phone) }}"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Street</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $address->address) }}"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Locality</label>
                <input type="text" name="locality" class="form-control"
                    value="{{ old('locality', $address->locality) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Landmark</label>
                <input type="text" name="landmark" class="form-control"
                    value="{{ old('landmark', $address->landmark) }}">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $address->city) }}"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $address->state) }}"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ZIP</label>
                    <input type="text" name="zip" class="form-control" value="{{ old('zip', $address->zip) }}"
                        required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="{{ route('userprofile') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
