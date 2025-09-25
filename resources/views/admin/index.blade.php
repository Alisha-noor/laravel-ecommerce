@extends('layouts.admin')

@section('content')
    {{-- 
        Improvements:
        - Strong null-safety & numeric-casting for KPIs
        - Consistent money/date formatting regardless of input type
        - Safe items_count fallback without method_exists()
        - Status badge mapper centralised
        - Works if $recentOrders is null/empty
        - Keeps Tailwind layout; tiny CSS kept inline for portability
    --}}

    @php
        // ---------- Tiny helpers (scoped to this view) ----------
        $toInt = fn($v) => is_numeric($v) ? (int) $v : 0;
        $toFloat = fn($v) => is_numeric($v) ? (float) $v : 0.0;

        $fmtInt = fn($v) => number_format($toInt($v));
        $fmtMoney = fn($v) => number_format($toFloat($v), 2);

        $fmtDateTime = function ($v) {
            if ($v instanceof \Illuminate\Support\Carbon) {
                return $v->format('Y-m-d H:i');
            }
            if (is_string($v) && trim($v) !== '') {
                try {
                    return \Illuminate\Support\Carbon::parse($v)->format('Y-m-d H:i');
                } catch (\Throwable $e) {
                    return e($v); // show raw if unparsable
                }
            }
            return '—';
        };

        $fmtDate = function ($v) {
            if ($v instanceof \Illuminate\Support\Carbon) {
                return $v->format('Y-m-d');
            }
            if (is_string($v) && trim($v) !== '') {
                try {
                    return \Illuminate\Support\Carbon::parse($v)->format('Y-m-d');
                } catch (\Throwable $e) {
                    return e($v);
                }
            }
            return '—';
        };

        $statusClass = function ($status) {
            $s = strtolower((string)$status);
            return match ($s) {
                'delivered' => 'status-delivered',
                'canceled', 'cancelled' => 'status-canceled',
                default => 'status-pending',
            };
        };

        $safeItemsCount = function ($order) {
            // Prefer withCount('items') -> items_count
            if (isset($order->items_count) && is_numeric($order->items_count)) {
                return (int) $order->items_count;
            }
            // Fallback to loaded relation (if any)
            if (isset($order->items) && $order->items) {
                try { return $order->items->count(); } catch (\Throwable $e) { /* ignore */ }
            }
            return 0;
        };

        // Guard collections
        $recent = collect($recentOrders ?? []);
    @endphp

    <style>
        /* Keep only small additions; rely on Tailwind for most responsive behavior */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .status-badge {
            display: inline-flex; align-items: center; padding: .25rem .5rem;
            border-radius: .375rem; font-weight: 600; font-size: .75rem; line-height: 1rem;
        }
        .status-pending   { color:#9a3412; background:#fff7ed; } /* orange-800 on orange-50 */
        .status-delivered { color:#065f46; background:#ecfdf5; } /* emerald-800 on emerald-50 */
        .status-canceled  { color:#991b1b; background:#fef2f2; } /* red-800 on red-50 */

        .orders-mobile { display:grid; gap:.75rem; }
        @media (min-width: 768px) { .orders-mobile { display:none; } }
        .orders-desktop { display:none; }
        @media (min-width: 768px) { .orders-desktop { display:block; } }
    </style>

    <div class="container mx-auto p-4 md:p-6">
        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            {{-- Total Orders --}}
            <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="icon-shopping-bag text-xl text-pink-700"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $fmtInt($totalOrders ?? 0) }}</h4>
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="icon-clock text-xl text-orange-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending Orders</p>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $fmtInt($pendingOrders ?? 0) }}</h4>
                </div>
            </div>

            {{-- Delivered --}}
            <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="icon-check-circle text-xl text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Delivered Orders</p>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $fmtInt($deliveredOrders ?? 0) }}</h4>
                </div>
            </div>

            {{-- Canceled --}}
            <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="icon-x-circle text-xl text-red-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Canceled Orders</p>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $fmtInt($canceledOrders ?? 0) }}</h4>
                </div>
            </div>

            {{-- Canceled Amount --}}
            <div class="bg-white p-4 rounded-xl shadow-md flex items-center gap-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="icon-dollar-sign text-xl text-pink-700"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Canceled Orders Amount</p>
                    <h4 class="text-xl font-semibold text-gray-800">${{ $fmtMoney($canceledAmount ?? 0) }}</h4>
                </div>
            </div>
        </div>

        {{-- Earnings --}}
        <div class="bg-white p-6 rounded-xl shadow-md mt-6">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Earnings Revenue</h5>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-xs text-gray-500">Revenue</span>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800">
                        ${{ $fmtMoney($revenue ?? 0) }}
                    </h4>
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="text-xs text-gray-500">Orders Value</span>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800">
                        ${{ $fmtMoney($orderRevenue ?? 0) }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white p-6 rounded-xl shadow-lg mt-6">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold text-gray-800">Recent Orders</h5>
            </div>

            {{-- Mobile cards --}}
            <div class="orders-mobile">
                @forelse($recent as $order)
                    @php
                        $count = $safeItemsCount($order);
                        $createdAt = $fmtDateTime($order->created_at ?? null);
                        $deliveredOn = $fmtDate($order->delivered_on ?? null);
                        $badge = $statusClass($order->status ?? null);
                    @endphp

                    <div class="border rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="font-semibold text-gray-800">Order #{{ e($order->id) }}</h6>
                            <span class="status-badge {{ $badge }}">{{ ucfirst($order->status ?? 'pending') }}</span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div><span class="font-medium text-gray-700">Name:</span> {{ e($order->customer_name ?? '—') }}</div>
                            <div><span class="font-medium text-gray-700">Phone:</span> {{ e($order->phone ?? '—') }}</div>
                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <div class="text-xs text-gray-500">Subtotal</div>
                                    <div class="font-semibold">${{ $fmtMoney($order->subtotal ?? 0) }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Tax</div>
                                    <div class="font-semibold">${{ $fmtMoney($order->tax ?? 0) }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Total</div>
                                    <div class="font-semibold">${{ $fmtMoney($order->total ?? 0) }}</div>
                                </div>
                            </div>
                            <div><span class="font-medium text-gray-700">Order Date:</span> {{ $createdAt }}</div>
                            <div><span class="font-medium text-gray-700">Items:</span> {{ $count }}</div>
                            <div><span class="font-medium text-gray-700">Delivered On:</span> {{ $deliveredOn }}</div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="text-pink-700 hover:text-pink-800 text-sm font-medium inline-flex items-center gap-1">
                                <i class="icon-eye text-base"></i> View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">No recent orders found.</div>
                @endforelse
            </div>

            {{-- Desktop table --}}
            <div class="orders-desktop">
                <div class="table-wrap">
                    <table class="w-full min-w-[900px] border-collapse">
                        <thead class="bg-gray-100 text-gray-600 text-sm">
                            <tr>
                                <th class="p-3 text-center font-semibold">Order No</th>
                                <th class="p-3 text-center font-semibold">Name</th>
                                <th class="p-3 text-center font-semibold">Phone</th>
                                <th class="p-3 text-center font-semibold">Subtotal</th>
                                <th class="p-3 text-center font-semibold">Tax</th>
                                <th class="p-3 text-center font-semibold">Total</th>
                                <th class="p-3 text-center font-semibold">Status</th>
                                <th class="p-3 text-center font-semibold">Order Date</th>
                                <th class="p-3 text-center font-semibold">Items</th>
                                <th class="p-3 text-center font-semibold">Delivered On</th>
                                <th class="p-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent as $order)
                                @php
                                    $count = $safeItemsCount($order);
                                    $createdAt = $fmtDateTime($order->created_at ?? null);
                                    $deliveredOn = $fmtDate($order->delivered_on ?? null);
                                    $badge = $statusClass($order->status ?? null);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-center">{{ e($order->id) }}</td>
                                    <td class="p-3 text-center">{{ e($order->customer_name ?? '—') }}</td>
                                    <td class="p-3 text-center">{{ e($order->phone ?? '—') }}</td>
                                    <td class="p-3 text-center">${{ $fmtMoney($order->subtotal ?? 0) }}</td>
                                    <td class="p-3 text-center">${{ $fmtMoney($order->tax ?? 0) }}</td>
                                    <td class="p-3 text-center">${{ $fmtMoney($order->total ?? 0) }}</td>
                                    <td class="p-3 text-center">
                                        <span class="status-badge {{ $badge }}">{{ ucfirst($order->status ?? 'pending') }}</span>
                                    </td>
                                    <td class="p-3 text-center">{{ $createdAt }}</td>
                                    <td class="p-3 text-center">{{ $count }}</td>
                                    <td class="p-3 text-center">{{ $deliveredOn }}</td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}">
                                            <i class="icon-eye text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="p-6 text-center text-gray-500">No recent orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
