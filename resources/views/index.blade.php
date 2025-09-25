@extends('layouts.app')

@section('content')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2 container" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show my-2 container" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Tiny CSS (scoped) -->
    <style>
        :root {
            --brand: #b56576;
            --brand-600: #9e4e63;
        }

        .dot {
            width: .6rem;
            height: .6rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .5);
            transition: .25s;
        }

        .dot.active {
            background: #fff;
            transform: scale(1.1);
        }

        .pc__img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 14px;
        }

        .pc__img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform .4s ease;
        }

        .pc__img-second {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .35s ease, transform .4s ease;
        }

        .product-card_style3:hover .pc__img {
            transform: scale(1.06);
        }

        .product-card_style3:hover .pc__img-second {
            opacity: 1;
            transform: scale(1.02);
        }

        .price-old {
            text-decoration: line-through;
            opacity: .6;
            margin-right: .5rem;
        }

        .feature-icon {
            color: var(--brand);
        }

        .p-badge {
            position: absolute;
            top: .5rem;
            left: .5rem;
            background: var(--brand);
            color: #fff;
            font-size: .7rem;
            padding: .25rem .5rem;
            border-radius: 999px;
        }
    </style>

    <!-- ====================== HERO SLIDER ====================== -->

    <section class="relative w-full"id="hero" data-aos="fade-up" data-aos-duration="3000">
        <!-- Slides Container -->
        <div class="relative overflow-hidden h-[50vh] md:h-[70vh] lg:h-[80vh]" id="hero-slider">

            <!-- Slide 1 -->
            <div class="absolute inset-0 transition-opacity duration-1000 opacity-100 slide">
                <img src="https://niche.style/wp-content/uploads/2024/02/three-pastel-colored-womens-hand-bags-on-pink-back-2023-11-27-04-57-25-utc-copy.jpg"
                    alt="Slide 1" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3 sm:px-6 md:px-12">
                    <h1 style="font-family: 'Playfair Display', serif;"
                        class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                        Welcome to Bagverse Collection
                    </h1>
                    <p style="font-family: 'Playfair Display', serif;"
                        class="text-sm sm:text-md md:text-lg lg:text-xl text-white mb-6 sm:mb-8 max-w-xl sm:max-w-2xl">
                        Discover our premium collection for every Women.
                    </p>
                    <a href="{{ route('shop.index') }}"
                        class="px-4 sm:px-6 py-2 sm:py-3 bg-[#b56576] text-white rounded-full text-sm sm:text-lg font-medium hover:bg-[#0000] transition">
                        Shop Now
                    </a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="absolute inset-0 transition-opacity duration-1000 opacity-0 slide">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/026/858/640/small/of-a-minimalistic-white-purse-on-a-table-with-ample-copy-space-with-copy-space-photo.jpg"
                    alt="Slide 2" class="w-full h-full object-cover filter blur-[1px]" />
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3 sm:px-6 md:px-12">
                    <h1 style="font-family: 'Playfair Display', serif;"
                        class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                        Elegant Bags
                    </h1>
                    <p style="font-family: 'Playfair Display', serif;"
                        class="text-sm sm:text-md md:text-lg lg:text-xl text-white mb-6 sm:mb-8 max-w-xl sm:max-w-2xl">
                        Shop our exclusive collection of bags for every style.
                    </p>
                    <a href="{{ route('shop.index') }}"
                        class="px-4 sm:px-6 py-2 sm:py-3 bg-[#b56576] text-white rounded-full text-sm sm:text-lg font-medium hover:bg-[#9e4e63] transition">
                        Shop Now
                    </a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="absolute inset-0 transition-opacity duration-1000 opacity-0 slide">
                <img src="https://png.pngtree.com/background/20210711/original/pngtree-fashion-women-s-bag-promotion-season-literary-pink-banner-picture-image_1119353.jpg"
                    alt="Slide 3" class="w-full h-full object-cover filter blur-[1px]" />
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-3 sm:px-6 md:px-12">
                    <h1 style="font-family: 'Playfair Display', serif;"
                        class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                        Women's Trendy bags
                    </h1>
                    <p style="font-family: 'Playfair Display', serif;"
                        class="text-sm sm:text-md md:text-lg lg:text-xl text-white mb-6 sm:mb-8 max-w-xl sm:max-w-2xl">
                        Step out in style with our bags collection.
                    </p>
                    <a href="{{ route('shop.index') }}"
                        class="px-4 sm:px-6 py-2 sm:py-3 bg-[#b56576] text-white rounded-full text-sm sm:text-lg font-medium hover:bg-[#9e4e63] transition">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Slider Navigation -->
        <div class="absolute bottom-4 sm:bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 sm:space-x-3 z-20">
            <button class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white/50 hover:bg-white slide-btn" data-slide="0"></button>
            <button class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white/50 hover:bg-white slide-btn" data-slide="1"></button>
            <button class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white/50 hover:bg-white slide-btn" data-slide="2"></button>
        </div>
    </section>
    <!-- ====================== FEATURES BAND ====================== -->
    <section class="mt-6 sm:mt-10" data-aos="fade-up" data-aos-duration="3000">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 bg-white/70 rounded-2xl p-4 md:p-6 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-shipping-fast fa-2x md:fa-3x feature-icon"></i>
                    <h3 class="mt-2 font-semibold">Shipping Charges</h3>
                    <p class="text-sm text-gray-600">Rs 500</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-lock fa-2x md:fa-3x feature-icon"></i>
                    <h3 class="mt-2 font-semibold">Secure Payment</h3>
                    <p class="text-sm text-gray-600">100% safe checkout</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-shopping-cart fa-2x md:fa-3x feature-icon"></i>
                    <h3 class="mt-2 font-semibold">Safe Shopping</h3>
                    <p class="text-sm text-gray-600">Hassle-free experience</p>
                </div>
                <div class="flex flex-col items-center text-center">
                    <i class="fas fa-star fa-2x md:fa-3x feature-icon"></i>
                    <h3 class="mt-2 font-semibold">Top Rated</h3>
                    <p class="text-sm text-gray-600">Trusted by thousands</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====================== CATEGORY CAROUSEL ====================== -->
    <div class="max-w-[1620px] mx-auto px-4 mt-10" data-aos="fade-up" data-aos-duration="3000">
        <section class="container mx-auto">
            <h2 class="text-center text-2xl md:text-3xl font-extrabold mb-6">You Might Like</h2>

            <div class="relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
              "autoplay":{"delay":5000},
              "slidesPerView":8,
              "slidesPerGroup":1,
              "loop":true,
              "navigation":{"nextEl":".products-carousel__next-1","prevEl":".products-carousel__prev-1"},
              "breakpoints":{
                "320":{"slidesPerView":2,"slidesPerGroup":2,"spaceBetween":15},
                "768":{"slidesPerView":4,"slidesPerGroup":4,"spaceBetween":30},
                "992":{"slidesPerView":6,"slidesPerGroup":1,"spaceBetween":45},
                "1200":{"slidesPerView":8,"slidesPerGroup":1,"spaceBetween":60}
              }
           }'>
                    <div class="swiper-wrapper">
                        @php
                            $catImgs = [
                                [
                                    'Women 3-Piece Leather Handbag',
                                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGtr6Xl1cjT5NxsB-dE-axXRQ2VEucWdx5iQ&s',
                                ],
                                [
                                    'Women Leather Shoulder Handbags',
                                    'https://static-01.daraz.pk/p/b1596e40c9fb0ad290eed33af6fbfe2d.jpg',
                                ],
                                [
                                    'Women 5 piece bag for Girls',
                                    'https://img.drz.lazcdn.com/static/pk/p/16f4824f13a4237ab88edf0fc8afccc8.jpg_720x720q80.jpg',
                                ],
                                [
                                    'Women Shoulder Crossbody Bag',
                                    'https://img.drz.lazcdn.com/static/pk/p/14abf3b65484aa1672aae4b9f0539358.jpg_720x720q80.jpg',
                                ],
                                [
                                    'Women Mini Shoulder Bags',
                                    'https://static-01.daraz.pk/p/690baa2f9c4cf8e88d9ca3c86fe78786.jpg',
                                ],
                                [
                                    'Women Leather Handbags',
                                    'https://static-01.daraz.pk/p/c2b288312ddbf1ccb1586aa11c113b1a.jpg',
                                ],
                                [
                                    'Women Card Small Wallet',
                                    'https://static-01.daraz.pk/p/a8c22c28c8581d60ae2d0a184d5809e7.png',
                                ],
                                [
                                    'Women Mini Wallets Short Tassel',
                                    'https://bd-live-21.slatic.net/kf/S835296bbb7dc4c17bef0ef85f0338a34h.jpg',
                                ],
                            ];
                        @endphp

                        @foreach ($catImgs as $c)
                            <div class="swiper-slide">
                                <img loading="lazy" class="w-28 h-28 md:w-32 md:h-32 rounded-full mx-auto mb-3 object-cover"
                                    src="{{ $c[1] }}" alt="{{ $c[0] }}">
                                <div class="text-center">
                                    <a href="#" class="font-medium leading-tight">{{ $c[0] }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Nav Arrows -->
                <div
                    class="products-carousel__prev products-carousel__prev-1 absolute left-0 top-1/2 -translate-y-1/2 grid place-items-center w-9 h-9 rounded-full bg-white/80 shadow">
                    <svg width="20" height="20" viewBox="0 0 25 25">
                        <path d="M15 5 L8 12 L15 19" stroke="#111" stroke-width="2" fill="none"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div
                    class="products-carousel__next products-carousel__next-1 absolute right-0 top-1/2 -translate-y-1/2 grid place-items-center w-9 h-9 rounded-full bg-white/80 shadow">
                    <svg width="20" height="20" viewBox="0 0 25 25">
                        <path d="M10 5 L17 12 L10 19" stroke="#111" stroke-width="2" fill="none"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </section>
    </div>

    <!-- ====================== HOT DEALS ====================== -->
    <section class="hot-deals container" data-aos="fade-up" data-aos-duration="3000">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
        <div class="row">
            <div
                class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                <h2>Summer Sale</h2>
                <h2 class="fw-bold">Up to 60% Off</h2>

                <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                    data-date="18-03-2025" data-time="06:50">
                    <div class="day countdown-unit">
                        <span class="countdown-num d-block"></span>
                        <span class="countdown-word text-uppercase text-secondary">Days</span>
                    </div>

                    <div class="hour countdown-unit">
                        <span class="countdown-num d-block"></span>
                        <span class="countdown-word text-uppercase text-secondary">Hours</span>
                    </div>

                    <div class="min countdown-unit">
                        <span class="countdown-num d-block"></span>
                        <span class="countdown-word text-uppercase text-secondary">Mins</span>
                    </div>

                    <div class="sec countdown-unit">
                        <span class="countdown-num d-block"></span>
                        <span class="countdown-word text-uppercase text-secondary">Sec</span>
                    </div>
                </div>

                <a href="{{ route('shop.index') }}" class="btn-link default-underline text-uppercase fw-medium mt-3">View
                    All</a>
            </div>
            <div class="col-md-6 col-lg-8 col-xl-80per">
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                                "autoplay": { "delay": 5000 },
                                "slidesPerView": 4,
                                "slidesPerGroup": 4,
                                "effect": "none",
                                "loop": false,
                                "breakpoints": {
                                    "320":  { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                                    "768":  { "slidesPerView": 2, "slidesPerGroup": 3, "spaceBetween": 24 },
                                    "992":  { "slidesPerView": 3, "slidesPerGroup": 1, "spaceBetween": 30, "pagination": false },
                                    "1200": { "slidesPerView": 4, "slidesPerGroup": 1, "spaceBetween": 30, "pagination": false }
                                }
                             }'>
                        <div class="swiper-wrapper">

                            {{-- Card A --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://static-01.daraz.pk/p/dfe03dbe1cfd72e95e000c4602496dfb.jpg"
                                            width="258" height="313" alt="Cropped Faux leather Jacket"
                                            class="pc__img">
                                        <img loading="lazy"
                                            src="https://static-01.daraz.pk/p/de37191ae8842dbb4146fb02d7b8eb31.jpg"
                                            width="258" height="313" alt="Cropped Faux leather Jacket"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Cropped Faux Leather Bag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$29</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="401" data-name="Cropped Faux Leather Bag" data-price="29"
                                            data-qty="1" title="Add To Cart"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="401"
                                            data-name="Cropped Faux Leather Bag" data-price="29" data-qty="1"
                                            title="Add To Wishlist">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card B --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://static-01.daraz.pk/p/fc1a6f5f932fdfb4019166caed3264a3.jpg"
                                            width="258" height="313" alt="5 Piece Handbag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWB64CFjuPqHbsSdSqYDvUQqWjfgRCax8Q8Q&s"
                                            width="258" height="313" alt="5 Piece Handbag"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">5 Piece Handbag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$62</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="402" data-name="5 Piece Handbag" data-price="62" data-qty="1"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="402" data-name="5 Piece Handbag"
                                            data-price="62" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card C --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://i.ebayimg.com/images/g/LwsAAOSwQMJl7-Wa/s-l400.jpg"
                                            width="258" height="313" alt="Crossbody Bag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://media.bushpop.com.au/2024/09/brown-bag-2-768x768.jpg"
                                            width="258" height="313" alt="Crossbody Bag"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Crossbody Bag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$62</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="403" data-name="Crossbody Bag" data-price="62" data-qty="1"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="403" data-name="Crossbody Bag"
                                            data-price="62" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card D --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://m.media-amazon.com/images/I/618BU1VjtOL._AC_UY300_.jpg"
                                            width="258" height="313" alt="Mini Handbag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://static-01.daraz.pk/p/fb1bfe2a726403de7307d121f4bb6041.jpg"
                                            width="258" height="313" alt="Mini Handbag"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Mini Handbag</a></h6>
                                    <div class="product-card__price d-flex align-items-center">
                                        <span class="money price-old">$129</span>
                                        <span class="money price text-secondary">$99</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="404" data-name="Mini Handbag" data-price="99" data-qty="1"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="404" data-name="Mini Handbag"
                                            data-price="99" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card E --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://img.drz.lazcdn.com/static/pk/p/82d4c63f7b8e2d1aea4ed528f0bf1fc2.jpg_960x960q80.jpg_.webp"
                                            width="258" height="313" alt="Crossbody Leather Handbag"
                                            class="pc__img">
                                        <img loading="lazy"
                                            src="https://img.kwcdn.com/product/29eba96cf00134c34f6fd33d272de0856bfdb8b1.goods.000001.jpeg"
                                            width="258" height="313" alt="Crossbody Leather Handbag"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Crossbody Leather Handbag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$29</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="405" data-name="Crossbody Leather Handbag" data-price="29"
                                            data-qty="1"><i class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="405"
                                            data-name="Crossbody Leather Handbag" data-price="29"
                                            data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card F --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://img.drz.lazcdn.com/g/kf/S5e6bad1e507646d390a478a3c782509fP.jpg_960x960q80.jpg_.webp"
                                            width="258" height="313" alt="Chain Shoulder Handbag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4rFRXNowgmgiOT-YGkdTcblrsKMQa0wuAklY1Gx-s0oK_w5NWBWZfJkjxPauO9PhKibU&usqp=CAU"
                                            width="258" height="313" alt="Chain Shoulder Handbag"
                                            class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Chain Shoulder Handbag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$62</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="406" data-name="Chain Shoulder Handbag" data-price="62"
                                            data-qty="1"><i class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="406" data-name="Chain Shoulder Handbag"
                                            data-price="62" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card G --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://m.media-amazon.com/images/I/71wjmij9vdL._UY300_.jpg"
                                            width="258" height="313" alt="Handbag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://img4.dhresource.com/webp/m/260x260/f3/albu/km/t/13/500c300e-6539-42f6-9ef4-458447905f29.jpg"
                                            width="258" height="313" alt="Handbag" class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Handbag</a></h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">$62</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="407" data-name="Handbag" data-price="62" data-qty="1"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="407" data-name="Handbag"
                                            data-price="62" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Card H --}}
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="details.html">
                                        <img loading="lazy"
                                            src="https://m.media-amazon.com/images/I/71UP43RVPPL._UY1100_.jpg"
                                            width="258" height="313" alt="Handbag" class="pc__img">
                                        <img loading="lazy"
                                            src="https://img.ltwebstatic.com/images3_pi/2022/12/07/1670381624e718654179654e02df50e67901caf22f_thumbnail_720x.jpg"
                                            width="258" height="313" alt="Handbag" class="pc__img pc__img-second">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">Handbag</a></h6>
                                    <div class="product-card__price d-flex align-items-center">
                                        <span class="money price-old">$129</span>
                                        <span class="money price text-secondary">$99</span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-flex align-items-center bg-body p-2 gap-2">
                                        <button class="btn btn-sm text-white js-add-to-cart"
                                            style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                            data-id="408" data-name="Handbag" data-price="99" data-qty="1"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist"
                                            style="border-radius:10px" data-id="408" data-name="Handbag"
                                            data-price="99" data-qty="1">♡</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- /.swiper-container js-swiper-slider -->
                </div><!-- /.position-relative -->
            </div>
        </div>
    </section>

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <!-- ====================== FEATURED PRODUCTS (GRID) ====================== -->
    <section class="max-w-6xl mx-auto px-4 mt-12" data-aos="fade-up" data-aos-duration="3000">
        <!-- Header -->
        <div class="relative bg-cover bg-center bg-no-repeat text-center mb-6 rounded-xl overflow-hidden"
            style="background-image: url('https://static-01.daraz.pk/p/77925c1f2a1cf2c3f70aee4411ebcf96.jpg'); background-attachment: fixed; height: 70vh;">

            <!-- Overlay (dark layer for text readability) -->
            <div class="absolute inset-0 bg-black/40"></div>

            <!-- Text Content -->
            <div class="relative p-10 md:p-16">
                <div class="text-sm uppercase tracking-wide text-gray-200">Created for you</div>
                <h2 style="font-family: 'Playfair Display', serif;"
                    class="text-2xl md:text-3xl font-extrabold text-white">Featured Products</h2>
                <p style="font-family: 'Playfair Display', serif;" class="text-gray-200 max-w-2xl mx-auto mt-2">
                    Elegant backpacks, crossbody essentials, and stylish totes crafted for everyday use.
                </p>
            </div>
        </div>


        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @php

                $featured = [
                    [
                        101,
                        'Best Seller',
                        'Stylish Leather Handbag',
                        35,
                        'https://img.drz.lazcdn.com/static/pk/p/82b4a09ca0b1f7ef1fdab8661f3c2507.jpg_720x720q80.jpg',
                    ],
                    [
                        102,
                        'Trending',
                        'Trendy Tote Bag',
                        28,
                        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRczyNR2rnRfsT3UEgJRBPBO8HBsDTYw-DvmQ&s',
                    ],
                    [
                        103,
                        'New',
                        'Mini Crossbody Bag',
                        28,
                        'https://img.drz.lazcdn.com/static/pk/p/b20e08fc496ca84c97d69be4e96be776.jpg_720x720q80.jpg',
                    ],
                    [
                        104,
                        'Hot',
                        'Elegant Backpack',
                        25,
                        'https://img.drz.lazcdn.com/static/pk/p/78ab184c04af0654e886b8e32cc4c79c.jpg_720x720q80.jpg',
                    ],
                    [
                        105,

                        'Editor’s Pick',
                        'Stylish Leather Handbag',
                        30,
                        'https://img.drz.lazcdn.com/static/pk/p/35bd901ad0d2d40a4f21da83299237aa.jpg_960x960q80.jpg_.webp',
                    ],
                    [
                        106,
                        'New',
                        'Mini Crossbody Bag',
                        28,
                        'https://img.drz.lazcdn.com/static/pk/p/bc5206bf28b64ae2cca1f3eae4fff0e3.jpg_720x720q80.jpg',
                    ],
                    [
                        107,
                        'Limited',
                        'Trendy Tote Bag',
                        28,
                        'https://pk-live-21.slatic.net/kf/Sd3a1848ab8f949b28fcece7edba362c6s.jpg',
                    ],
                    [
                        108,
                        'Popular',
                        'Elegant Backpack',
                        28,
                        'https://img.drz.lazcdn.com/static/pk/p/d8606c6f0a4ff266ddf452639dfbe97b.jpg_720x720q80.jpg',
                    ],
                ];
            @endphp

            @foreach ($featured as $p)
                <article class="mb-5 bg-white rounded-xl shadow transition overflow-hidden product-card relative"
                    data-aos="flip-up" data-aos-duration="1200"
                    onmouseenter="speakProductInfo('Check out our {{ $p[2] }}, now available for just ${{ $p[3] }}. This is a {{ $p[1] }} item, so don’t miss your chance!')">
                    <!-- Product Image + Badge -->
                    <div class="relative aspect-square">
                        <span
                            class="absolute top-2 left-2 bg-[var(--brand)] text-white text-xs px-2 py-1 rounded-md shadow-sm">
                            {{ $p[1] }}
                        </span>
                        <img src="{{ $p[4] }}" alt="{{ $p[2] }}" class="w-full h-full object-cover">

                        <!-- Add to Cart Overlay -->
                        <div
                            class="anim_appear-bottom position-absolute bottom-0 start-0 end-0 d-flex align-items-center p-2 gap-2 justify-content-center">

                            <button class="btn btn-sm text-white js-add-to-cart"
                                style="background-color:#b56576; border-color:#b56576; border-radius:10px"
                                data-id="{{ $p[0] }}" data-name="{{ $p[2] }}"
                                data-price="{{ $p[3] }}" data-qty="1" title="Add To Cart"><i
                                    class="fa-solid fa-cart-shopping"></i></button>

                            <button class="btn btn-sm btn-outline-secondary js-add-to-wishlist" style="border-radius:10px"
                                data-id="{{ $p[0] }}" data-name="{{ $p[2] }}"
                                data-price="{{ $p[3] }}" data-qty="1" title="Add To Wishlist">♡</button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-sm min-h-[2.5rem]">{{ $p[2] }}</h3>
                        <div class="flex items-center justify-between mt-1">
                            <div class="font-extrabold">${{ $p[3] }}</div>
                            <div class="text-yellow-500 text-sm">★★★★★</div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <style>
            /* Hidden by default */
            .anim_appear-bottom {
                /* opacity: 0;
                                                                                                                                                        transform: translateY(20px);
                                                                                                                                                        transition: all 0.3s ease; */
            }

            /* Show on hover */
            .product-card:hover .anim_appear-bottom {
                opacity: 1;
                transform: translateY(0);
            }

            /* Hidden by default */
            .anim_appear-bottom {
                /* opacity: 0;
                                                                                                                                                        transform: translateY(20px);
                                                                                                                                                        transition: all 0.3s ease; */
            }

            /* Show on hover */
            .product-card:hover .anim_appear-bottom {
                opacity: 1;
                transform: translateY(0);
            }

            /* Card hover effect */
            .product-card {
                /* transition: box-shadow 0.3s ease !important; */
                border-radius: 12px;
            }

            /* Force hover effect to apply */
            .product-card:hover {
                transform: translateY(-8px) scale(1.03) !important;
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
            }

            .view-all-btn {
                transition: all 0.3s ease;
            }

            .view-all-btn:hover {
                background-color: #b56576 !important;
                color: #fff !important;
                transform: translateY(-3px);
                /* halka lift effect */
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }
        </style>
        <script>
            let availableVoices = [];

            function loadVoices() {
                availableVoices = window.speechSynthesis.getVoices();
            }
            window.speechSynthesis.onvoiceschanged = loadVoices;

            function speakProductInfo(text) {
            
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();

                    const speech = new SpeechSynthesisUtterance(text);

                    // female english voice try karo
                    if (availableVoices.length > 0) {
                        const femaleVoice = availableVoices.find(v =>
                            v.lang.includes("en") && v.name.toLowerCase().includes("female")
                        );
                        speech.voice = femaleVoice || availableVoices.find(v => v.lang === "en-GB") || availableVoices[0];
                    }

                    // thoda soft aur natural lagne ke liye
                    speech.pitch = 1.2; // zyada soft tone
                    speech.rate = 0.95; // thoda slow
                    speech.volume = 1; // full volume

                    window.speechSynthesis.speak(speech);
                }
            }
        </script>

        <div class="flex justify-center mt-6 mb-5">
            <a href="{{ route('shop.index') }}" data-aos="flip-up" data-aos-duration="1200"
                class="px-4 sm:px-6 py-2 border border-[#b56576] rounded-full text-base sm:text-sm font-medium text-[#b56576] hover:bg-[#b56576] hover:text-white transition">
                View All
            </a>

        </div>

    </section>
    <div id="chat-popup"
        style="position: fixed; bottom: 20px; right: 20px; width: 300px; 
       background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); display:none;">
        <div style="background:#b56576; color:white; padding:10px; border-radius:10px 10px 0 0;">
            Chat with us
            <button onclick="closeChat()" style="float:right; background:none; border:none; color:white;">×</button>
        </div>
        <div id="chat-body" style="padding:10px; height:200px; overflow-y:auto; font-size:14px;">
            <div><b>Bagverse:</b> Hello 👋 How can I help you?</div>
        </div>
        <div style="padding:10px; display:flex; gap:5px;">
            <input id="chat-input" type="text" placeholder="Type a message..."
                style="flex:1; padding:5px; border:1px solid #ddd; border-radius:5px;">
            <button onclick="sendMessage()"
                style="background:#b56576; color:white; border:none; padding:6px 10px; border-radius:5px;">Send</button>
        </div>
    </div>

    <!-- Floating button -->
    <button onclick="openChat()"
        style="position:fixed; bottom:20px; right:20px; background:#b56576; color:white; border:none; border-radius:50%; width:50px; height:50px; font-size:20px;">
        💬
    </button>
    <!-- WhatsApp Floating Button with Icon -->
    <a href="https://wa.me/923162299686" target="_blank"
        style="position:fixed; bottom:90px; right:20px; 
          background:#25D366; color:white; border:none; 
          border-radius:50%; width:50px; height:50px; 
          display:flex; justify-content:center; align-items:center; 
          font-size:24px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); text-decoration:none;">
        <!-- WhatsApp SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="white">
            <path
                d="M16 3C8.82 3 3 8.82 3 16c0 2.84.83 5.48 2.27 7.7L3 29l5.4-2.24C10.46 27.17 13.1 28 16 28c7.18 0 13-5.82 13-13S23.18 3 16 3zm7.13 18.63c-.3.84-1.72 1.57-2.36 1.65-.61.08-1.36.11-2.03-.09-3.09-.61-5.1-3.58-5.26-3.75-.16-.18-1.3-1.67-1.3-3.18s1.33-3.68 1.51-3.88c.18-.2.38-.3.61-.3.23 0 .44.01.63.01.2 0 .46-.08.71.55.26.63.88 2.19.95 2.36.08.18.13.38.02.61-.11.23-.16.38-.32.59-.16.21-.34.47-.48.64-.15.18-.31.37-.13.71.18.33.8 1.33 1.71 2.14 1.18 1.07 2.17 1.42 2.47 1.58.3.16.48.14.66-.08.18-.22.78-.91.98-1.22.2-.31.41-.26.7-.16.28.11 1.76.83 2.06.98.3.16.5.23.57.36.07.13.07.77-.23 1.61z" />
        </svg>
    </a>

    <script>
        function openChat() {
            document.getElementById('chat-popup').style.display = 'block';
        }

        function closeChat() {
            document.getElementById('chat-popup').style.display = 'none';
        }

        function sendMessage() {
            let input = document.getElementById('chat-input');
            let msg = input.value.trim();
            if (msg === "") return;

            let chatBody = document.getElementById('chat-body');
            chatBody.innerHTML += `<div><b>You:</b> ${msg}</div>`;

            // Auto reply with clickable WhatsApp number
            setTimeout(() => {
                chatBody.innerHTML += `<div><b>Bagverse:</b> Thanks for your message!
        Please reach us on WhatsApp: <a href="https://wa.me/03134567" target="_blank"><b>03162299686</b></a></div>`;
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);

            input.value = "";
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    </script>


    <!-- ====================== BRAND SECTIONS (CLEAN) ====================== -->
    {{-- <section class="max-w-5xl mx-auto px-4 mt-14 space-y-4">
        @php
            $brands = [
                [
                    'id' => 'louisvuitton',
                    'title' => 'Louis Vuitton',
                    'short' =>
                        'Louis Vuitton is the world’s most iconic luxury bag brand, known for craftsmanship and timeless designs like Speedy, Neverfull, and Alma.',
                    'full' =>
                        'Founded in 1854 (Paris). Signature lines: Speedy, Neverfull, Alma, Capucines. Monogram canvas & premium leathers. Global prestige & investment value.',
                ],
                [
                    'id' => 'gucci',
                    'title' => 'Gucci',
                    'short' =>
                        'Gucci blends bold design with Italian craft. Icons include GG Marmont, Dionysus, and Jackie 1961.',
                    'full' =>
                        'Est. 1921 (Florence). Signatures: GG Marmont, Dionysus, Ophidia, Jackie 1961. Double-G, bamboo handles, horsebit. Reinvents classics with modern twists.',
                ],
                [
                    'id' => 'prada',
                    'title' => 'Prada',
                    'short' =>
                        'Prada is known for minimalist design & innovation. Galleria, Re-Edition Nylon, and Cleo are customer favorites.',
                    'full' =>
                        'Est. 1913 (Milan). Signatures: Galleria Saffiano, Re-Edition Nylon, Cleo, Cahier. Minimalism, clean lines, innovative nylon; growing recycled lines.',
                ],
            ];
        @endphp

        @foreach ($brands as $b)
            <details class="bg-white rounded-xl shadow p-5">
                <summary class="cursor-pointer text-lg font-semibold text-[var(--brand)]">{{ strtoupper($b['title']) }}
                </summary>
                <div class="mt-3">
                    <p class="text-gray-700">{{ $b['short'] }}</p>
                    <p class="text-gray-600 mt-2">{{ $b['full'] }}</p>
                    <div class="flex gap-2 mt-3">
                        <button onclick="downloadDescription('{{ $b['title'] }}', '{{ $b['full'] }}')"
                            class="px-4 py-2 rounded-md text-white"
                            style="background-color: var(--brand);">Download</button>
                    </div>
                </div>
            </details>
        @endforeach
    </section> --}}

    <!-- ====================== BAGVERSE HERO COPY ====================== -->
    {{-- <section class="max-w-5xl mx-auto px-4 mt-14">
        <div class="bg-white rounded-2xl shadow p-6 md:p-8 text-center">
            <h1 class="text-2xl md:text-3xl font-extrabold">BAGVERSE PAKISTAN</h1>
            <p class="text-sm tracking-wide text-gray-500">LUXURY & ELEGANCE FOR YOUR STYLE</p>
            <div class="text-gray-700 space-y-3 mt-4 text-sm md:text-base">
                <p>Bagverse is a premium brand with decades of craftsmanship and millions of happy customers.</p>
                <p>Enjoy free delivery, warranty, and easy returns on original branded bags at affordable prices.</p>
                <p>Cash on delivery across major cities in Pakistan.</p>
                <p class="font-medium">Collection: Handbags • Shoulder Bags • Tote Bags • Backpacks • Clutches • Wallets
                </p>
            </div>
        </div>
    </section> --}}

    <!-- ====================== HIDDEN FORMS ====================== -->
    <form id="cartAddForm" action="{{ route('cart.add') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="id">
        <input type="hidden" name="name">
        <input type="hidden" name="price">
        <input type="hidden" name="quantity" value="1">
    </form>

    <form id="wishlistAddForm" action="{{ route('wishlist.add') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="id">
        <input type="hidden" name="name">
        <input type="hidden" name="price">
        <input type="hidden" name="quantity" value="1">
    </form>
    <!-- Contact Section -->
    <section id="contact" class="py-5" style="font-family: 'Poppins', sans-serif; background:#f9f9f9;"
        data-aos="fade-up" data-aos-duration="3000">
        <div class="container">
            <!-- Heading -->
            <div class="text-center mb-5">
                <h2 style="font-size:32px; font-weight:700; color:#b56576; font-family: 'Playfair Display', serif;">Contact
                    Us</h2>
                <p style="color:#666; font-size:16px; margin-top:10px;">Feel free to reach out anytime. We'd love to hear
                    from you.</p>
            </div>

            <!-- Contact Info -->
            <div class="row g-4 mb-5 text-center">
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm h-100" style="background:#fff;" data-aos="flip-up"
                        data-aos-duration="1200">
                        <i class="fas fa-mobile-alt mb-3" style="font-size:30px; color:#b56576;"></i>
                        <h5 style="font-size:18px; font-weight:600;">Call Us</h5>
                        <p style="color:#555; font-size:15px;">1-800-983-233</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm h-100" style="background:#fff;" data-aos="flip-up"
                        data-aos-duration="1200">
                        <i class="far fa-envelope mb-3" style="font-size:30px; color:#b56576;"></i>
                        <h5 style="font-size:18px; font-weight:600;">Email</h5>
                        <p style="color:#555; font-size:15px;">contact@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm h-100" style="background:#fff;" data-aos="flip-up"
                        data-aos-duration="1200">
                        <i class="fas fa-map-pin mb-3" style="font-size:30px; color:#b56576;"></i>
                        <h5 style="font-size:18px; font-weight:600;">Visit Us</h5>
                        <p style="color:#555; font-size:15px;">923 W Crooked Stick Dr, AZ, 85222</p>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="row justify-content-center align-items-stretch g-4 mt-4" data-aos="fade-up"
                data-aos-duration="3000">

                <div class="col-lg-6">
                    <div class="rounded-3 shadow-sm overflow-hidden h-100" style="min-height:100%;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="100%"
                            style="border:0; min-height:400px;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="col-lg-6">
                    <form action="{{ route('contact.store') }}" method="POST" class="p-4 p-md-5 rounded-3 shadow-sm"
                        style="background:#fff;">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Name" required
                                    style="padding:12px; border-radius:8px; border:1px solid #ddd; font-size:15px;">
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Email" required
                                    style="padding:12px; border-radius:8px; border:1px solid #ddd; font-size:15px;">
                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="text" name="subject" class="form-control" placeholder="Subject"
                                style="padding:12px; border-radius:8px; border:1px solid #ddd; font-size:15px;">
                        </div>

                        <div class="mt-3">
                            <textarea name="message" rows="6" placeholder="Your Message" required
                                style="padding:12px; border-radius:8px; border:1px solid #ddd; font-size:15px; resize:none;" class="form-control"></textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" data-aos="flip-up" data-aos-duration="1200"
                                class="px-4 sm:px-6 py-2 border border-[#b56576] rounded-full text-base sm:text-sm font-medium text-[#b56576] hover:bg-[#b56576] hover:text-white transition">
                                Send Message
                            </button>
                        </div>
                    </form>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success mt-3 text-center">
                            {{ session('success') }}
                        </div>
                    @endif


                </div>

                <!-- Google Map -->

            </div>

        </div>

    </section>

    <!-- Bootstrap, FontAwesome & Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

    <!-- ====================== SCRIPTS ====================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const slides = document.querySelectorAll('#hero-slider .slide');
        const buttons = document.querySelectorAll('.slide-btn');
        let current = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.opacity = i === index ? '1' : '0';
            });
            current = index;
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', () => showSlide(parseInt(btn.dataset.slide)));
        });

        // Auto slide every 5 seconds
        setInterval(() => {
            current = (current + 1) % slides.length;
            showSlide(current);
        }, 5000);

        // ---------- HERO SLIDER ----------

        // ---------- COUNTDOWN ----------
        (function() {
            const wrap = document.getElementById('deal-countdown');
            if (!wrap) return;
            const deadline = new Date(wrap.dataset.deadline);
            const parts = {
                days: wrap.querySelector('[data-part="days"]'),
                hours: wrap.querySelector('[data-part="hours"]'),
                mins: wrap.querySelector('[data-part="mins"]'),
                secs: wrap.querySelector('[data-part="secs"]')
            };

            function tick() {
                const now = new Date();
                let diff = Math.max(0, deadline - now);
                const d = Math.floor(diff / 86400000);
                diff %= 86400000;
                const h = Math.floor(diff / 3600000);
                diff %= 3600000;
                const m = Math.floor(diff / 60000);
                diff %= 60000;
                const s = Math.floor(diff / 1000);
                parts.days.textContent = d;
                parts.hours.textContent = h;
                parts.mins.textContent = m;
                parts.secs.textContent = s;
            }
            tick();
            setInterval(tick, 1000);
        })();

        // ---------- SWIPER INIT (generic) ----------
        document.querySelectorAll('.js-swiper-slider').forEach(el => {
            const opts = JSON.parse(el.getAttribute('data-settings') || '{}');
            new Swiper(el, opts);
        });

        // ---------- CART / WISHLIST ----------
        document.querySelectorAll('.js-add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const f = document.getElementById('cartAddForm');
                f.querySelector('[name="id"]').value = btn.dataset.id;
                f.querySelector('[name="name"]').value = btn.dataset.name;
                f.querySelector('[name="price"]').value = btn.dataset.price;
                f.querySelector('[name="quantity"]').value = btn.dataset.qty || 1;
                f.submit();
            });
        });
        document.querySelectorAll('.js-add-to-wishlist').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const f = document.getElementById('wishlistAddForm');
                f.querySelector('[name="id"]').value = btn.dataset.id;
                f.querySelector('[name="name"]').value = btn.dataset.name;
                f.querySelector('[name="price"]').value = btn.dataset.price;
                f.querySelector('[name="quantity"]').value = btn.dataset.qty || 1;
                f.submit();
            });
        });

        // ---------- Download helper (brands) ----------
        function downloadDescription(title, text) {
            const blob = new Blob([text], {
                type: 'text/plain;charset=utf-8'
            });
            const url = URL.createObjectURL(blob);
            const a = Object.assign(document.createElement('a'), {
                href: url,
                download: `${title}.txt`
            });
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        }
        window.downloadDescription = downloadDescription;
    </script>

@endsection
