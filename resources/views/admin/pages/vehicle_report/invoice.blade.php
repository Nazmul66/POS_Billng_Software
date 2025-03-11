@extends('admin.layout.master')

@push('meta-title')
    Vehicle Invoice
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("invoice", 'mm-active')
@section("invoice_show", 'mm-show')
@section("vehicle_invoice", 'mm-active')


@section('body-content')

    <!--breadcrumb-->
        @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Manage Vehicle Report'])
    <!--end breadcrumb-->


    <!-- Content part Start -->
    <div class="card">
        <div class="card-header p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">Vehicle Invoice Report List</h4>

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
                        @foreach ($vehicles_reports as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>#{{ $row->invoice_number }}</td>
                                <td>{{ $row->customer_name }}</td>
                                <td>{{ $row->contact_number }}</td>
                                <td>{{ $row->engineer_name }}</td>
                                <td>{{ $row->mechanic_name }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" id="viewButton" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                                        
                                        <a href="{{ route('admin.vehicle-report-invoice-edit', $row->id) }}" class="ms-2"><i class="bx bx-edit"></i></a>
                
                                        <a href="{{ route('admin.vehicle-report-invoice-delete', $row->id) }}" class="ms-2"><i class="bx bx-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- View Modal -->
    <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">View Vehicle Reports List</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="view_modal_content">
                        <label>Invoice Number : </label>
                        <span class="text-dark" id="view_invoice_number"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Customer Name : </label>
                        <span class="text-dark" id="view_customer_name"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Contact Number : </label>
                        <span class="text-dark" id="view_contact_number"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Address : </label>
                        <span class="text-dark" id="view_address"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Engineer Name : </label>
                        <span class="text-dark" id="view_engineer_name"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Mechanic Name : </label>
                        <span class="text-dark" id="view_mechanic_name"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Car Name : </label>
                        <span class="text-dark" id="view_car_name"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Registration Number : </label>
                        <span class="text-dark" id="view_registration_number"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Chassis Number : </label>
                        <span class="text-dark" id="view_chassis_number"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Engine Number : </label>
                        <span class="text-dark" id="view_engine_number"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Color : </label>
                        <span class="text-dark" id="view_color"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Remarks : </label>
                        <span class="text-dark" id="view_remarks"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Created Date : </label>
                        <div id="created_date"></div>
                    </div>

                    <div class="view_modal_content">
                        <label>Updated Date : </label>
                        <div id="updated_date"></div>
                    </div>

                    <div class="view_modal_content">
                        <label>Customer Experience : </label>
                        <span class="text-dark" id="view_customer_experience"></span>
                    </div>

                    <div class="view_modal_content">
                        <label>Test Drive Experience : </label>
                        <span class="text-dark" id="view_test_drive_experience"></span>
                    </div>
                    
                    <div class="view_modal_content">
                        <label>Additional Part : </label>
                        <span class="text-dark" id="view_additional_part"></span>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
     $(document).ready(function () {
        // Show Data through Datatable
        let datatables = $('#datatables').DataTable();

        // View Data
        $(document).on("click", '#viewButton', function (e) {
            let id = $(this).attr('data-id');
            // alert(id);

            $.ajax({
                type: 'GET',
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: "{{ url('admin/vehicle-report-invoice-view') }}/" + id,
                processData: false,  // Prevent jQuery from processing the data
                contentType: false,  // Prevent jQuery from setting contentType
                success: function (res) {
                    let data = res.success;

                    $('#view_invoice_number').html('#' + data.invoice_number);
                    $('#view_customer_name').html(data.customer_name);
                    $('#view_contact_number').html(res.contact_number);
                    $('#view_address').html(data.address);
                    $('#view_engineer_name').html(data.engineer_name);
                    $('#view_mechanic_name').html(data.mechanic_name);
                    $('#view_car_name').html(data.car_name);
                    $('#view_registration_number').html(data.registration_number);
                    $('#view_chassis_number').html(data.chassis_number);
                    $('#view_engine_number').html(data.engine_number);
                    $('#view_color').html(data.color);
                    $('#view_customer_experience').html(data.customer_experience);
                    $('#view_test_drive_experience').html(data.test_drive_experience);
                    $('#view_additional_part').html(data.additional_part);
                    $('#view_remarks').html(data.remarks);
                    $('#created_date').html(data.time_in);
                    $('#updated_date').html(data.time_out);
                },
                error: function (error) {
                    console.log('error');
                }
            });
        })
     });
    </script>
@endpush

