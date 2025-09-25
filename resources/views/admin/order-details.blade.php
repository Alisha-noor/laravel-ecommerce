@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
  <div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
      <h3>Order #{{ $order->order_no }}</h3>
      <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
        <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
        <li><i class="icon-chevron-right"></i></li>
        <li><a href="{{ route('admin.orders.index') }}"><div class="text-tiny">Orders</div></a></li>
        <li><i class="icon-chevron-right"></i></li>
        <li><div class="text-tiny">Details</div></li>
      </ul>
    </div>

    <div class="wg-box mb-4">
      <div class="grid" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;">
        <div><strong>Customer</strong><div>{{ $order->name }}</div></div>
        <div><strong>Phone</strong><div>{{ $order->phone }}</div></div>
        <div><strong>Status</strong><div class="text-capitalize">{{ $order->status }}</div></div>
        <div><strong>Order Date</strong><div>{{ $order->created_at->format('Y-m-d H:i') }}</div></div>

        <div><strong>Tracking #</strong><div>{{ $order->tracking_number ?? '-' }}</div></div>
        <div><strong>Delivered</strong><div>{{ $order->delivered_date ? $order->delivered_date->format('Y-m-d') : '-' }}</div></div>
        <div><strong>Items</strong><div>{{ $order->items_count }}</div></div>
        <div><strong>Subtotal</strong><div>${{ number_format($order->subtotal ?? 0, 2) }}</div></div>
        <div><strong>Tax</strong><div>${{ number_format($order->tax, 2) }}</div></div>
        <div><strong>Total</strong><div>${{ number_format($order->total, 2) }}</div></div>
      </div>
    </div>

    @if($order->notes)
      <div class="wg-box mb-4"><strong>Notes</strong><div>{{ $order->notes }}</div></div>
    @endif

    @if($transaction)
      <div class="wg-box mb-4">
        <h4>Transaction</h4>
        <div class="grid" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;">
          <div><strong>Status</strong><div class="text-capitalize">{{ $transaction->status }}</div></div>
          <div><strong>Method</strong><div>{{ $transaction->method ?? '-' }}</div></div>
          <div><strong>Amount</strong><div>${{ number_format($transaction->amount ?? 0, 2) }}</div></div>
          <div><strong>Code</strong><div>{{ $transaction->code ?? '-' }}</div></div>
        </div>
      </div>
    @endif

    <div class="wg-box">
      <h4 class="mb-3">Order Items</h4>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>SKU</th>
              <th>Name</th>
              <th class="text-center">Qty</th>
              <th class="text-center">Price</th>
              <th class="text-center">Line Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orderitems as $i => $item)
              <tr>
                <td>{{ $orderitems->firstItem() + $i }}</td>
                <td>{{ $item->sku ?? '-' }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-center">${{ number_format($item->price, 2) }}</td>
                <td class="text-center">${{ number_format($item->total, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        {{ $orderitems->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</div>
@endsection
