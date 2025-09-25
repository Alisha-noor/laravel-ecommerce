@extends('layouts.admin')
@section('content')
    <style>
        .table-striped th:nth-child(1),
        .table-striped td:nth-child(1) {
            width: 100px;
        }

        .table-striped th:nth-child(2),
        .table-striped td:nth-child(2) {
            width: 250px;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupons</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All Coupons</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required>
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Cart Value</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
@forelse ($coupons as $coupon)
    <tr>
        <td>{{ $coupon->id }}</td>
        <td>{{ $coupon->code }}</td>
        <td>{{ ucfirst($coupon->type) }}</td>
        <td>{{ number_format((float)$coupon->value, 2) }}</td>
        <td>{{ number_format((float)$coupon->cart_min_value, 2) }}</td>
        <td>{{ \Illuminate\Support\Carbon::parse($coupon->expiry_date)->format('Y-m-d') }}</td>

        {{-- Single Action cell --}}
        <td>
            <div class="list-icon-function d-flex gap-2 justify-content-center">
                <a href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}" class="item edit" title="Edit">
                    <i class="icon-edit-3"></i>
                </a>

                <form action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}"
                      method="POST" onsubmit="return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="item text-danger delete" title="Delete" style="background:none; border:none;">
                        <i class="icon-trash-2"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No coupons found.</td>
    </tr>
@endforelse
</tbody>

                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $coupons->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).on('click', '.delete', function (e) {
    e.preventDefault();
    const $form = $(this).closest('form');
    if (typeof Swal === 'undefined') { return $form.off('submit').submit(); }

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel'
    }).then((r) => { if (r.isConfirmed) $form.off('submit').submit(); });
});
</script>
@endpush
