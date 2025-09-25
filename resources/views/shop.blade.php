@extends('layouts.app')
@section('content')
    {{-- ====== Scoped styles (safe to keep inside this view) ====== --}}
    <style>
        .product-card img {
            transition: transform 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .card-img-top {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .ratio>img {
            border-radius: 0.5rem;
            /* optional rounding */
        }
    </style>

    <div class="container py-3 py-md-4">
        {{-- Header --}}
        <div
            class="shop-header d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3 mb-3 mb-md-4">
            <div>
                <h2 class="h4 mb-1" style="color:#b56576;">Discover Your Next Favorite Bag</h2>
                <div class="text-muted small">
                    Handpicked styles, premium quality, everyday-ready. ✨
                </div>
            </div>

            {{-- Sorting & Filter --}}
            <form method="GET" action="{{ route('shop.index') }}" class="d-flex gap-2">
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High
                    </option>
                    <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low
                    </option>
                </select>


            </form>
        </div>

    </div>
    <div class="container">


        <div class="row g-3 g-md-4" id="products-grid">
            @if ($products->count())
                <div class="row g-3 g-md-4" id="products-grid">
                    @foreach ($products as $product)
                        @php
                            $hasSale = !empty($product->sale_price);
                            $finalPrice = $hasSale ? $product->sale_price : $product->regular_price;
                        @endphp

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card product-card h-100 shadow-sm border-0">
                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                    <div class="ratio ratio-1x1 bg-light">
                                        <img src="{{ asset('uploads/products/' . $product->image) }}"
                                            alt="{{ $product->name }}" class="card-img-top">
                                    </div>
                                </a>

                                <div class="card-body text-center d-flex flex-column">
                                    <small
                                        class="text-muted">{{ optional($product->category)->name ?? 'Uncategorized' }}</small>

                                    <h6 class="card-title my-2">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                                            class="text-dark text-decoration-none">
                                            {{ Str::limit($product->name, 40) }}
                                        </a>
                                    </h6>

                                    <div class="mb-2">
                                        @if ($hasSale)
                                            <span
                                                class="text-muted text-decoration-line-through">${{ $product->regular_price }}</span>
                                            <span class="fw-bold ms-1"
                                                style="color: #b56576">${{ $product->sale_price }}</span>
                                        @else
                                            <span class="fw-bold">${{ $product->regular_price }}</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-dark btn-sm">Add to Cart</button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                    <div class="small text-muted">
                        Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                    </div>
                    <div>
                        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-4">
                    No products found matching your search criteria.
                </div>
            @endif

        </div>

        {{-- Pagination --}}
        {{-- <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
            <div class="small text-muted">
                Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
            </div>
            <div>
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div> --}}
    @endsection
