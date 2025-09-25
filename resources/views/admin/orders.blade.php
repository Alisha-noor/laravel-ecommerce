@extends('layouts.admin')

@section('content')
<style>
    .table-striped th:nth-child(1), .table-striped td:nth-child(1){width:100px;}
    .table-striped th:nth-child(2), .table-striped td:nth-child(2){width:250px;}
</style>

<div class="main-content-inner">
  <div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
  <div>
    <h3>Orders</h3>
    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10" style="margin-top:6px;">
      <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
      <li><i class="icon-chevron-right"></i></li>
      <li><div class="text-tiny">All Orders</div></li>
    </ul>
  </div>

  <div>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">+ Add Order</a>
  </div>
</div>


    <div class="wg-box">
      {{-- Filters --}}
      <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
          <form class="form-search" method="GET" action="{{ route('admin.orders.index') }}">
            <fieldset class="name" style="min-width:260px;">
              <input type="text" placeholder="Search (name / phone / email / tracking / ID) ..." name="q" value="{{ request('q') }}">
            </fieldset>

            <select name="status" style="min-width:160px;">
              @php $curStatus = request('status','all'); @endphp
              <option value="all" {{ $curStatus==='all'?'selected':'' }}>All statuses</option>
              <option value="pending"   {{ $curStatus==='pending'?'selected':'' }}>Pending</option>
              <option value="completed" {{ $curStatus==='completed'?'selected':'' }}>Completed</option>
              <option value="delivered" {{ $curStatus==='delivered'?'selected':'' }}>Delivered</option>
              <option value="canceled"  {{ $curStatus==='canceled'?'selected':'' }}>Canceled</option>
            </select>

            <input type="date" name="from" value="{{ request('from') }}">
            <input type="date" name="to"   value="{{ request('to')   }}">

            <div class="button-submit">
              <button type="submit"><i class="icon-search"></i></button>
            </div>
          </form>
        </div>
      </div>

      {{-- Table --}}
      <div class="wg-table table-all-user">
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Order No</th>
                <th>Name</th>
                <th class="text-center">Phone</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Tax</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Order Date</th>
                <th class="text-center">Total Items</th>
                <th class="text-center">Delivered On</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
              <tr>
                <td class="text-center">{{ $order->order_no }}</td>
                <td class="text-center">{{ $order->name }}</td>
                <td class="text-center">{{ $order->phone }}</td>

                {{-- subtotal comes from withSum alias; format nicely --}}
                <td class="text-center">${{ number_format($order->subtotal ?? 0, 2) }}</td>

                {{-- tax = total - subtotal (via accessor) --}}
                <td class="text-center">${{ number_format($order->tax, 2) }}</td>

                <td class="text-center">${{ number_format($order->total, 2) }}</td>

                <td class="text-center text-capitalize">{{ $order->status }}</td>
                <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>

                {{-- items_count from withCount --}}
                <td class="text-center">{{ $order->items_count }}</td>

                <td class="text-center">
                  {{ $order->delivered_date ? $order->delivered_date->format('Y-m-d') : '-' }}
                </td>

                <td class="text-center">
                  <a href="{{ route('admin.orders.show', $order) }}">
                    <div class="list-icon-function view-icon">
                      <div class="item eye"><i class="icon-eye"></i></div>
                    </div>
                  </a>
                </td>
              </tr>
            @empty
              <tr><td colspan="11" class="text-center">No orders found.</td></tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="divider"></div>
      <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
        {{ $orders->links('pagination::bootstrap-5') }}
      </div>
    </div>
  </div>
</div>
@endsection
