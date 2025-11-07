@extends('layouts.app')
@section('content')
<div class="container my-5 text-center">
  <h2>Thank you! 🎉</h2>
  <p>Your order has been placed successfully.</p>
  
  @if(session('payment_status'))
    <div class="alert alert-{{ session('payment_status') === 'approved' ? 'success' : 'danger' }} mt-3">
      Payment Status: {{ ucfirst(session('payment_status')) }}
    </div>
  @endif
  
  <a class="btn btn-outline-primary mt-3" href="{{ route('shop.index') }}">Continue Shopping</a>
</div>
@endsection