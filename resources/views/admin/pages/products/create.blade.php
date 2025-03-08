@extends('admin.layout.master')

@push('meta-title')
    Create Product
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("customer", 'mm-active')


@section('body-content')

    <!--breadcrumb-->
        @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Create Products'])
    <!--end breadcrumb-->


    <!-- Content part Start -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                {{-- <h4 class="card-title">Products List</h4> --}}
                <h4 class="card-title">Create Products</h4>
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary"> Back</a>
            </div>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
    
                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex gap-3 align-items-end">
                            <div id="image_preview">
                                <img src="{{ asset('admin/assets/images/no_Image_available.jpg') }}" width="100" height="100">
                            </div>
    
                            <div class="">
                                <label for="thumb_image" class="form-label">Product Image <sup class="text-danger" style="font-size: 12px;">* resolution (600px x 800px)</sup></label>
                                <input type="file" class="form-control" name="thumb_image" id="thumb_image" accept=".png, .jpeg, .jpg, .webp" onchange="previewImage(event)">
                            </div>
                        </div>
    
                        <span id="image_validate" class="text-danger mt-2">
                            @error('thumb_image'){{ $message }}@enderror
                        </span>
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input class="form-control" id="name" type="text" name="name" placeholder="Write product name...." value="{{ old('name') }}">
    
                        <span id="name_validate" class="text-danger mt-2">
                            @error('name'){{ $message }}@enderror
                        </span>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                        <select class="form-select category_id" id="category_id" name="category_id">
                            <option value="" disabled selected>Select</option>
    
                            @foreach ($categories as $row)
                                 <option value="{{ $row->id }}" 
                                    data-image-url="{{ asset($row->img) }}"
                                    {{ old('category_id', $product->category_id ?? '') == $row->id ? 'selected' : '' }}
                                    >{{ $row->name }}</option>
                            @endforeach
                        </select>
    
                        <span id="category_id_validate" class="text-danger mt-2">
                            @error('category_id'){{ $message }}@enderror
                        </span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="subCategory_id">SubCategory</label>
                        <select class="form-select subCategory_id" id="subCategory_id" name="subCategory_id">
                            <option value="" disabled selected>Select</option>
                            @foreach ($subCategories as $row)
                                <option value="{{ $row->id }}" 
                                    data-image-url="{{ asset($row->subcategory_img) }}"
                                    {{ old('subCategory_id', $product->subCategory_id ?? '') == $row->id ? 'selected' : '' }}
                                    >{{ $row->subcategory_name }}</option>
                            @endforeach
                        </select>

                        <span id="subCategory_id_validate" class="text-danger mt-2">
                            @error('subCategory_id'){{ $message }}@enderror
                        </span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="brand_id">Brand <span class="text-danger">*</span></label>
                        <select class="form-select" id="brand_id" name="brand_id">
                            <option value="" disabled selected>Select</option>
    
                            @foreach ($brands as $row)
                                <option value="{{ $row->id }}" 
                                    data-image-url="{{ asset($row->image) }}"
                                    {{ old('brand_id', $product->brand_id ?? '') == $row->id ? 'selected' : '' }}
                                    >{{ $row->brand_name }}</option>
                            @endforeach
                        </select>

                        <span id="brand_id_validate" class="text-danger mt-2">
                            @error('brand_id'){{ $message }}@enderror
                        </span>
                    </div>
                </div>
    
                <div class="row">    
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="purchase_price">Purchase Price <span class="text-danger">*</span></label>
                        <input class="form-control" id="purchase_price" type="number" name="purchase_price" min="0" value="{{ old('purchase_price') }}" placeholder="Purchase Price....">
    
                        <span id="purchase_price_validate" class="text-danger mt-2">
                            @error('purchase_price'){{ $message }}@enderror
                        </span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="selling_price">Selling Price <span class="text-danger">*</span></label>
                        <input class="form-control" id="selling_price" type="number" name="selling_price" min="0" value="{{ old('selling_price') }}" placeholder="Selling Price....">

                        <span id="selling_price_validate" class="text-danger mt-2">
                            @error('selling_price'){{ $message }}@enderror
                        </span>
                    </div>

                    @php
                        $sku = time() . rand(1000, 99999);
                    @endphp
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label">Product Sku <span class="text-danger">*</span></label>
                        <input class="form-control" id="sku" type="text" name="sku" readonly placeholder="Write product sku...." value="{{ $sku }}">

                        <span id="name_validate" class="text-danger mt-2">
                            @error('sku'){{ $message }}@enderror
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="qty">Stock Quantity <span class="text-danger">*</span></label>
                        <input class="form-control" min="0" id="qty" type="number" name="qty" placeholder="Product Quantity...." value="{{ old('qty') }}">
    
                        <span id="quantity_validate" class="text-danger mt-2">
                            @error('qty'){{ $message }}@enderror
                        </span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="units">Units  <span class="text-danger">*</span></label>
                        <select class="form-select" id="units" name="units">
                            @foreach ($units as $row)
                                <option value="{{ $row->short_name }}"  {{ old('units') ==  $row->short_name ? 'selected' : '' }}>{{ $row->short_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="long_description">Long Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="long_description" name="long_description" rows="8" placeholder="Long Description....">{{ old('long_description') }}</textarea>
                    </div>
    
                    <span id="long_validate" class="text-danger mt-1">
                        @error('long_description'){{ $message }}@enderror
                    </span>
                </div>
    
                <div class="d-flex justify-content-center align-items-center mt-5">
                    <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div>
    </div>


@endsection


@push('add-js')
    {{-- data.setData(res.data.schedules_desc); --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('image_preview').innerHTML = `
                <img src="${e.target.result}" width="100" height="100">`;
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function () {
            // Ckeditor 5 plugin
            let jReq;
            ClassicEditor
                .create(document.querySelector('#long_description'))
                .then(newEditor => {
                    jReq = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });


            //____ category_id Select2 ____//
            $('#category_id').select2({
                templateResult: formatState,       
                templateSelection: formatState, 
            });

            //____ subCategory_id Select2 ____//
            $('#subCategory_id').select2({
                templateResult: formatState,
                templateSelection: formatState,
            });

            //____ childCategory_id Select2 ____//
            $('#brand_id').select2({
                // dropdownParent: $('#createModal'),
                templateResult: formatState,
                templateSelection: formatState,
            });

            function formatState (state) {
                if (!state.id) {
                    return state.text; // Return text for disabled option
                }

                var imageUrl = $(state.element).data('image-url'); // Access image URL from data attribute

                if (!imageUrl) {
                    return state.text; // Return text if no image URL is available
                }

                var $state = $(
                    '<span><img src="' + imageUrl + '" style="width: 35px; height: 30px; margin-right: 8px;" /> ' + state.text + '</span>'
                );
                return $state;
            };

    });
    </script>
@endpush