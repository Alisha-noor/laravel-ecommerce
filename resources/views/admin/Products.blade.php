@extends('layouts.admin')
@section('content')
<style>
    /* --- Global layout tweaks --- */
    .main-content-inner{ margin-top:100px; }
    .wg-box .form-search input{ width:100%; min-height:42px; }
    .tf-button.w208{ min-width:180px; }

    /* --- Product name cell --- */
    .pname{
        display:flex; align-items:center; gap:12px;
        min-width:220px;
    }
    .pname .image img{
        width:54px; height:54px; object-fit:cover; border-radius:8px;
        display:block;
    }
    .pname .name .text-tiny{ color:#6b7280; }

    /* --- Action icons row --- */
    .list-icon-function{
        display:inline-flex; align-items:center; gap:8px;
        flex-wrap:wrap;
    }
    .list-icon-function .item{
        display:grid; place-items:center;
        width:36px; height:36px; border-radius:8px;
        border:1px solid #e5e7eb; background:#fff; cursor:pointer;
    }
    .list-icon-function .item:hover{ background:#f9fafb; }

    /* --- Table spacing --- */
    table.table td, table.table th{ vertical-align:middle; }

    /* --- Mobile responsiveness --- */
    @media (max-width: 991.98px){
        .main-content-inner{ margin-top:70px; }
    }
    @media (max-width: 767.98px){
        /* Stack header controls */
        .flex.items-center.justify-between.flex-wrap{ gap:10px; }
        .tf-button.w208{ width:100%; }

        /* Tighten name cell */
        .pname{ min-width:180px; }
        .pname .image img{ width:46px; height:46px; }

        /* Hide low-priority columns on phones (still accessible via horizontal scroll if needed) */
        .col-sku, .col-featured, .col-brand, .col-qty { display:none; }

        /* Make action column easier to tap */
        .list-icon-function .item{ width:40px; height:40px; }
    }

    /* Optional: shrink some headers so the first row stays compact */
    th, td{ white-space:nowrap; }
    /* Allow name to wrap */
    .pname .name a{ white-space:normal; }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Products</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow" style="min-width:260px;">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." name="name" tabindex="2" value="" required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                    <i class="icon-plus"></i> Add new
                </a>
            </div>

            <div class="table-responsive">
                @if (Session::has('status'))
                    <p class="alert alert-success">{{ Session::get('status') }}</p>
                @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th class="col-sku">SKU</th>
                            <th>Category</th>
                            <th class="col-brand">Brand</th>
                            <th class="col-featured">Featured</th>
                            <th>Stock</th>
                            <th class="col-qty">Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>

                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ asset('uploads/products/' . $product->image) }}" alt="">
                                    </div>
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{ $product->name }}</a>
                                        <div class="text-tiny mt-3">{{ $product->slug }}</div>
                                    </div>
                                </td>

                                <td>${{ $product->regular_price }}</td>
                                <td>${{ $product->sale_price }}</td>
                                <td class="col-sku">{{ $product->SKU }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="col-brand">{{ $product->brand->name ?? 'N/A' }}</td>
                                <td class="col-featured">{{ $product->featured == 0 ? 'No' : 'Yes' }}</td>
                                <td>{{ $product->stock_status }}</td>
                                <td class="col-qty">{{ $product->quantity }}</td>

                                <td>
                                    <div class="list-icon-function">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.product.edit', $product->id) }}" title="Edit">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}"
                                              method="POST" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="item text-danger" title="Delete"
                                                    style="border:none; background:none;">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
