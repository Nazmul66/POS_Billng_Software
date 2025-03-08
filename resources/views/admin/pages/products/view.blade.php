@extends('admin.layout.master')

@push('meta-title')
    View Product
@endpush

@push('add-css')

@endpush

{{-- Active Menu Sidebar --}}
@section("customer", 'mm-active')


@section('body-content')

    <!--breadcrumb-->
        @include('admin.include.breadcrumb', ['breadcrumb_name' => 'View Products'])
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-header">
            <div class="header_navbar">
                <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-main-tab" data-bs-toggle="pill" data-bs-target="#pills-main" type="button" role="tab" aria-controls="pills-main" aria-selected="true">Main Info</button>
                    </li>

                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-long-description-tab" data-bs-toggle="pill" data-bs-target="#pills-long-description" type="button" role="tab" aria-controls="pills-long-description" aria-selected="false">Long Description</button>
                    </li>

                  </ul>

                <a href="{{ route('admin.product.index') }}" class="btn btn-primary">
                   Back
                </a>
            </div>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        {{-- Main Product List --}}
        <div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab" tabindex="0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product Info</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Element Name</th>
                                            <th style="width: 60%">Element Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Slug</td>
                                            <td>{{ $product->slug }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Category Name</td>
                                            <td>{{ $product->cat_name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>SubCategory Name</td>
                                            <td>{{ $product->subCat_name }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Brand Name</td>
                                            <td>
                                                <span class="text-dark">{{ $product->brand_name }}</span>
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                @if ( $product->status == 1)
                                                    <button class="btn btn-success">Active</button>
                                                @else
                                                    <button class="btn btn-danger">Inactive</button>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Created Date</td>
                                            <td>{{ date('d M, Y', strtotime($product->created_at)) }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Updated Date</td>
                                            <td>{{ date('d M, Y', strtotime($product->updated_at)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product QRCode</h4>
                            <div class="product_qrcode">
                                <span>{!! DNS2D::getBarcodeHTML($product->barcode, 'QRCODE') !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-6">
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Thumnail Image</h4>
                            <div class="product_image">
                                <a href="{{ asset($product->thumb_image) }}" target="_blank">
                                    <img src="{{ asset($product->thumb_image) }}" alt="" >
                                </a>
                            </div>
                        </div>
                    </div>      
        
                    <div class="card cards">
                        <div class="card-body">
                            <h4 class="mb-3">Product Management</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Element Name</th>
                                            <th style="width: 60%">Element Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Barcode</td>
                                            <td>
                                                <span>{!! DNS1D::getBarcodeHTML($product->barcode, 'EAN13', 2, 50, 'black', true) !!}</span>
                                                <p>Code: {{ $product->barcode }}</p>
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td>SKU</td>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Quantity</td>
                                            <td>{{ $product->qty }}</td>
                                        </tr>
        
                                        <tr>
                                            <td>Purchase Price</td>
                                            <td>{{ $product->price }} TK</td>
                                        </tr>
        
                                        <tr>
                                            <td>Selling Price</td>
                                            <td>{{ $product->offer_price }} Tk</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-long-description" role="tabpanel" aria-labelledby="pills-long-description-tab" tabindex="0">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="multi_description">
                            {!! $product->long_description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div>


@endsection


@push('add-script')


@endpush