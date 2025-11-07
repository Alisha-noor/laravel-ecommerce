@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>

            {{-- Flash --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="shopping-cart">
                @if ($cartItems->count() > 0)
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $wishlistItem)
                                    @php
                                        $imageFromModel = $wishlistItem->model?->image;
                                        $imageFromOption = data_get($wishlistItem->options, 'image');
                                        $imageFile = $imageFromModel ?: $imageFromOption;
                                        $imageUrl = $imageFile
                                            ? asset('uploads/products/' . $imageFile)
                                            : asset('images/placeholder.png');
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img src="{{ $imageUrl }}" width="120" height="120"
                                                    class="img-fluid rounded shadow-sm" alt="{{ $wishlistItem->name }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4 class="mb-0">{{ $wishlistItem->name }}</h4>
                                                @if (!$wishlistItem->model)
                                                    <small class="text-danger d-block">This product is unavailable.</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">
                                                ${{ number_format($wishlistItem->price, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="del-action d-flex gap-2">
                                                {{-- Move to Cart --}}
                                                <form method="POST"
                                                    action="{{ route('wishlist.move.to.cart', $wishlistItem->rowId) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning">Move to
                                                        Cart</button>
                                                </form>

                                                {{-- Remove --}}
                                                <form method="POST"
                                                    action="{{ route('wishlist.remove', $wishlistItem->rowId) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Clear Wishlist --}}
                        <div class="cart-table-footer mt-3">
                            <form method="POST" action="{{ route('wishlist.clear') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light" type="submit">CLEAR WISHLIST</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <p>No item found in your wishlist</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
