@extends('admin.layout.master')

@push('canonical')
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('meta-title')
    Billing Pos Invoice
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("bill-invoice", 'mm-active')
@section("bill-invoice_show", 'mm-show')
@section("billing_pos_invoice", 'mm-active')


@section('body-content')

    <!--breadcrumb-->
        @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Manage Billing POS Invoice'])
    <!--end breadcrumb-->


    <!-- Content part Start -->
    <div class="card">
        <div class="card-header p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">Billing POS Invoice List</h4>

                <div class="">
                    <a href="{{ route('admin.vehicle-report-invoice') }}" class="btn btn-primary" >
                        <i class="bx bxs-plus-square"></i> Generate Invoice
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="datatables">
                    <thead class="table-light">
                        <tr>
                            <th>#SL.</th>
                            <th>Invoice Number</th>
                            <th>Customer Name</th>
                            <th>Contact Number</th>
                            <th>Engineer Name</th>
                            <th>Mechanic Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billing_pos as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>#{{ $row->invoice_number }}</td>
                                <td>{{ $row->customer_name }}</td>
                                <td>{{ $row->contact_number }}</td>
                                <td>{{ $row->engineer_name }}</td>
                                <td>{{ $row->mechanic_name }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.billing-pos-invoice-view', $row->id) }}"><ion-icon name="eye-outline"></ion-icon></a>
                                        
                                        <a href="{{ route('admin.billing-pos-invoice-edit', $row->id) }}" class="ms-2"><i class="bx bx-edit"></i></a>
                
                                        <a href="{{ route('admin.billing-pos-invoice-delete', $row->id) }}" class="ms-2"><i class="bx bx-trash"></i></a>

                                        <a href="{{ route('admin.billing-pos-invoice-pdf', $row->id) }}" class="ms-2"><i class='bx bx-file'></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
     $(document).ready(function () {
        // Show Data through Datatable
        let datatables = $('#datatables').DataTable();

     });
    </script>
@endpush

