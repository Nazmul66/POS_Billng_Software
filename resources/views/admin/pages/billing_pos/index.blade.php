@extends('admin.layout.master')

@push('canonical')
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('meta-title')
    Billing Pos
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
    @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Generate Billing POS'])
<!--end breadcrumb-->


<div class="card">
    <div class="card-body p-5">

       <form action="{{ route('admin.billing-pos-invoice-post') }}" method="POST">
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
                                <input class="form-control" id="basicInput" name="time_in" type="text" placeholder="Select Time">
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
                                <input class="form-control" type="time" name="time_out" id="basicInput2" placeholder="Select Time">
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
                            <input type="text" class="form-control" name="customer_name" id="shippinggName" placeholder="Customer Name:" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Address :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="address" id="register" placeholder="Address" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Contact Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="contact_number" id="Chassis" placeholder="Contact Number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engineer Name :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="engineer_name" id="shippinggNumber" placeholder="Engineer Name" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-10">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Mechanic" class="m-0">Mechanic Name</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="mechanic_name" id="Mechanic" placeholder="Mechanic Name" required="">
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
                            <input type="text" class="form-control" name="car_name" id="shippinggName" placeholder="Car Name" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="register" class="m-0">Registration Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="register" placeholder="Registration Number" name="registration_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Chassis:" class="m-0">Chassis Number:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="Chassis" placeholder="Chassis Number" name="chassis_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="shippinggNumber" class="m-0">Engine Number :</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="shippinggNumber" placeholder="Engine Number" name="engine_number" required="">
                        </div>
                    </div>

                    <div class="row align-items-center mb-10">
                        <div class="col-lg-5">
                            <div class="form__input-title">
                                <label for="Color" class="m-0">Color</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="color" id="Color" placeholder="Color" required="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 size_field">
                    <label class="form-label mt-5 mb-2">All Products <span class="text-danger">*</span></label>

                    <div class="form__input" style="max-width: 100%; width: 50%;">
                        <select name="bulk_product" id="bulk_product">
                            <option value="" disabled selected>Please select a product</option>
                            @foreach ($products as $row)
                                <option value="{{ $row->slug }}" data-image-url="{{ asset($row->thumb_image) }}" data-slug={{ $row->slug }} data-name={{ $row->name }} data-id="{{ $row->id }}" data-qty={{ $row->qty }} data-price={{ $row->price }} data-offer_price={{ $row->offer_price ?? 0 }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <table class="table mb-0">
                            <tbody class="body_part">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xl-12 size_field">
                    <label class="form-label mt-5 mb-2">Installation Charge / Service Charge <span class="text-danger">*</span></label>

                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Unit Price ($)</th>
                                    <th>Total Price ($)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0 table_extend">
                                <tr>
                                    <td>
                                        <input type="text" class="form-control service_name"  name="service_name[]" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control unit_price"   name="unit_price[]" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control total_price"  name="total_price[]" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <script>
        $(document).ready(function(){

            $(document).on("input", ".unit_price", function() {
                var unitPrice = $(this).val();
                console.log(unitPrice);
                var totalPriceInput = $(this).closest('tr').find('.total_price');

                if (unitPrice) {
                    totalPriceInput.val(unitPrice); // Set total_price to the same value as unit_price
                } else {
                    totalPriceInput.val(''); // Clear total_price if unit_price is empty
                }
            });

            // add new input rows
            $(document).on("click", ".btn-info", function(){
                $('.table_extend').append(`
                    <tr>
                        <td>
                            <input type="text" class="form-control service_name" name="service_name[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control unit_price" name="unit_price[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control total_price" name="total_price[]" readonly>
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

            // Multiple Product selection
            $('#bulk_product').select2({
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

            // When a new product is selected
            $('#bulk_product').on('select2:select', function (e) {
                const selectedValue = e.params.data.id; 
                const selectedOption = $(e.params.data.element); 
                const productId = selectedOption.data('id'); 
                const productQty = selectedOption.data('qty'); 
                const productName = selectedOption.data('name'); 
                const productSlug = selectedOption.data('slug'); 
                const product_offer_price = selectedOption.data('offer_price') || 0; 
                const productImage = selectedOption.data('image-url'); // Get the product image URL

                // Disable the option in the dropdown
                selectedOption.prop('disabled', true);
                    $('#bulk_product').select2({   // Reinitialize Select2 to reflect the changes
                        templateResult: formatState,
                        templateSelection: formatState,
                    });

                    // Format options in Select2
                    function formatState(state) {
                        if (!state.id) {
                            return state.text;
                        }
                        const imageUrl = $(state.element).data('image-url');
                        if (!imageUrl) {
                            return state.text;
                        }
                        return $(`
                            <span>
                                <img src="${imageUrl}" style="width: 35px; height: 30px; margin-right: 8px;" /> 
                                ${state.text}
                            </span>
                        `);
                    }

                // Append the selected product to the table
                $('.body_part').append(`
                    <tr data-id="${selectedValue}">
                        <input type="hidden" value="${productId}" name="product_id[]">
                        <input type="hidden" value="${productSlug}" name="productSlug[]" class="productSlug">
                        
                        <td>
                            <input type="text" class="form-control product_name" name="product_name[]" value="${productName}" required readonly>
                        </td>
                        <td>
                            <input type="number" min="1" value="1" class="form-control prdt_qty" name="prdt_qty[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control prdt_price" name="prdt_price[]" value="${product_offer_price}" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control totals" value="${product_offer_price * 1}" name="totals[]" readonly>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="text-danger remove-product" style="font-size: 26px; line-height: 24px;">
                                <i class='bx bx-x'></i>
                            </a>
                        </td>
                    </tr>
                `);

                $(document).on("input", ".prdt_qty", function () {
                    var qty = $(this).val(); // Get the entered value

                    if (qty === "" || qty <= 0) {
                        $(this).val(1); // Reset to 1 if empty, zero, or negative
                        toastr.error("Quantity must be at least 1!");
                    }
                });

                $(document).on("input", ".prdt_qty", function () {
                    var qty = $(this).val(); // Get the entered quantity
                    var price = $(this).closest("tr").find(".prdt_price").val(); // Get the product price
                    var totalField = $(this).closest("tr").find(".totals"); // Find the totals field

                    // Calculate total price
                    var total = (qty && price) ? (qty * price) : 0;

                    // Update total field
                    totalField.val(total);
                });


            // Handle removal of a product from the table
            $(document).on('click', '.remove-product', function () {
                var row = $(this).closest('tr'); 
                var productSlug = row.find(".productSlug").val(); // Get the slug from hidden input

                // Enable the removed option in the dropdown
                $("#bulk_product option[value='" + productSlug + "']").prop("disabled", false);

                // Reset the dropdown selection
                $('#bulk_product').val(null).trigger('change');  

                // Reinitialize Select2 to reflect the changes
                $('#bulk_product').select2({
                    templateResult: formatState,
                    templateSelection: formatState,
                });

                row.remove();
                toastr.success('Product removed successfully!');
            });

        });

    });
    </script>
@endpush