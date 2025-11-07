@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4 text-primary">Checkout</h2>

        <form method="POST" action="{{ route('cart.place_order') }}" class="needs-validation" novalidate>
            @csrf

            {{-- Shipping Address Section --}}
            <div class="card mb-4 shadow-sm rounded-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name', $address->shipping_name ?? '') }}" required>
                            <div class="invalid-feedback">Please provide your full name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" id="phone"
                                value="{{ old('phone', $address->shipping_phone ?? '') }}" required>
                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label">ZIP Code</label>
                            <input type="text" name="zip" class="form-control" id="zip"
                                value="{{ old('zip', $address->shipping_zip ?? '') }}" required>
                            <div class="invalid-feedback">ZIP code required.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" name="state" class="form-control" id="state"
                                value="{{ old('state', $address->shipping_state ?? '') }}" required>
                            <div class="invalid-feedback">State required.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" id="city"
                                value="{{ old('city', $address->shipping_city ?? '') }}" required>
                            <div class="invalid-feedback">City required.</div>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Street Address</label>
                            <input type="text" name="address" class="form-control" id="address"
                                value="{{ old('address', $address->shipping_address ?? '') }}" required>
                            <div class="invalid-feedback">Street address required.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="locality" class="form-label">Locality</label>
                            <input type="text" name="locality" class="form-control" id="locality"
                                value="{{ old('locality', $address->shipping_locality ?? '') }}" required>
                            <div class="invalid-feedback">Locality required.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="landmark" class="form-label">Landmark (Optional)</label>
                            <input type="text" name="landmark" class="form-control" id="landmark"
                                value="{{ old('landmark', $address->shipping_landmark ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>@extends('layouts.app')
        @section('content')
            <div class="container my-5">
                <h2 class="mb-4">Checkout</h2>

                <form method="POST" action="{{ route('cart.place_order') }}">
                    @csrf

                    {{-- If no default address exists, collect it --}}
                    @if (!$address)
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
                            Using saved address: <strong>{{ $address->name }}</strong>, {{ $address->address }},
                            {{ $address->city }}, {{ $address->state }} {{ $address->zip }}
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


        {{-- Payment Section --}}
        <div class="card mb-4 shadow-sm rounded-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Payment Method</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="payment-mode" class="form-label">Payment Mode</label>
                    <select class="form-select" name="mode" id="payment-mode" required>
                        <option value="COD"
                            {{ old('mode', $address->payment_mode ?? '') === 'COD' ? 'selected' : '' }}>Cash on
                            Delivery</option>
                        {{-- <option value="CARD"
                                {{ old('mode', $address->payment_mode ?? '') === 'CARD' ? 'selected' : '' }}>Credit /
                                Debit Card</option> --}}
                    </select>
                </div>

                {{-- Card Details --}}
                {{-- <div id="card-details" class="mt-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="card_name" class="form-label">Name on Card</label>
                                <input type="text" name="card_name" id="card_name" class="form-control"
                                    value="{{ old('card_name', $address->card_name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="text" name="card_number" id="card_number" class="form-control"
                                    placeholder="xxxx xxxx xxxx 1234"
                                    value="{{ old('card_number', $address->card_number ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="expiry" class="form-label">Expiry Date</label>
                                <input type="text" name="expiry" id="expiry" class="form-control"
                                    placeholder="MM/YY" value="{{ old('expiry', $address->expiry ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="password" name="cvv" id="cvv" class="form-control"
                                    placeholder="xxx">
                            </div>
                            <div class="col-md-4">
                                <label for="card_type" class="form-label">Card Type</label>
                                <select name="card_type" id="card_type" class="form-select">
                                    <option value="">Select</option>
                                    <option value="visa"
                                        {{ old('card_type', $address->card_type ?? '') === 'visa' ? 'selected' : '' }}>
                                        Visa</option>
                                    <option value="mastercard"
                                        {{ old('card_type', $address->card_type ?? '') === 'mastercard' ? 'selected' : '' }}>
                                        MasterCard</option>
                                    <option value="amex"
                                        {{ old('card_type', $address->card_type ?? '') === 'amex' ? 'selected' : '' }}>
                                        American Express</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end mt-3">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Return to Cart</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-lock-fill me-2"></i>Place Order
            </button>
        </div>
    </form>
</div>

@push('styles')
    <style>
        .text-primary {
            color: #b56576 !important;
        }

        .btn-primary {
            background-color: #b56576;
            border-color: #b56576;
        }

        .btn-primary:hover {
            background-color: #a05060;
            border-color: #a05060;
        }

        .card-header.bg-light {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMode = document.getElementById('payment-mode');
            const cardDetails = document.getElementById('card-details');

            function toggleCardFields() {
                if (paymentMode.value === 'CARD') {
                    cardDetails.style.display = 'block';
                    cardDetails.querySelectorAll('input, select').forEach(el => el.required = true);
                } else {
                    cardDetails.style.display = 'none';
                    cardDetails.querySelectorAll('input, select').forEach(el => el.required = false);
                }
            }

            paymentMode.addEventListener('change', toggleCardFields);
            toggleCardFields(); // initialize on page load

            // Bootstrap validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
@endpush
@endsection
