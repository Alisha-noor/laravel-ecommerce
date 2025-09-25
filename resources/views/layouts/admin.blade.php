<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BagVerse Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    {{-- Bootstrap (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Your assets (avoid including another bootstrap.css to prevent conflicts) --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">

    {{-- Icons --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">

    <style>
        :root {
            --sidebar-w: 260px;
            --brand-color: #b56576;
        }

        body {
            background: #f4f4f4;
        }

        /* Layout wrapper */
        #wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: row;
        }

        /* SIDEBAR */
        .section-menu-left {
            width: var(--sidebar-w);
            background: #fff;
            border-right: 1px solid #e5e7eb;
            padding: 16px 16px 24px;
            position: fixed;
            top: 56px;
            /* equal to navbar height */
            left: 0;
            bottom: 0;
            overflow: auto;
            transform: translateX(0);
            transition: transform .25s ease-in-out;
            z-index: 1030;
        }

        /* collapsed on mobile by default */
        @media (max-width: 991.98px) {
            .section-menu-left {
                transform: translateX(-100%);
            }

            .section-menu-left.open {
                transform: translateX(0);
            }
        }

        .box-logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .box-logo a {
            text-decoration: none;
            color: var(--brand-color);
            font-weight: 700;
            font-size: 28px;
        }

        .menu-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .menu-item>a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            transition: background-color .2s;
        }

        .menu-item>a:hover {
            background: #f3f4f6;
        }

        .icon {
            color: var(--brand-color);
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        /* Submenu (click-to-toggle) */
        .sub-menu {
            list-style: none;
            padding-left: 35px;
            margin: 6px 0 8px;
            display: none;
        }

        .menu-item.open>.sub-menu {
            display: block;
        }

        .sub-menu-item a {
            display: block;
            padding: 8px 10px;
            border-radius: 6px;
            color: #444;
            text-decoration: none;
        }

        .sub-menu-item a:hover {
            background: #f7f7f7;
        }

        /* MAIN AREA */
        .main-area {
            flex: 1;
            width: 100%;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        @media (max-width: 991.98px) {
            .main-area {
                margin-left: 0;
            }
        }

        /* Navbar pinned to top */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            height: 56px;
            display: flex;
            align-items: center;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 12px;
        }

        .topbar .brand {
            color: var(--brand-color);
            text-decoration: none;
            font-weight: 700;
            font-size: 20px;
        }

        .topbar .form-search {
            max-width: 480px;
            width: 100%;
        }

        /* Content card */
        .content-wrap {
            margin-top: 56px;
            /* below navbar */
            padding: 18px;
            min-height: calc(100vh - 56px);
        }

        .main-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06);
        }

        .bottom-page {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        /* Table helpers */
        .table-responsive {
            margin-top: 10px;
        }

        .table th {
            background: #f7f7f7;
        }

        /* Utility */
        .btn-brand {
            background: var(--brand-color);
            color: #fff;
            border: none;
        }

        .btn-brand:hover {
            background: #a05465;
            color: #fff;
        }

        .menu-caret {
            margin-left: auto;
            transition: transform .2s ease;
        }

        .menu-item.open>a .menu-caret {
            transform: rotate(90deg);
        }
    </style>
</head>

<body>

    {{-- Top navbar (combined with sidebar via hamburger) --}}
    <nav class="topbar">
        <button id="hamburger" class="btn btn-link d-lg-none me-2" type="button" aria-label="Toggle sidebar">
            <i class="bi bi-list" style="font-size:1.5rem;"></i>
        </button>

        <a href="{{ route('admin.index') }}" class="brand me-3">ADMIN DASHBOARD</a>

        <form class="form-search d-flex gap-2 ms-auto me-3" role="search" action="#" method="GET">
            <input name="q" class="form-control" type="search" placeholder="Search here..." aria-label="Search"
                required>
            <button class="btn btn-brand" style="width: 90px;" type="submit"><i class="bi bi-search"></i></button>
        </form>

        {{-- Right controls (profile/settings) --}}
    </nav>

    <div id="wrapper">
        {{-- Sidebar --}}
        <aside class="section-menu-left" id="sidebar">
            <div class="box-logo">
                <a href="{{ route('admin.index') }}">BagVerse</a>
            </div>

            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('admin.index') }}">
                        <span class="icon"><i class="icon-grid"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0)" class="menu-item-button">
                        <span class="icon"><i class="icon-shopping-cart"></i></span>
                        <span class="text">Products</span>
                        <i class="bi bi-chevron-right menu-caret"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item"><a href="{{ route('admin.product.add') }}">Add Product</a></li>
                        <li class="sub-menu-item"><a href="{{ route('admin.products') }}">Products</a></li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0)" class="menu-item-button">
                        <span class="icon"><i class="icon-layers"></i></span>
                        <span class="text">Brand</span>
                        <i class="bi bi-chevron-right menu-caret"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item"><a href="{{ route('admin.brand.add') }}">New Brand</a></li>
                        <li class="sub-menu-item"><a href="{{ route('admin.brands') }}">Brands</a></li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0)" class="menu-item-button">
                        <span class="icon"><i class="icon-layers"></i></span>
                        <span class="text">Category</span>
                        <i class="bi bi-chevron-right menu-caret"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item"><a href="{{ route('admin.category.add') }}">New Category</a></li>
                        <li class="sub-menu-item"><a href="{{ route('admin.categories') }}">Categories</a></li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0)" class="menu-item-button">
                        <span class="icon"><i class="icon-file-plus"></i></span>
                        <span class="text">Order</span>
                        <i class="bi bi-chevron-right menu-caret"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="sub-menu-item"><a href="{{ route('admin.orders.create') }}">Add Order</a></li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="#">
                        <span class="icon"><i class="icon-image"></i></span>
                        <span class="text">Slider</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.coupons') }}">
                        <span class="icon"><i class="icon-grid"></i></span>
                        <span class="text">Coupons</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.reviews') }}">
                        <span class="icon"><i class="icon-grid"></i></span>
                        <span class="text">Reviews</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="">
                        <span class="icon"><i class="icon-user"></i></span>
                        <span class="text">User</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#">
                        <span class="icon"><i class="icon-settings"></i></span>
                        <span class="text">Settings</span>
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Main area --}}
        <main class="main-area">
            <div class="content-wrap">
                <div class="main-content">
                    {{-- Example chart slot (ApexCharts) --}}
                    <div id="line-chart-8" class="mb-4"></div>

                    {{-- Page content from child views --}}
                    @yield('content')

                    <div class="bottom-page">
                        <div class="body-text">Copyright © 2024 SurfsideMedia</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Core JS --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- Use one Bootstrap JS (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Optional vendor JS --}}
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- ApexCharts (CDN alternative; keep one source) --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

    <script>
        // === Sidebar toggle (navbar + sidebar combined) ===
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
        }
        if (hamburger) {
            hamburger.addEventListener('click', toggleSidebar);
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const isMobile = window.matchMedia('(max-width: 991.98px)').matches;
            if (!isMobile) return;
            if (!sidebar.contains(e.target) && !hamburger.contains(e.target) && sidebar.classList.contains(
                'open')) {
                sidebar.classList.remove('open');
            }
        });

        // === Submenu click expand ===
        document.querySelectorAll('.menu-item.has-children > .menu-item-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const parent = btn.closest('.menu-item');
                parent.classList.toggle('open');
            });
        });

        // === Slider guards (only if markup exists) ===
        (function initSlider() {
            const track = document.getElementById('sliderTrack');
            const slides = document.querySelectorAll('.slider-slide');
            const dots = document.querySelectorAll('.slider-dot');
            if (!track || slides.length === 0) return;

            let currentSlide = 0;

            function updateSlide() {
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                dots.forEach((dot, idx) => dot.classList.toggle('active', idx === currentSlide));
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                updateSlide();
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                updateSlide();
            }

            setInterval(nextSlide, 5000);
            dots.forEach(dot => dot.addEventListener('click', () => {
                const n = Number(dot.getAttribute('data-slide'));
                if (!Number.isNaN(n)) {
                    currentSlide = n;
                    updateSlide();
                }
            }));
            updateSlide();
        })();

        // === ApexCharts init (use the local asset version already loaded) ===
        (function initChart() {
            const el = document.querySelector('#line-chart-8');
            if (!el || typeof ApexCharts === 'undefined') return;

            const options = {
                series: [{
                        name: 'Total',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                    },
                    {
                        name: 'Pending',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                    },
                    {
                        name: 'Delivered',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                    },
                    {
                        name: 'Canceled',
                        data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                    },
                ],
                chart: {
                    type: 'bar',
                    height: 325,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '36%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top'
                },
                colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'],
                    labels: {
                        style: {
                            colors: '#212529'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: val => '$' + val.toFixed(2)
                    }
                },
                tooltip: {
                    y: {
                        formatter: val => '$' + Number(val).toFixed(2)
                    }
                },
                stroke: {
                    show: false
                },
                fill: {
                    opacity: 1
                }
            };

            const chart = new ApexCharts(el, options);
            chart.render();
        })();
    </script>
</body>

</html>
