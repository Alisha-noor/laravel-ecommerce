@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <!-- <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a> -->
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit Category</div>
                    </li>
                </ul>
            </div>

            <!-- edit-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.category.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $category->id }}" />

                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category name" name="name"
                            value="{{ $category->name }}" required>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category Slug" name="slug"
                            value="{{ $category->slug }}" required>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title">Upload image</div>
                        <div class="upload-image flex-grow">
                            @if ($category->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('uploads/categories/' . $category->image) }}" alt=""
                                        style="max-height:100px;">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop your image here or <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <!-- /edit-category -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Image preview
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    if ($("#imgpreview img").length) {
                        $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    } else {
                        $("#imgpreview").html('<img src="' + URL.createObjectURL(file) +
                            '" style="max-height:100px;">');
                    }
                    $("#imgpreview").show();
                }
            });

            // Auto slug from name
            $("input[name='name']").on("keyup", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>
@endpush
