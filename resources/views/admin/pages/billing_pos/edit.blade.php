@extends('admin.layout.master')

@push('canonical')
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('meta-title')
    Edit Vehicle Report
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.css') }}">
@endpush

{{-- Active Menu Sidebar --}}
@section("invoice", 'mm-active')
@section("invoice_show", 'mm-show')
@section("vehicle_report", 'mm-active')


@section('body-content')


<!--breadcrumb-->
    @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Edit Vehicle Report'])
<!--end breadcrumb-->


<div class="card">
    <div class="card-body p-5">

       <form action="{{ route('admin.vehicle-report-invoice-update', $vehicles_report->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="invoice__logo mb-20">
                        <img src="{{ asset('admin/assets/images/logo-icon.png') }}" alt="logo icon" style="width: 50px; height: 50px; margin-bottom: 20px;">
                    </div>
                    <p class="mb-1 company_details">Miami 33315, United States</p>
                    <p class="mb-1 company_details">name@manez.com</p>
                    <p class="mb-1 company_details">+1(800) 642 7676</p>
                </div>

                <div class="col-md-5">
                    @php
                        $inv = "INV-" . rand(10000000, 99999999);
                    @endphp
                    <div class="row align-items-center mb-2">
                        <div class="col-lg-4">
                            <div class="form__input-title">
                                <label for="invoiceNumber">Invoice No :</label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form__input">
                                <input id="invoiceNumber" type="text" class="form-control" value="{{ $vehicles_report->invoice_number }}" placeholder="#MZ-00114" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-4">
                            <div class="form__input-title">
                                <label for="basicInput">Time In :</label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form__input">
                                <input class="form-control" id="basicInput" name="time_in" type="text" placeholder="Select Date" value="{{ $vehicles_report->time_in }}">
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-4">
                            <div class="form__input-title">
                                <label for="basicInput2">Time Out :</label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form__input">
                                <input class="form-control" type="text" name="time_out" id="basicInput2" placeholder="Select Date" value="{{ $vehicles_report->time_out }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-line"></div>

            <div class="row g-60 gy-20">
                <div class="col-xl-6">
                    <div class="mb-15">
                        <h5 class="card__heading-title">Customer Details</h5>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggName" class="m-0">Customer Name: :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="customer_name" id="shippinggName" value="{{ $vehicles_report->customer_name }}" placeholder="Customer Name:" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Address :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" value="{{ $vehicles_report->address }}" name="address" id="register" placeholder="Address" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Contact Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="contact_number" id="Chassis" placeholder="Contact Number" value="{{ $vehicles_report->contact_number }}" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engineer Name :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="engineer_name" id="shippinggNumber" value="{{ $vehicles_report->engineer_name }}" placeholder="Engineer Name" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-10">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Mechanic" class="m-0">Mechanic Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="mechanic_name" id="Mechanic" placeholder="Mechanic Name" value="{{ $vehicles_report->mechanic_name }}" required="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="mb-15">
                        <h5 class="card__heading-title">Car Details</h5>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggName" class="m-0">Car Name :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" value="{{ $vehicles_report->car_name }}" name="car_name" id="shippinggName" placeholder="Car Name" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Registration Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="register" placeholder="Registration Number" value="{{ $vehicles_report->registration_number }}" name="registration_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Chassis Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Chassis" placeholder="Chassis Number" name="chassis_number" value="{{ $vehicles_report->chassis_number }}" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engine Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="shippinggNumber" placeholder="Engine Number" value="{{ $vehicles_report->engine_number }}" name="engine_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-10">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Color" class="m-0">Color</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="color" id="Color" placeholder="Color" value="{{ $vehicles_report->color }}" required="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="mt-5">
                        <label class="form-label" for="customer_experience">Customer Experience <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="customer_experience" name="customer_experience" rows="8" placeholder="Customer Experience....">{!! $vehicles_report->customer_experience !!}</textarea>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="mt-4">
                        <label class="form-label" for="test_drive_experience">Test Drive Experience <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="test_drive_experience" name="test_drive_experience" rows="8" placeholder="Test Drive Experience....">{!! $vehicles_report->test_drive_experience !!}</textarea>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="mt-4">
                        <label class="form-label" for="additional_part">Additional Part <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="additional_part" name="additional_part" rows="8" placeholder="Additional Part....">{!! $vehicles_report->additional_part !!}</textarea>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="mt-4">
                        <label class="form-label" for="Remarks">Remarks</label>
                        <input type="text" class="form-control" value="{{ $vehicles_report->remarks }}" name="remarks" id="Remarks" placeholder="Remarks" >
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center mt-5">
                <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
       </form>
    </div>
</div>

@endsection

@push('add-js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <script>
            $("#basicInput").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",  // 'K' adds AM/PM
            });

            $("#basicInput2").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",  // 'K' adds AM/PM
            });

        $(document).ready(function(){
            let jReq;
            ClassicEditor
                .create(document.querySelector('#customer_experience'))
                .then(newEditor => {
                    jReq = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });


            let jReqa;
            ClassicEditor
                .create(document.querySelector('#test_drive_experience'))
                .then(newEditor => {
                    jReqa = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });


            let jReqs;
            ClassicEditor
                .create(document.querySelector('#additional_part'))
                .then(newEditor => {
                    jReqs = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush