@extends('layouts.admin')
@section('content')
    <style>
    </style>

    <div class="main-content-inner" style="margin-top: 50px;">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Categories</h3>
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
                        <div class="text-tiny">All Category</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." name="name" tabindex="2"
                                    value="" aria-required="true" required>
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.category.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>

                <div class="wg-table table-all-user">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/categories/' . $category->image) }}" alt=""
                                                class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{ $category->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <a href="{{ route('admin.category.products', ['category_slug' => $category->slug]) }}"
                                            target="_blank">
                                            {{ $category->products()->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="list-icon-function">
                                            {{-- Edit button --}}
                                            <a href="{{ route('admin.category.edit', $category->id) }}" class="item edit"
                                                title="Edit">
                                                <i class="icon-edit-3"></i>
                                            </a>

                                            {{-- Delete button --}}
                                            <form action="{{ route('admin.category.delete', $category->id) }}"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="item text-danger delete"
                                                    style="border:none; background:none;" title="Delete">
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
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
