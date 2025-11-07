@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>

        <section class="product-single container">
            <div class="row g-4">
                {{-- ===== Left: Gallery ===== --}}
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        {{-- Main images --}}
                        <div class="product-single__image">
                            <div class="swiper-container" data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    {{-- Primary image --}}
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="img-fluid"
                                            src="{{ asset('uploads/products/' . $product->image) }}" width="674"
                                            height="674" alt="{{ $product->name }}" />
                                        <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $product->image) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>

                                    {{-- Gallery images (guard for empty values) --}}
                                    @php
                                        $gallery = array_filter(
                                            array_map('trim', explode(',', (string) $product->images)),
                                        );
                                    @endphp
                                    @foreach ($gallery as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="img-fluid"
                                                src="{{ asset('uploads/products/' . $gimg) }}" width="674" height="674"
                                                alt="{{ $product->name }}" />
                                            <a data-fancybox="gallery" href="{{ asset('uploads/products/' . $gimg) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                            </div>
                        </div>


                        {{-- Thumbnails --}}
                        <div class="product-single__thumbnail mt-3">
                            <div class="swiper-container"
                                data-settings='{"resizeObserver": true, "slidesPerView": 5, "spaceBetween": 12, "breakpoints": {"320":{"slidesPerView":4},"768":{"slidesPerView":5}}}'>
                                <div class="swiper-wrapper">
                                    {{-- Main Product Image --}}
                                    @if ($product->image)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="img-fluid"
                                                src="{{ asset('uploads/products/' . $product->image) }}" width="104"
                                                height="104" alt="{{ $product->name }} thumbnail" />
                                        </div>
                                    @endif

                                    {{-- Gallery Images --}}
                                    @if (!empty($gallery) && is_array($gallery))
                                        @foreach ($gallery as $gimg)
                                            <div class="swiper-slide product-single__image-item">
                                                <img loading="lazy" class="img-fluid"
                                                    src="{{ asset('uploads/products/' . trim($gimg)) }}" width="104"
                                                    height="104" alt="{{ $product->name }} thumbnail" />
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Right: Info & Actions ===== --}}
                <div class="col-lg-5">
                    {{-- Breadcrumb + prev/next (kept minimal on mobile) --}}
                    <div
                        class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3 pb-md-2">
                        <nav class="breadcrumb mb-0 d-none d-md-block">
                            <a href="{{ url('/') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium px-2">/</span>
                            <a href="{{ route('shop.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">Shop</a>
                        </nav>
                        <div class="product-single__prev-next d-flex align-items-center gap-3">
                            <a href="{{ url()->previous() }}" class="text-uppercase fw-medium small">
                                <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_md" />
                                </svg>
                                <span class="menu-link menu-link_us-s">Back</span>
                            </a>
                        </div>
                    </div>

                    <h1 class="product-single__name h3">{{ $product->name }}</h1>

                    <div class="product-single__rating d-flex align-items-center gap-2 mb-2">
                        <div class="reviews-group d-flex">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_star" />
                                </svg>
                            @endfor
                        </div>
                        <span class="reviews-note text-secondary small">8k+ reviews</span>
                    </div>

                    <div class="product-single__price mb-3">
                        <span class="current-price h4">
                            @if ($product->sale_price)
                                <s class="fs-6 text-muted">${{ $product->regular_price }}</s>
                                <span class="ms-2">${{ $product->sale_price }}</span>
                                <span class="badge text-bg-light ms-2">
                                    {{ round((($product->regular_price - $product->sale_price) * 100) / max($product->regular_price, 1)) }}%
                                    OFF
                                </span>
                            @else
                                ${{ $product->regular_price }}
                            @endif
                        </span>
                    </div>

                    <div class="product-single__short-desc mb-3">
                        <p class="mb-0">{{ $product->short_description }}</p>
                    </div>

                    {{-- FIXED: cart.add (instead of cart.store) --}}
                    <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}" class="mb-3">
                        @csrf
                        <div class="product-single__addtocart d-flex flex-wrap align-items-stretch gap-2">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1"
                                    class="qty-control__number text-center form-control" style="min-width: 110px;">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>

                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            <input type="hidden" name="name" value="{{ $product->name }}" />
                            <input type="hidden" name="price"
                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />

                            <button type="submit" class="btn btn-primary flex-grow-1">
                                Add to Cart
                            </button>
                        </div>
                    </form>

                    <div class="product-single__addtolinks d-flex flex-wrap align-items-center gap-3 mb-4">
                        <form method="POST" action="{{ route('wishlist.add') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price"
                                value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="menu-link menu-link_us-s add-to-wishlist border-0 bg-transparent d-inline-flex align-items-center">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <use href="#icon_heart" />
                                </svg>
                                <span class="ms-1">Add to Wishlist</span>
                            </button>
                        </form>

                        <share-button class="share-button">
                            <button
                                class="menu-link menu-link_us-s to-share border-0 bg-transparent d-inline-flex align-items-center">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_sharing" />
                                </svg>
                                <span class="ms-1">Share</span>
                            </button>
                            <details id="Details-share-template__main" class="m-1 xl:m-1.5" hidden>
                                <summary class="btn-solid m-1 xl:m-1.5 pt-3.5 pb-3 px-5">+</summary>
                                <div id="Article-share-template__main"
                                    class="share-button__fallback d-flex align-items-center position-absolute top-100 start-0 w-100 px-2 py-3 bg-white shadow border-top">
                                    <div class="field flex-grow-1 me-3">
                                        <label class="field__label sr-only" for="url">Link</label>
                                        <input type="text" class="field__input form-control" id="url"
                                            value="{{ url()->current() }}" placeholder="Link" onclick="this.select();"
                                            readonly>
                                    </div>
                                    <button class="share-button__copy btn btn-outline-secondary btn-sm no-js-hidden">
                                        <svg class="icon icon-clipboard me-1" width="11" height="13"
                                            fill="none" viewBox="0 0 11 13" aria-hidden="true" focusable="false">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z"
                                                fill="currentColor"></path>
                                        </svg>
                                        Copy link
                                    </button>
                                </div>
                            </details>
                        </share-button>
                        {{-- If you actually use these files, keep paths correct --}}
                        <script src="{{ asset('js/details-disclosure.js') }}" defer></script>
                        <script src="{{ asset('js/share.js') }}" defer></script>
                    </div>

                    {{-- Meta --}}
                    <div class="product-single__meta-info row row-cols-1 row-cols-sm-2 g-2">
                        <div class="meta-item col">
                            <label class="text-muted small d-block">SKU:</label>
                            <span class="fw-semibold">{{ $product->SKU }}</span>
                        </div>
                        <div class="meta-item col">
                            <label class="text-muted small d-block">Category:</label>
                            <span class="fw-semibold">{{ optional($product->category)->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="meta-item col">
                            <label class="text-muted small d-block">Brand:</label>
                            <span class="fw-semibold">{{ optional($product->brand)->name ?? 'No Brand' }}</span>
                        </div>
                        <div class="meta-item col">
                            <label class="text-muted small d-block">Tags:</label>
                            <span class="fw-semibold">biker, black, bomber, leather</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Tabs ===== --}}
            <div class="product-single__details-tab mt-5">
                <ul class="nav nav-tabs flex-nowrap overflow-auto" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">
                            Description
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                            href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                            aria-selected="false">
                            Additional Information
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                            href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">
                            Reviews (2)
                        </a>
                    </li>
                </ul>

                <div class="tab-content p-3 border border-top-0 rounded-bottom">
                    {{-- Description --}}
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                        aria-labelledby="tab-description-tab">
                        <div class="product-single__description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    {{-- Additional Info --}}
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                        aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__addtional-info row g-3">
                            <div class="col-6 col-md-4"><label class="h6 d-block">Weight</label><span>1.25 kg</span></div>
                            <div class="col-6 col-md-4"><label class="h6 d-block">Dimensions</label><span>90 x 60 x 90
                                    cm</span></div>
                            <div class="col-6 col-md-4"><label class="h6 d-block">Size</label><span>XS, S, M, L, XL</span>
                            </div>
                            <div class="col-6 col-md-4"><label class="h6 d-block">Color</label><span>Black, Orange,
                                    White</span></div>
                            <div class="col-12 col-md-8"><label class="h6 d-block">Storage</label><span>Relaxed fit
                                    shirt-style dress with a rugged</span></div>
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        <h2 class="product-single__reviews-title h5">Reviews</h2>

                        <div class="product-single__reviews-list">
                            <div class="product-single__reviews-item d-flex gap-3">
                                <div class="customer-avatar flex-shrink-0">
                                    <img loading="lazy" src="{{ asset('assets/images/avatar.jpg') }}"
                                        alt="Customer Avatar" width="48" height="48" class="rounded-circle" />
                                </div>
                                <div class="customer-review">
                                    <div class="customer-name d-flex align-items-center gap-2">
                                        <h6 class="mb-0">Janice Miller</h6>
                                        <div class="reviews-group d-flex">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="review-star" viewBox="0 0 9 9"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_star" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-date text-muted small">April 06, 2023</div>
                                    <div class="review-text">
                                        <p class="mb-0">Nam libero tempore, cum soluta nobis est eligendi...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-single__reviews-list">
                            @foreach ($product->reviews()->latest()->get() as $review)
                                <div class="product-single__reviews-item d-flex gap-3">
                                    <div class="customer-avatar flex-shrink-0">
                                        <img loading="lazy" src="{{ asset('assets/images/avatar.jpg') }}" width="48"
                                            height="48" class="rounded-circle" />
                                    </div>
                                    <div class="customer-review">
                                        <div class="customer-name d-flex align-items-center gap-2">
                                            <h6 class="mb-0">{{ $review->name }}</h6>
                                            <div class="reviews-group d-flex">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="review-star" viewBox="0 0 9 9">
                                                        <use href="#icon_star"
                                                            fill="{{ $i < $review->rating ? '#f5a623' : '#ccc' }}" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date text-muted small">
                                            {{ $review->created_at->format('M d, Y') }}</div>
                                        <div class="review-text">
                                            <p class="mb-0">{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form method="POST" action="{{ route('review.store', $product->id) }}" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Your rating *</label>
                                <select name="rating" class="form-control" required>
                                    <option value="">Select Rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} Star</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="form-input-review" class="form-label">Your review *</label>
                                <textarea name="review" class="form-control form-control_gray" rows="6" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Name *</label>
                                <input name="name" class="form-control form-control-md form-control_gray" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email address *</label>
                                <input name="email" type="email"
                                    class="form-control form-control-md form-control_gray" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- ===== Related Products ===== --}}
            <section class="products-carousel container mt-5 px-0">
                <h2 class="h4 text-uppercase mb-3">Related <strong>Products</strong></h2>

                <div id="related_products" class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                            "autoplay": false,
                            "slidesPerView": 4,
                            "slidesPerGroup": 4,
                            "effect": "none",
                            "loop": true,
                            "pagination": { "el": "#related_products .products-pagination", "type": "bullets", "clickable": true },
                            "navigation": { "nextEl": "#related_products .products-carousel__next", "prevEl": "#related_products .products-carousel__prev" },
                            "breakpoints": {
                                "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                                "768": { "slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 24 },
                                "992": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30 }
                            }
                         }'>
                        <div class="swiper-wrapper">
                            @foreach ($rproducts as $rproduct)
                                @php
                                    $rGallery = array_filter(
                                        array_map('trim', explode(',', (string) $rproduct->images)),
                                    );
                                    $rPrice =
                                        $rproduct->sale_price === '' ? $rproduct->regular_price : $rproduct->sale_price;
                                @endphp

                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper position-relative">
                                        <a
                                            href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                                            <img loading="lazy" class="pc__img" width="330" height="400"
                                                src="{{ asset('uploads/products/' . $rproduct->image) }}"
                                                alt="{{ $rproduct->name }}">
                                            @if (!empty($rGallery))
                                                <img loading="lazy" class="pc__img pc__img-second"
                                                    src="{{ asset('uploads/products/' . head($rGallery)) }}"
                                                    width="330" height="400" alt="{{ $rproduct->name }}">
                                            @endif
                                        </a>

                                        {{-- Add To Cart for related product --}}
                                        <form form method="POST" action="{{ route('cart.add') }}"
                                            class="anim_appear-bottom position-absolute start-0 end-0 bottom-0 p-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $rproduct->name }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price" value="{{ $rPrice }}">
                                            <button type="submit" class="btn btn-dark w-100">Add To Cart</button>
                                        </form>
                                    </div>

                                    <div class="pc__info position-relative pt-2">
                                        <p class="pc__category small text-muted mb-1">
                                            {{ optional($rproduct->category)->name ?? 'Uncategorized' }}
                                        </p>
                                        <h6 class="pc__title mb-1">
                                            <a
                                                href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                                                {{ $rproduct->name }}
                                            </a>
                                        </h6>
                                        <div class="product-card__price d-flex align-items-center gap-2">
                                            <span class="money price">
                                                @if ($rproduct->sale_price)
                                                    <s>${{ $rproduct->regular_price }}</s>
                                                    ${{ $rproduct->sale_price }}
                                                @else
                                                    ${{ $rproduct->regular_price }}
                                                @endif
                                            </span>
                                        </div>

                                        {{-- Wishlist add (simple) --}}
                                        <form method="POST" action="{{ route('wishlist.add') }}"
                                            class="position-absolute top-0 end-0">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $rproduct->id }}">
                                            <input type="hidden" name="name" value="{{ $rproduct->name }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="price" value="{{ $rPrice }}">
                                            <button type="submit"
                                                class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add to Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div
                        class="products-carousel__prev position-absolute top-50 translate-middle-y start-0 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div>
                    <div
                        class="products-carousel__next position-absolute top-50 translate-middle-y end-0 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25">
                            <use href="#icon_next_md" />
                        </svg>
                    </div>
                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                </div>
            </section>
        </section>
    </main>
@endsection
