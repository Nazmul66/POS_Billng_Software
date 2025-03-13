@extends('admin.layout.master')

@push('canonical')
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('meta-title')
    Edit Billing Pos
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.css') }}">
@endpush

{{-- Active Menu Sidebar --}}
@section("bill-invoice", 'mm-active')
@section("bill-invoice_show", 'mm-show')
@section("billing_pos_index", 'mm-active')


@section('body-content')


<!--breadcrumb-->
    @include('admin.include.breadcrumb', ['breadcrumb_name' => 'View Billing POS'])
<!--end breadcrumb-->


<div class="card cards">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h4 class="mb-3">Billing POS View</h4>
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
                                <td>Invoice No : </td>
                                <td>{{ $billing_pos->invoice_number }}</td>
                            </tr>

                            <tr>
                                <td>Customer Name : </td>
                                <td>{{ $billing_pos->customer_name }}</td>
                            </tr>

                            <tr>
                                <td>Address : </td>
                                <td>{{ $billing_pos->address }}</td>
                            </tr>

                            <tr>
                                <td>Contact Number : </td>
                                <td>{{ $billing_pos->contact_number }}</td>
                            </tr>

                            <tr>
                                <td>Engineer Name :</td>
                                <td>{{ $billing_pos->engineer_name }}</td>
                            </tr>

                            <tr>
                                <td>Mechanic Name :</td>
                                <td>{{ $billing_pos->mechanic_name }}</td>
                            </tr>

                            <tr>
                                <td>Car Name :</td>
                                <td>{{ $billing_pos->car_name }}</td>
                            </tr>

                            <tr>
                                <td>Registration Number :</td>
                                <td>{{ $billing_pos->registration_number }}</td>
                            </tr>

                            <tr>
                                <td>Chassis Number :</td>
                                <td>{{ $billing_pos->chassis_number }}</td>
                            </tr>

                            <tr>
                                <td>Engine Number :</td>
                                <td>{{ $billing_pos->engine_number }}</td>
                            </tr>

                            <tr>
                                <td>Color :</td>
                                <td>{{ $billing_pos->color }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @php
                    $products = $billing_pos->products ? json_decode($billing_pos->products) : [];
                    $product_total = 0;

                    foreach ($products as $val) {
                        $product_total += $val->totals;
                    }
                @endphp

                @if ( !empty($products) )
                    <h4 class="mb-3 mt-5">All Products</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Products Name</th>
                                    <th style="width: 25%">Qty</th>
                                    <th style="width: 25%">Price</th>
                                    <th style="width: 25%">Total Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $row)
                                    <tr>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->prdt_qty }}</td>
                                        <td>{{ $row->prdt_price }}</td>
                                        <td>{{ $row->totals }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @php
                    $services = $billing_pos->services ? json_decode($billing_pos->services) : [];
                    $service_total = 0;

                    foreach ($services as $val) {
                        $service_total += $val->total_price;
                    }
                @endphp

                <h4 class="mb-3 mt-5">All Services</h4>
                <div class="table-responsive">
                    <table class="table table-bordered border-primary mb-0">
                        <thead>
                            <tr>
                                <th style="width: 25%">Service Name</th>
                                <th style="width: 25%">Unit Price</th>
                                <th style="width: 25%">Total Price</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($services as $row)
                                <tr>
                                    <td>{{ $row->service_name }}</td>
                                    <td>{{ $row->unit_price }}</td>
                                    <td>{{ $row->total_price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="mt-3"><strong>SubTotal: </strong> {{ $product_total + $service_total }} TK</p>

                <div class="d-flex justify-content-center align-items-center mt-5">
                    <a href="{{ route('admin.billing-pos-invoice-pdf', $billing_pos->id) }}" id="btn-store" class="btn btn-primary waves-effect waves-light">Download Invoice</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('add-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.js') }}"></script>

@endpush