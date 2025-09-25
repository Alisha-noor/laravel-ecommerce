@extends('layouts.app')
@section('content')
<div class="container my-5">
  <h2 class="mb-4">Checkout</h2>

  <form method="POST" action="{{ route('cart.place_order') }}">
    @csrf

    {{-- If no default address exists, collect it --}}
    @if(!$address)
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Name</label>
          <input name="name" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">ZIP</label>
          <input name="zip" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">State</label>
          <input name="state" class="form-control" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">City</label>
          <input name="city" class="form-control" required>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Address</label>
          <input name="address" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Locality</label>
          <input name="locality" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Landmark (optional)</label>
          <input name="landmark" class="form-control">
        </div>
      </div>
    @else
      <div class="alert alert-info">
        Using saved address: <strong>{{ $address->name }}</strong>, {{ $address->address }}, {{ $address->city }}, {{ $address->state }} {{ $address->zip }}
      </div>
    @endif

    <div class="mb-3">
      <label class="form-label">Payment Mode</label>
      <select class="form-select" name="mode">
        <option value="COD" selected>Cash on Delivery</option>
        <option value="CARD">Credit/Debit Card</option>
      </select>
    </div>

    <button class="btn btn-primary" style="background:#b56576;border-color:#b56576">Place Order</button>
  </form>
</div>
@endsection
