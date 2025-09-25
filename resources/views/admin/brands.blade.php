@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="margin-top: 50px;">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2 gap-md-3 mb-4">
        <h3 class="fw-bold text-dark mb-0">Brands</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Brands</li>
            </ol>
        </nav>
    </div>

    {{-- Card Box --}}
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">

            {{-- Search & Add --}}
            <div class="row g-2 g-md-3 align-items-stretch mb-3">
                <div class="col-12 col-md-8 col-lg-6">
                    <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search brand..."
                                name="name"
                                value="">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-search"></i><span class="d-none d-sm-inline ms-2">Search</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-auto ms-md-auto">
                    <a href="{{ route('admin.brand.add') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus-circle me-2"></i> <span>Add New</span>
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-nowrap">#</th>
                            <th class="text-start">Brand</th>
                            <th class="d-none d-sm-table-cell">Slug</th>
                            <th class="d-none d-md-table-cell">Products</th>
                            <th class="text-center text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr>
                                <td class="text-nowrap">{{ $brand->id }}</td>

                                <td class="text-start">
                                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                                        <img
                                            src="{{ asset('uploads/brands/' . $brand->image) }}"
                                            class="rounded-circle flex-shrink-0"
                                            alt="Brand"
                                            width="44" height="44"
                                            style="object-fit: cover;">
                                        <div class="text-start">
                                            <div class="fw-semibold text-truncate" style="max-width: 220px;">
                                                {{ $brand->name }}
                                            </div>
                                            {{-- Show slug under name on xs for better density --}}
                                            <div class="text-muted small d-sm-none text-truncate" style="max-width: 220px;">
                                                {{ $brand->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="d-none d-sm-table-cell text-truncate" style="max-width: 220px;">
                                    {{ $brand->slug }}
                                </td>

                                <td class="d-none d-md-table-cell">
                                    <span class="badge bg-info text-dark px-3 py-2">
                                        {{ $brand->products()->count() }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{-- On small screens, use a compact dropdown; on md+ show buttons --}}
                                    <div class="d-inline d-md-none dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.brand.delete', ['brand' => $brand->id]) }}" method="POST" class="delete-form m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash3 me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="d-none d-md-inline-flex">
                                        <a href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}"
                                           class="btn btn-sm btn-warning me-2" title="Edit Brand">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.brand.delete', ['brand' => $brand->id]) }}"
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Brand">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No brands found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- (Optional) Pagination slot --}}
            {{-- <div class="d-flex justify-content-end mt-3">
                {{ $brands->withQueryString()->links() }}
            </div> --}}

        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert for delete confirmation
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
@endsection
