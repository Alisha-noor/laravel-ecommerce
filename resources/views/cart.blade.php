@extends('layouts.app')

@section('content')
    <div class="container py-4">


        @if ($cartItems->isEmpty())
            <div class="alert alert-warning text-center fw-semibold" style="border-color:#b56576; color:#b56576;">
                Your cart is empty.
            </div>
        @else
            {{-- Responsive table wrapper --}}
            <div class="table-responsive shadow-sm rounded-3 border border-light">
                <table class="table align-middle mb-0">
                    <thead style="background-color:#b56576; color:#fff;">
                        <tr>
                            <th class="py-3 px-3">Image</th>
                            <th class="py-3 px-3">Item</th>
                            <th class="text-nowrap py-3 px-3" width="120">Price</th>
                            <th class="text-nowrap py-3 px-3" width="220">Quantity</th>
                            <th class="text-nowrap py-3 px-3" width="140">Subtotal</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr class="cart-row">
                                <td>
                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" width="80"
                                        alt="{{ $item->product->name }}">
                                </td>
                                <td>{{ $item->product->name }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                <td class="d-flex flex-column gap-1">
                                    <form method="POST" action="{{ route('cart.reduce.qty', $item->id) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="qty-btn">-</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.increase.qty', $item->id) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="qty-btn">+</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="remove-btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table styling --}}
            <style>
                /* alternate row striping */
                .cart-row:nth-child(even) {
                    background-color: #fcecef;
                }

                /* row hover effect */
                .cart-row:hover {
                    background-color: #f8dfe6;
                    transition: 0.2s ease-in-out;
                }

                /* quantity buttons */
                .qty-btn {
                    border: 1px solid #b56576;
                    color: #b56576;
                    background: #fff;
                    width: 100%;
                }

                .qty-btn:hover {
                    background-color: #b56576;
                    color: #fff;
                }

                /* remove button */
                .remove-btn {
                    border: 1px solid #b56576;
                    color: #b56576;
                    background: #fff;
                    width: 100%;
                }

                .remove-btn:hover {
                    background-color: #b56576;
                    color: #fff;
                }
            </style>


            {{-- Actions / Summary --}}
            <div class="mt-4 p-3 rounded shadow-sm" style="border:1px solid #eee; background:#fafafa;">

                {{-- Coupon row --}}
                <form method="POST" action="{{ route('cart.coupon.apply') }}" class="row g-2 align-items-center">
                    @csrf
                    <div class="col-12 col-sm">
                        <input type="text" name="code" class="form-control" placeholder="Coupon code">
                    </div>
                    <div class="col-12 col-sm-auto">
                        <button class="btn w-100 w-sm-auto" style="background:#b56576; color:#fff;">Apply</button>
                    </div>
                </form>

                {{-- Applied coupon --}}
                @if (session('coupon'))
                    <div class="alert mt-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
                        style="background:#fcecef; border:1px solid #b56576; color:#b56576;">
                        <div>
                            Coupon <strong>{{ session('coupon.code') }}</strong> applied —
                            Discount: <strong>${{ number_format(session('coupon.discount'), 2) }}</strong>
                        </div>
                        <form method="POST" action="{{ route('cart.coupon.remove') }}" class="m-0">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light border" style="color:#b56576;">Remove</button>
                        </form>
                    </div>
                @endif


                {{-- Totals --}}
                <div class="mt-4">
                    <div
                        class="d-flex flex-column align-items-start align-items-md-end text-start text-md-end ms-0 ms-md-auto gap-1">
                        <div>Subtotal: <strong>${{ number_format($checkout['subtotal'] ?? $subtotal, 2) }}</strong></div>
                        <div>Tax: <strong>${{ number_format($checkout['tax'] ?? $tax, 2) }}</strong></div>
                        <div>Discount: <strong>${{ number_format($discount, 2) }}</strong></div>
                        <div class="fs-5" style="color:#b56576;">Total:
                            <strong>${{ number_format($checkout['total'] ?? $total, 2) }}</strong>
                        </div>

                        {{-- <div class="mt-3 d-flex flex-column flex-sm-row gap-2 justify-content-end w-100 w-md-auto">
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf @method('DELETE')
                                <button class="btn w-100" style="border:1px solid #b56576; color:#b56576;">Clear
                                    Cart</button> --}}
                        </form>
                        <a class="btn w-100 w-sm-auto" href="{{ route('cart.checkout') }}"
                            style="background:#b56576; color:#fff;">Checkout</a>
                    </div>
                </div>
            </div>
    </div>
    @endif
    </div>

    {{-- Small helpers --}}
    <style>
        @media (max-width: 576px) {

            .table td,
            .table th {
                white-space: nowrap;
            }
        }
    </style>
@endsection
