@extends('layouts.admin')

@section('content')
<div class="w-full">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header + Breadcrumbs --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Brand Information</h3>

            <ul class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('admin.index') }}" class="hover:text-gray-700">Dashboard</a>
                </li>
                <li class="text-gray-400"><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.brands') }}" class="hover:text-gray-700">Brands</a>
                </li>
                <li class="text-gray-400"><i class="icon-chevron-right"></i></li>
                <li class="text-gray-700">New Brand</li>
            </ul>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-100">
            <form class="p-4 sm:p-6 space-y-6" action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name + Slug (stack on mobile, side-by-side from md) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <fieldset class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Brand Name <span class="text-pink-600">*</span>
                        </label>
                        <input
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                            type="text"
                            placeholder="Brand name"
                            name="name"
                            value="{{ old('name') }}"
                            aria-required="true">
                        @error('name')
                            <span class="block text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <fieldset class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Brand Slug <span class="text-pink-600">*</span>
                        </label>
                        <input
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                            type="text"
                            placeholder="brand-slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            aria-required="true">
                        @error('slug')
                            <span class="block text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </fieldset>
                </div>

                {{-- Image upload --}}
                <fieldset class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Upload Image <span class="text-pink-600">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Preview (hidden until file chosen) --}}
                        <div id="imgpreview" class="hidden">
                            <img src="{{ asset('images/upload/upload-1.png') }}"
                                 alt="Preview"
                                 class="w-full max-h-56 object-contain rounded-lg border border-gray-200">
                        </div>

                        {{-- Uploader --}}
                        <div>
                            <label for="myFile"
                                   class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-pink-400 transition">
                                <span class="text-3xl leading-none"><i class="icon-upload-cloud"></i></span>
                                <span class="text-sm text-gray-600">
                                    Drop your image here or <span class="text-pink-600 font-medium">click to browse</span>
                                </span>
                                <input type="file" id="myFile" name="image" accept="image/*" class="hidden">
                            </label>
                            @error('image')
                                <span class="block mt-2 text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.brands') }}"
                       class="inline-flex justify-center rounded-lg px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button class="inline-flex justify-center rounded-lg px-6 py-2.5 text-sm font-semibold text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500"
                            type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        // Preview image responsively
        const fileInput = document.getElementById('myFile');
        const previewWrap = document.getElementById('imgpreview');
        const previewImg  = previewWrap?.querySelector('img');

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const [file] = this.files || [];
                if (file && previewImg) {
                    previewImg.src = URL.createObjectURL(file);
                    previewWrap.classList.remove('hidden');
                }
            });
        }

        // Auto-slug from name (on change & on blur)
        const nameInp = document.querySelector("input[name='name']");
        const slugInp = document.querySelector("input[name='slug']");

        function stringToSlug(text) {
            return (text || '')
                .toString()
                .trim()
                .toLowerCase()
                // replace accented chars
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                // keep a-z0-9 and spaces/hyphens
                .replace(/[^a-z0-9\s-]/g, '')
                // collapse whitespace to single hyphen
                .replace(/\s+/g, '-')
                // collapse multiple hyphens
                .replace(/-+/g, '-')
                // trim hyphens
                .replace(/^-+|-+$/g, '');
        }

        function maybeFillSlug() {
            if (!slugInp) return;
            // Only overwrite if slug is empty or fully derived from previous name
            if (!slugInp.value || slugInp.dataset.autofill === '1') {
                slugInp.value = stringToSlug(nameInp?.value || '');
                slugInp.dataset.autofill = '1';
            }
        }

        nameInp?.addEventListener('input', maybeFillSlug);
        nameInp?.addEventListener('blur', maybeFillSlug);
        // If user edits slug manually, stop auto-filling
        slugInp?.addEventListener('input', () => slugInp.dataset.autofill = '0');
    })();
</script>
@endpush
