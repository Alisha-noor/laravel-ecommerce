@extends('layouts.admin')

@section('content')
    {{-- Scoped styles for this view --}}
    <style>
        .coupon-grid { display:grid; gap:16px; }
        .coupon-row { display:grid; gap:8px; }
        .coupon-row--full { grid-column: 1 / -1; }
        .coupon-label { font-weight:600; font-size:.95rem; }
        .c-input, .c-select, .c-date {
            width:100%;
            border:1px solid #e5e7eb;
            border-radius:10px;
            padding:10px 12px;
            font-size:.95rem;
            background:#fff;
        }
        .c-input:focus, .c-select:focus, .c-date:focus {
            outline:none;
            border-color:#b56576;
            box-shadow:0 0 0 3px rgba(181,101,118,.12);
        }
        .hint { color:#64748b; font-size:.85rem; }
        .actions { display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap; margin-top:16px; }
        @media (min-width:768px){ .coupon-grid{ grid-template-columns:1fr 1fr; } }
        @media (max-width:767.98px){ .actions .tf-button{ width:100%; } }
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
                    <li><div class="text-tiny">Edit Coupon</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.update') }}" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $coupon->id }}" />

                    <div class="coupon-grid">
                        {{-- Code --}}
                        <div class="coupon-row">
                            <label for="code" class="coupon-label">Coupon Code <span class="tf-color-1">*</span></label>
                            <input
                                id="code"
                                class="c-input"
                                type="text"
                                name="code"
                                placeholder="e.g. SAVE20"
                                value="{{ old('code', $coupon->code) }}"
                                required
                                aria-required="true"
                                autocomplete="off"
                            />
                            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Type --}}
                        <div class="coupon-row">
                            <label for="type" class="coupon-label">Coupon Type <span class="tf-color-1">*</span></label>
                            <select id="type" name="type" class="c-select" required aria-required="true">
                                <option value="" disabled {{ old('type', $coupon->type) ? '' : 'selected' }}>Select</option>
                                <option value="fixed"   @selected(old('type', $coupon->type)==='fixed')>Fixed</option>
                                <option value="percent" @selected(old('type', $coupon->type)==='percent')>Percent</option>
                            </select>
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Value --}}
                        <div class="coupon-row">
                            <label for="value" class="coupon-label">Value <span class="tf-color-1">*</span></label>
                            <input
                                id="value"
                                class="c-input"
                                type="number"
                                step="0.01"
                                min="0"
                                name="value"
                                placeholder="e.g. 20 or 20.00"
                                value="{{ old('value', $coupon->value) }}"
                                required
                                aria-required="true"
                                inputmode="decimal"
                            />
                            <p class="hint">If type is <strong>Percent</strong>, enter a whole number (e.g., 20 = 20%).</p>
                            @error('value') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Cart Value --}}
                        <div class="coupon-row">
                            <label for="cart_value" class="coupon-label">Cart Value <span class="tf-color-1">*</span></label>
                            <input
                                id="cart_value"
                                class="c-input"
                                type="number"
                                step="0.01"
                                min="0"
                                name="cart_value"
                                placeholder="Minimum cart amount"
                                value="{{ old('cart_value', $coupon->cart_value) }}"
                                required
                                aria-required="true"
                                inputmode="decimal"
                            />
                            @error('cart_value') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Expiry (full width) --}}
                        <div class="coupon-row coupon-row--full">
                            <label for="expiry_date" class="coupon-label">Expiry Date <span class="tf-color-1">*</span></label>
                            <input
                                id="expiry_date"
                                class="c-date"
                                type="date"
                                name="expiry_date"
                                value="{{ old('expiry_date', $coupon->expiry_date) }}"
                                required
                                aria-required="true"
                            />
                            @error('expiry_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ route('admin.coupons') }}" class="tf-button" style="background:#e5e7eb; color:#111;">Cancel</a>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
