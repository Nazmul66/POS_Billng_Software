@extends('admin.layout.master')

@push('canonical')
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('meta-title')
    Vehicle Report
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
    @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Generate Vehicle Report'])
<!--end breadcrumb-->


<div class="card">
    <div class="card-body p-5">

       <form action="{{ route('admin.vehicle-report-invoice-post') }}" method="POST">
            @csrf
            
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
                                <input id="invoiceNumber" type="text" name="invoice_number" class="form-control" value="{{ $inv }}" placeholder="#MZ-00114" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row align-items-center mb-2">
                        <div class="col-lg-4">
                            <div class="form__input-title">
                                <label for="basicInput">Time In :</label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form__input">
                                <input class="form-control" id="basicInput" name="time_in" type="text" placeholder="Select Date">
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
                                <input class="form-control" type="time" name="time_out" id="basicInput2" placeholder="Select Date">
                            </div>
                        </div>
                    </div> --}}
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
                            <input type="text" class="form-control" name="customer_name" id="shippinggName" placeholder="Customer Name:" required="" value="{{ old('customer_name') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Address :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="address" id="register" placeholder="Address" required="" value="{{ old('address') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Contact Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="contact_number" id="Chassis" placeholder="Contact Number" required="" value="{{ old('contact_number') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engineer Name :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="engineer_name" id="shippinggNumber" placeholder="Engineer Name" required="" value="{{ old('engineer_name') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Mechanic" class="m-0">Mechanic Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="mechanic_name" id="Mechanic" placeholder="Mechanic Name" required="" value="{{ old('mechanic_name') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Driver" class="m-0">Driver Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="driver_name" id="Driver" placeholder="Driver Name" required="" value="{{ old('driver_name') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Reference" class="m-0">Reference Number</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="reference_number" id="Reference" placeholder="Reference Number" required="" value="{{ old('reference_number') }}">
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
                            <input type="text" class="form-control" name="car_name" id="shippinggName" placeholder="Car Name" required="" value="{{ old('car_name') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Registration Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="register" placeholder="Registration Number" name="registration_number" required="" value="{{ old('registration_number') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Chassis Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Chassis" placeholder="Chassis Number" name="chassis_number" value="{{ old('chassis_number') }}" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engine Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="shippinggNumber" placeholder="Engine Number" value="{{ old('engine_number') }}" name="engine_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Color" class="m-0">Color</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="color" value="{{ old('color') }}" id="Color" placeholder="Color" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="vehcle_model" class="m-0">Vehcle Model</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="vehicle_model" id="vehcle_model" value="{{ old('vehicle_model') }}" placeholder="Vehcle Model...." required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-10">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Mileage" class="m-0">Mileage</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="mileage" id="Mileage" placeholder="Mileage" value="{{ old('mileage') }}" required="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Customer Experience --}}
                <div class="col-xl-12">
                    <label class="form-label mt-5 mb-2">Customer Experience <span class="text-danger">*</span></label>

                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Feedback</th>
                                    <th>Feedback Answer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0 table_extend">
                                <tr>
                                    <td style="max-width: 300px;">
                                        <textarea name="customer_feedback[]" class="form-control" id="" cols="20" rows="5" required></textarea>
                                    </td>
                                    <td style="max-width: 300px;">
                                        <select class="form-control" name="customer_answer[]"  id="feedback_answer2" required>
                                            <option value="" disabled selected>Select the options</option>
                                            @foreach ($qnas as $row)
                                                <option value="{{ $row->id }}">({{ $row->id }}) {{ \Illuminate\Support\Str::words($row->answer, 10, '...') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn_customer">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Test Drive Experience --}}
                <div class="col-xl-12">
                    <label class="form-label mt-5 mb-2">Test Drive Experience <span class="text-danger">*</span></label>

                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Test Drive Feedback</th>
                                    <th>Feedback Answer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0 table_extendss">
                                <tr>
                                    <td style="max-width: 300px;">
                                        <textarea name="test_drive[]" class="form-control" id="" cols="20" rows="5" required></textarea>
                                    </td>
                                    <td style="max-width: 300px;">
                                        <select class="form-control" name="feedback_answer[]"  id="feedback_answer" required>
                                            <option value="" disabled selected>Select the options</option>
                                            @foreach ($qnas as $row)
                                                <option value="{{ $row->id }}">({{ $row->id }}) {{ \Illuminate\Support\Str::words($row->answer, 10, '...') }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn_test_drive">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Additional Part --}}
                <div class="col-xl-12">
                    <div class="mt-4">
                        <label class="form-label" for="additional_part">Additional Part <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="additional_part" name="additional_part" rows="8" placeholder="Additional Part....">{{ old('additional_part') }}</textarea>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="mt-4">
                        <label class="form-label" for="Remarks">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="Remarks" placeholder="Remarks" >
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function(){
            const qnaOptions = @json($qnas);

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

            //____ feedback_answer Select2 ____//
            $('#feedback_answer').select2();

            //____ feedback_answer2 Select2 ____//
            $('#feedback_answer2').select2();

            let jReqs;
            ClassicEditor
                .create(document.querySelector('#additional_part'))
                .then(newEditor => {
                    jReqs = newEditor;
                })
                .catch(error => {
                    console.error(error);
                });

            // add new input rows
            $(document).on("click", ".btn_customer", function(){
                let optionsHtmls = '<option value="" disabled selected>Select the options</option>';

                qnaOptions.forEach(function(qna) {
                    let shortAnswer = qna.answer.split(" ").slice(0, 10).join(" ");
                    if (qna.answer.split(" ").length > 10) {
                        shortAnswer += '...';
                    }
                    optionsHtmls += `<option value="${qna.id}">(${qna.id}) ${shortAnswer}</option>`;
                });

                $('.table_extend').prepend(`
                    <tr>
                        <td>
                            <textarea name="customer_feedback[]" class="form-control" id="" cols="20" rows="5" required></textarea>
                        </td>
                        <td>
                            <select class="form-control" name="customer_answer[]" id="feedback_answer" required>
                                ${optionsHtmls}
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">Remove</button>
                        </td>
                    </tr>
                `);
            });

            // delete all single input rows
            $(document).on("click", ".btn-danger", function(){
                $(this).closest("tr").remove();
            })


            // add new input rows
            $(document).on("click", ".btn_test_drive", function(){
                let optionsHtml = '<option value="" disabled selected>Select the options</option>';

                qnaOptions.forEach(function(qna) {
                    let shortAnswer = qna.answer.split(" ").slice(0, 10).join(" ");
                    if (qna.answer.split(" ").length > 10) {
                        shortAnswer += '...';
                    }
                    optionsHtml += `<option value="${qna.id}">(${qna.id}) ${shortAnswer}</option>`;
                });

                $('.table_extendss').prepend(`
                    <tr>
                        <td>
                            <textarea name="test_drive[]" class="form-control" id="" cols="20" rows="5" required></textarea>
                        </td>
                        <td>
                            <select class="form-control" name="feedback_answer[]" id="feedback_answer" required>
                                ${optionsHtml}
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn_remove">Remove</button>
                        </td>
                    </tr>
                `);
            });

            // delete all single input rows
            $(document).on("click", ".btn_remove", function(){
                $(this).closest("tr").remove();
            })
        })
    </script>
@endpush