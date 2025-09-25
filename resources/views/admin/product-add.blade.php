@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0 px-md-2">
  {{-- Page heading + breadcrumbs --}}
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 mt-2">
    <div>
      <h3 class="mb-0 fw-bold">Add Product</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-0">
          <li class="breadcrumb-item">
            <a href="{{ route('admin.index') }}" class="text-decoration-none">
              <i class="bi bi-speedometer2 me-1"></i>Dashboard
            </a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('admin.products') }}" class="text-decoration-none">Products</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Add Product</li>
        </ol>
      </nav>
    </div>

    <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
      <i class="bi bi-card-list me-1"></i> All Products
    </a>
  </div>

  {{-- Status / flash --}}
  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Global validation summary --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Please fix the following errors:</strong>
      <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form
    class="needs-validation"
    novalidate
    method="POST"
    enctype="multipart/form-data"
    action="{{ route('admin.product.store') }}"
  >
    @csrf

    <div class="row g-3">
      {{-- Left column: main details --}}
      <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body p-3 p-md-4">

            {{-- Name / Slug --}}
            <div class="row g-3">
              <div class="col-12 col-md-7">
                <div class="form-floating">
                  <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    placeholder="Product name"
                    maxlength="100"
                    value="{{ old('name') }}"
                    required
                  >
                  <label for="name">Product name *</label>
                  <div class="form-text">Keep it under 100 chars.</div>
                  @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="form-floating">
                  <input
                    type="text"
                    class="form-control @error('slug') is-invalid @enderror"
                    id="slug"
                    name="slug"
                    placeholder="product-slug"
                    maxlength="110"
                    value="{{ old('slug') }}"
                  >
                  <label for="slug">Slug (optional)</label>
                  <div class="form-text">Auto-filled from name; edit if needed.</div>
                  @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            {{-- Category / Brand --}}
            <div class="row g-3 mt-1">
              <div class="col-12 col-md-6">
                <label for="category_id" class="form-label">Category *</label>
                <select
                  id="category_id"
                  name="category_id"
                  class="form-select @error('category_id') is-invalid @enderror"
                  required
                >
                  <option value="">Choose category</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 col-md-6">
                <label for="brand_id" class="form-label">Brand *</label>
                <select
                  id="brand_id"
                  name="brand_id"
                  class="form-select @error('brand_id') is-invalid @enderror"
                  required
                >
                  <option value="">Choose brand</option>
                  @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                      {{ $brand->name }}
                    </option>
                  @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Short Description --}}
            <div class="mt-3">
              <label for="short_description" class="form-label">Short Description *</label>
              <textarea
                class="form-control @error('short_description') is-invalid @enderror"
                id="short_description"
                name="short_description"
                rows="3"
                maxlength="255"
                required
              >{{ old('short_description') }}</textarea>
              <div class="form-text">Summary, max 255 chars.</div>
              @error('short_description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div class="mt-3">
              <label for="description" class="form-label">Description *</label>
              <textarea
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                name="description"
                rows="6"
                required
              >{{ old('description') }}</textarea>
              @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

          </div>
        </div>
      </div>

      {{-- Right column: media & pricing & inventory --}}
      <div class="col-12 col-lg-4">
        {{-- Images --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body p-3 p-md-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-image me-2"></i>Images</h6>

            <label class="form-label">Main Image *</label>
            <div class="border rounded p-3 text-center mb-2">
              <input
                class="form-control @error('image') is-invalid @enderror"
                type="file"
                id="image"
                name="image"
                accept="image/*"
                required
              >
              @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

              <div id="mainPreview" class="mt-3 d-none">
                <img src="#" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 220px;">
              </div>
            </div>

            <label class="form-label">Gallery Images</label>
            <div class="border rounded p-3">
              <input
                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                type="file"
                id="images"
                name="images[]"
                accept="image/*"
                multiple
              >
              @error('images') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

              <div id="galleryPreview" class="row g-2 mt-2"></div>
            </div>
          </div>
        </div>

        {{-- Pricing --}}
        <div class="card shadow-sm mb-3">
          <div class="card-body p-3 p-md-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-cash-coin me-2"></i>Pricing</h6>

            <div class="row g-3">
              <div class="col-12">
                <div class="form-floating">
                  <input
                    type="number"
                    step="0.01"
                    min="0"
                    class="form-control @error('regular_price') is-invalid @enderror"
                    id="regular_price"
                    name="regular_price"
                    placeholder="0.00"
                    value="{{ old('regular_price') }}"
                    required
                  >
                  <label for="regular_price">Regular Price *</label>
                  @error('regular_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <input
                    type="number"
                    step="0.01"
                    min="0"
                    class="form-control @error('sale_price') is-invalid @enderror"
                    id="sale_price"
                    name="sale_price"
                    placeholder="0.00"
                    value="{{ old('sale_price') }}"
                  >
                  <label for="sale_price">Sale Price (optional)</label>
                  @error('sale_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Inventory --}}
        <div class="card shadow-sm">
          <div class="card-body p-3 p-md-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-box-seam me-2"></i>Inventory</h6>

            <div class="mb-3">
              <div class="form-floating">
                <input
                  type="text"
                  class="form-control @error('SKU') is-invalid @enderror"
                  id="SKU"
                  name="SKU"
                  placeholder="SKU"
                  value="{{ old('SKU') }}"
                  required
                >
                <label for="SKU">SKU *</label>
                @error('SKU') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>

            <div class="row g-3">
              <div class="col-12">
                <div class="form-floating">
                  <input
                    type="number"
                    min="0"
                    class="form-control @error('quantity') is-invalid @enderror"
                    id="quantity"
                    name="quantity"
                    placeholder="0"
                    value="{{ old('quantity') }}"
                    required
                  >
                  <label for="quantity">Quantity *</label>
                  @error('quantity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="col-12">
                <label for="stock_status" class="form-label">Stock Status *</label>
                <select
                  class="form-select @error('stock_status') is-invalid @enderror"
                  id="stock_status"
                  name="stock_status"
                  required
                >
                  <option value="instock" @selected(old('stock_status','instock')=='instock')>In stock</option>
                  <option value="outofstock" @selected(old('stock_status')=='outofstock')>Out of stock</option>
                </select>
                @error('stock_status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <label for="featured" class="form-label">Featured *</label>
                <select
                  class="form-select @error('featured') is-invalid @enderror"
                  id="featured"
                  name="featured"
                  required
                >
                  <option value="0" @selected(old('featured','0')=='0')>No</option>
                  <option value="1" @selected(old('featured')=='1')>Yes</option>
                </select>
                @error('featured') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Full-width actions --}}
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-body p-3 p-md-4 d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.products') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-plus-circle me-1"></i> Add Product
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  // Bootstrap client-side required highlighting (optional)
  (function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) { event.preventDefault(); event.stopPropagation(); }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  // Auto-generate slug from name (once user leaves name field)
  const nameInput = document.getElementById('name');
  const slugInput = document.getElementById('slug');
  function toSlug(str){
    return str
      .toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g,'') // remove accents
      .replace(/[^a-z0-9\s-]/g,'')  // remove invalid chars
      .trim()
      .replace(/\s+/g,'-')
      .replace(/-+/g,'-');
  }
  nameInput?.addEventListener('change', () => {
    if (!slugInput.value.trim()) slugInput.value = toSlug(nameInput.value);
  });

  // Main image preview
  const mainInput = document.getElementById('image');
  const mainPreviewWrap = document.getElementById('mainPreview');
  const mainPreviewImg = mainPreviewWrap?.querySelector('img');
  mainInput?.addEventListener('change', (e) => {
    const [file] = e.target.files || [];
    if (file) {
      mainPreviewImg.src = URL.createObjectURL(file);
      mainPreviewWrap.classList.remove('d-none');
    } else {
      mainPreviewWrap.classList.add('d-none');
      mainPreviewImg.src = '#';
    }
  });

  // Gallery preview
  const galleryInput = document.getElementById('images');
  const galleryPreview = document.getElementById('galleryPreview');
  galleryInput?.addEventListener('change', (e) => {
    galleryPreview.innerHTML = '';
    const files = Array.from(e.target.files || []);
    files.forEach(file => {
      const col = document.createElement('div');
      col.className = 'col-4';
      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.className = 'img-fluid rounded shadow-sm';
      img.style.maxHeight = '110px';
      img.alt = 'Gallery preview';
      col.appendChild(img);
      galleryPreview.appendChild(col);
    });
  });
</script>
@endpush
