@extends('layouts.admin')

@section('content')
    {{-- Scoped styles just for this view --}}
    <style>
        .coupon-form { display: grid; gap: 16px; }
        .coupon-form__row { display: grid; gap: 8px; }
        .coupon-form__label { font-weight: 600; font-size: .95rem; }
        .coupon-form__hint { color:#64748b; font-size:.85rem; }

        .c-input, .c-select, .c-date {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: .95rem;
            background: #fff;
        }
        .c-input:focus, .c-select:focus, .c-date:focus {
            outline: none;
            border-color: #b56576;
            box-shadow: 0 0 0 3px rgba(181,101,118,.12);
        }

        .actions { display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap; }

        /* Two columns on md+ screens */
        @media (min-width: 768px) {
            .coupon-form { grid-template-columns: 1fr 1fr; }
            .coupon-form__row--full { grid-column: 1 / -1; }
        }

        /* Full-width buttons on small screens */
        @media (max-width: 767.98px) {
            .actions .tf-button { width: 100%; }
        }

        .text-danger { color:#dc2626; }
        .mt-8 { margin-top:8px; }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3 class="mb-0">Coupon Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10 mb-0">
                    <li>
                        <a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.coupons') }}"><div class="text-tiny">Coupons</div></a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">New Coupon</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}" novalidate>
                    @csrf

                    <div class="coupon-form">
                        {{-- Coupon Code --}}
                        <div class="coupon-form__row">
                            <label for="code" class="coupon-form__label">Coupon Code <span class="tf-color-1">*</span></label>
                            <input
                                id="code"
                                class="c-input"
                                type="text"
                                name="code"
                                placeholder="e.g. SAVE20"
                                value="{{ old('code') }}"
                                required
                                aria-required="true"
                                autocomplete="off"
                            />
                            @error('code')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="coupon-form__row">
                            <label for="type" class="coupon-form__label">Coupon Type <span class="tf-color-1">*</span></label>
                            <select id="type" name="type" class="c-select" required aria-required="true">
                                <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select</option>
                                <option value="fixed"  @selected(old('type') === 'fixed')>Fixed</option>
                                <option value="percent" @selected(old('type') === 'percent')>Percent</option>
                            </select>
                            @error('type')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Value --}}
                        <div class="coupon-form__row">
                            <label for="value" class="coupon-form__label">Value <span class="tf-color-1">*</span></label>
                            <input
                                id="value"
                                class="c-input"
                                type="number"
                                step="0.01"
                                min="0"
                                name="value"
                                placeholder="e.g. 20 or 20.00"
                                value="{{ old('value') }}"
                                required
                                aria-required="true"
                                inputmode="decimal"
                            />
                            <p id="valueHint" class="coupon-form__hint">
                                {{ old('type') === 'percent' ? 'Use a whole number for percent (e.g., 20 = 20%).' : 'Use the amount to discount (e.g., 20.00).' }}
                            </p>
                            @error('value')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Minimum Cart Value (matches DB column) --}}
                        <div class="coupon-form__row">
                            <label for="cart_min_value" class="coupon-form__label">Minimum Cart Value <span class="tf-color-1">*</span></label>
                            <input
                                id="cart_min_value"
                                class="c-input"
                                type="number"
                                step="0.01"
                                min="0"
                                name="cart_min_value"
                                placeholder="Minimum cart amount"
                                value="{{ old('cart_min_value', old('cart_value')) }}"
                                required
                                aria-required="true"
                                inputmode="decimal"
                            />
                            {{-- Show error for either key (controller may validate either) --}}
                            @error('cart_min_value')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                            @error('cart_value')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Expiry Date (full width) --}}
                        <div class="coupon-form__row coupon-form__row--full">
                            <label for="expiry_date" class="coupon-form__label">Expiry Date <span class="tf-color-1">*</span></label>
                            <input
                                id="expiry_date"
                                class="c-date"
                                type="date"
                                name="expiry_date"
                                value="{{ old('expiry_date') }}"
                                required
                                aria-required="true"
                            />
                            @error('expiry_date')
                                <span class="text-danger mt-8">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="actions" style="margin-top:16px;">
                        <a href="{{ route('admin.coupons') }}" class="tf-button" style="background:#e5e7eb; color:#111;">Cancel</a>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tiny UX: change value hint based on type --}}
    @push('scripts')
    <script>
        (function(){
            const typeSel = document.getElementById('type');
            const hint = document.getElementById('valueHint');
            if (!typeSel || !hint) return;

            const updateHint = () => {
                if (typeSel.value === 'percent') {
                    hint.textContent = 'Use a whole number for percent (e.g., 20 = 20%).';
                } else {
                    hint.textContent = 'Use the amount to discount (e.g., 20.00).';
                }
            };
            typeSel.addEventListener('change', updateHint);
            updateHint();
        })();
    </script>
    @endpush
@endsection
