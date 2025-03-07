@extends('admin.layout.master')

@push('meta-title')
    Unit
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("customer", 'mm-active')


@section('body-content')

<!--breadcrumb-->
   @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Manage Customers'])
<!--end breadcrumb-->

    <!-- Content part Start -->
    <div class="card">
        <div class="card-header p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">Customers List</h4>

                <div class="">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bx bxs-plus-square"></i> Add New
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="datatables">
                    <thead class="table-light">
                        <tr>
                            <th>#SL.</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="createModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Create Customer</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="createForm" enctype="multipart/form-data">
                            @csrf

                            <div class="new-employee-field">
								<div class="profile-pic-upload">
									<div class="profile-pic" id="profile-pic">
										<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle plus-down-add"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Image</span>
									</div>
									<div class="mb-3">
										<div class="image-upload mb-0">
											<input type="file" name="image" accept=".png, .jpeg, .jpg, .webp" class="image_upload">
											<div class="image-uploads">
												<h4>Upload Image</h4>
											</div>
										</div>
										<p class="mt-2">JPEG, PNG up to 4 MB</p>
									</div>
								</div>
							</div>

                            <div class="row">
								<div class="col-lg-6 mb-3">
									<label for="first_name" class="form-label">First Name<span class="text-danger ms-1">*</span></label>
									<input type="text" name="first_name" id="first_name" class="form-control"> 

                                    <span id="first_name_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-6 mb-3">
									<label for="last_name" class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
									<input type="text" name="last_name" id="last_name" class="form-control"> 

                                    <span id="last_name_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="email" class="form-label">Email</label>
									<input type="email" class="form-control" name="email" id="email">
                                    
                                     <span id="email_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="phone" class="form-label">Phone<span class="text-danger ms-1">*</span></label>
									<input type="text" name="phone" pattern="^0\d{10}$" maxlength="11" class="form-control" id="phone"> 

                                    <span id="phone_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="address" class="form-label">Address<span class="text-danger ms-1">*</span></label>
									<input type="text" class="form-control" name="address" id="address"> 

                                    <span id="address_validate" class="text-danger validation-error mt-1"></span>
								</div>
                                
                                <div class="col-lg-6 mb-3">
									<label for="city" class="form-label">City<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="city" id="city">
                                        <option value="" selected disabled>Select</option>
                                        @foreach (config('city.cities') as $key => $row)
                                           <option value="{{ $key }}">{{ $row }}</option>
                                        @endforeach
                                    </select>

                                    <span id="city_validate" class="text-danger validation-error mt-1"></span>
								</div>
                                
								<div class="col-lg-6 mb-3">
									<label for="state" class="form-label">State<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="state" id="state">
                                        <option value="" selected disabled>Select</option>
                                        @foreach (config('state.states') as $key => $row)
                                           <option value="{{ $key }}">{{ $row }}</option>
                                        @endforeach
                                    </select>

                                    <span id="state_validate" class="text-danger validation-error mt-1"></span>
								</div>

                                <div class="col-lg-6 mb-3">
									<label for="country" class="form-label">Country<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="country" id="country">
                                        <option value="" selected disabled>Select</option>
                                        <option value="bangladesh">Bangladesh</option>
                                    </select>

                                    <span id="country_validate" class="text-danger validation-error mt-1"></span>
								</div>

                                <div class="col-lg-6 mb-3">
									<label for="postal_code" class="form-label">Postal Code<span class="text-danger ms-1">*</span></label>
									<input type="text" class="form-control" name="postal_code" id="postal_code"> 

                                    <span id="postal_code_validate" class="text-danger validation-error mt-1"></span>
								</div>
							</div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>

                                <span id="status_validate" class="text-danger mt-1"></span>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-danger waves-effect me-3"
                                        data-bs-dismiss="modal">Close
                                </button>

                                <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="EditForm" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <input type="text" name="id" id="id" hidden>

                            <div class="new-employee-field">
								<div class="profile-pic-upload">
									<div class="profile-pic" id="up-profile-pic">
										<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle plus-down-add"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Image</span>
									</div>
									<div class="mb-3">
										<div class="image-upload mb-0">
											<input type="file" name="image" accept=".png, .jpeg, .jpg, .webp" class="up_image_upload">
											<div class="image-uploads">
												<h4>Upload Image</h4>
											</div>
										</div>
										<p class="mt-2">JPEG, PNG up to 4 MB</p>
									</div>
								</div>
							</div>

                            <div class="row">
								<div class="col-lg-6 mb-3">
									<label for="up_first_name" class="form-label">First Name<span class="text-danger ms-1">*</span></label>
									<input type="text" name="first_name" id="up_first_name" class="form-control"> 

                                    <span id="up_first_name_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-6 mb-3">
									<label for="up_last_name" class="form-label">Last Name<span class="text-danger ms-1">*</span></label>
									<input type="text" name="last_name" id="up_last_name" class="form-control"> 

                                    <span id="up_last_name_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="up_email" class="form-label">Email<span class="text-danger ms-1">*</span></label>
									<input type="email" class="form-control" name="email" id="up_email">
                                    
                                     <span id="up_email_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="up_phone" class="form-label">Phone<span class="text-danger ms-1">*</span></label>
									<input type="text" name="phone" pattern="^0\d{10}$" maxlength="11" class="form-control" id="up_phone"> 

                                    <span id="up_phone_validate" class="text-danger validation-error mt-1"></span>
								</div>

								<div class="col-lg-12 mb-3">
									<label for="up_address" class="form-label">Address<span class="text-danger ms-1">*</span></label>
									<input type="text" class="form-control" name="address" id="up_address"> 

                                    <span id="up_address_validate" class="text-danger validation-error mt-1"></span>
								</div>
                                
                                <div class="col-lg-6 mb-3">
									<label for="up_city" class="form-label">City<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="city" id="up_city">
                                        <option value="">Select</option>
                                        @foreach (config('city.cities') as $key => $row)
                                           <option value="{{ $key }}">{{ $row }}</option>
                                        @endforeach
                                    </select>

                                    <span id="up_city_validate" class="text-danger validation-error mt-1"></span>
								</div>
                                
								<div class="col-lg-6 mb-3">
									<label for="up_state" class="form-label">State<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="state" id="up_state">
                                        <option value="">Select</option>
                                        @foreach (config('state.states') as $key => $row)
                                           <option value="{{ $key }}">{{ $row }}</option>
                                        @endforeach
                                    </select>

                                    <span id="up_state_validate" class="text-danger validation-error mt-1"></span>
								</div>

                                <div class="col-lg-6 mb-3">
									<label for="up_country" class="form-label">Country<span class="text-danger ms-1">*</span></label>
									<select class="form-select" name="country" id="up_country">
                                        <option value="" selected disabled>Select</option>
                                        <option value="bangladesh">Bangladesh</option>
                                    </select>

                                    <span id="up_country_validate" class="text-danger validation-error mt-1"></span>
								</div>

                                <div class="col-lg-6 mb-3">
									<label for="up_postal_code" class="form-label">Postal Code<span class="text-danger ms-1">*</span></label>
									<input type="text" class="form-control" name="postal_code" id="up_postal_code"> 

                                    <span id="up_postal_code_validate" class="text-danger validation-error mt-1"></span>
								</div>
							</div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="up_status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-danger waves-effect me-3"
                                        data-bs-dismiss="modal">Close
                                </button>

                                <button type="submit" id="btn-store" class="btn btn-primary waves-effect waves-light">
                                   Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        <!-- View Modal -->
        <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-scroll="true" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">View Customer List</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="view_modal_content">
                            <label>Customer Name : </label>
                            <span class="text-dark" id="view_full_name"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Image : </label>
                            <div id="viewImageShow"></div>
                        </div>

                        <div class="view_modal_content">
                            <label>Customer Email : </label>
                            <span class="text-dark" id="view_email"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Customer Phone : </label>
                            <span class="text-dark" id="view_phone"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Customer Address : </label>
                            <span class="text-dark" id="view_address"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>City : </label>
                            <span class="text-dark" id="view_city"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>State: </label>
                            <span class="text-dark" id="view_state"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Country: </label>
                            <span class="text-dark" id="view_country"></span>
                        </div>

                        <div class="view_modal_content">
                            <label>Postal Code : </label>
                            <span class="text-dark" id="view_postal_code"></span>
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
                            <label>Status : </label>
                            <div id="view_status"></div>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>

@endsection

@push('add-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>

    <script>
        $('#city').select2({
            dropdownParent: $('#createModal'),
        });

        $('#state').select2({
            dropdownParent: $('#createModal'),
        });

        $('#up_city').select2({
            dropdownParent: $('#editModal'),
        });
        
        $('#up_state').select2({
            dropdownParent: $('#editModal'),
        });

        $(document).ready(function () {
            $('.image_upload').on('change', function (event) {
                let input = event.target;
                let reader = new FileReader();

                if (input.files && input.files[0]) {
                    reader.onload = function (e) {
                        $('#profile-pic').html(`<img src="${e.target.result}" width="120" height="120">`);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });


            $('.up_image_upload').on('change', function (event) {
                let input = event.target;
                let reader = new FileReader();

                if (input.files && input.files[0]) {
                    reader.onload = function (e) {
                        $('#up-profile-pic').html(`<img src="${e.target.result}" width="120" height="120">`);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('#datatables').DataTable({
                order: [
                    [0, 'desc']
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.customer-data') }}",
                // pageLength: 30,
                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'customer_name',
                    },
                    {
                        data: 'customer_phone',
                    },
                    {
                        data: 'address',
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // status updates
            $(document).on('click', '#status', function () {
                var id = $(this).data('id');
                var status = $(this).data('status');
                // console.log(id, status);

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.customer.status') }}",
                    data: {
                        // '_token': token,
                        id: id,
                        status: status
                    },
                    success: function (res) {
                        datatables.ajax.reload();

                        if (res.status == 1) {
                            swal.fire(
                                {
                                    title: 'Status Changed to Active',
                                    icon: 'success'
                                })
                        } else {
                            swal.fire(
                                {
                                    title: 'Status Changed to Inactive',
                                    icon: 'success'
                                })
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            })

            // Create Data
            $('#createForm').submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.customer.store') }}",
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        // console.log(res);

                        if (res.status === true) {
                            $('#createModal').modal('hide');
                            $('#createForm')[0].reset();
                            $('.validation-error').html('');
                            datatables.ajax.reload();

                            swal.fire({
                                title: "Success",
                                text: `${res.message}`,
                                icon: "success"
                            })

                            // Correctly reset the image using JavaScript
                            $('#profile-pic').html(`
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle plus-down-add"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Image</span>
                            `);
                        }
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#first_name_validate').empty().html(error.first_name);
                        $('#last_name_validate').empty().html(error.last_name);
                        $('#email_validate').empty().html(error.email);
                        $('#phone_validate').empty().html(error.phone);
                        $('#address_validate').empty().html(error.address);
                        $('#city_validate').empty().html(error.city);
                        $('#state_validate').empty().html(error.state);
                        $('#country_validate').empty().html(error.country);
                        $('#postal_code_validate').empty().html(error.postal_code);
                        $('#status_validate').empty().html(error.status);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            })

            // Edit Data
            $(document).on("click", '#editButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/customers') }}/" + id + "/edit",
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#id').val(data.id);
                        $('#up_first_name').val(data.first_name);
                        $('#up_last_name').val(data.last_name);
                        $('#up-profile-pic').html('');
                        $('#up-profile-pic').append(`
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle plus-down-add"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Image</span>
                        `);
                        $('#up_email').val(data.email);
                        $('#up_phone').val(data.phone);
                        $('#up_address').val(data.address);
                        $('#up_city').val(data.city).trigger('change');
                        $('#up_state').val(data.state).trigger('change');
                        $('#up_country').val(data.country);
                        $('#up_postal_code').val(data.postal_code);
                        $('#up_status').val(data.status);
                    },
                    error: function (error) {
                        console.log('error');
                    }
                });
            })

            // Update Data
            $("#EditForm").submit(function (e) {
                e.preventDefault();
                let id = $('#id').val();
                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/customers') }}/" + id,
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        swal.fire({
                            title: "Success",
                            text: "Unit Updated Successfully",
                            icon: "success"
                        })

                        $('#editModal').modal('hide');
                        $('#EditForm')[0].reset();
                        $('.validation-error').html('');
                        datatables.ajax.reload();
                    },
                    error: function (err) {
                        let error = err.responseJSON.errors;

                        $('#up_first_name_validate').empty().html(error.first_name);
                        $('#up_last_name_validate').empty().html(error.last_name);
                        $('#up_email_validate').empty().html(error.email);
                        $('#up_phone_validate').empty().html(error.phone);
                        $('#up_address_validate').empty().html(error.address);
                        $('#up_city_validate').empty().html(error.city);
                        $('#up_state_validate').empty().html(error.state);
                        $('#up_country_validate').empty().html(error.country);
                        $('#up_postal_code_validate').empty().html(error.postal_code);
                        $('#up_status_validate').empty().html(error.status);

                        swal.fire({
                            title: "Failed",
                            text: "Something Went Wrong !",
                            icon: "error"
                        })
                    }
                });
            });


            // Delete Data
            $(document).on("click", "#deleteBtn", function () {
                let id = $(this).data('id')

                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',

                            url: "{{ url('admin/customers') }}/" + id,
                            data: {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            },
                            success: function (res) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: `${res.message}`,
                                    icon: "success"
                                });

                                datatables.ajax.reload();
                            },
                            error: function (err) {
                                console.log('error')
                            }
                        })

                    } else {
                        swal.fire('Your Image is Safe');
                    }
                })
            })


            // View Data
            $(document).on("click", '#viewButton', function (e) {
                let id = $(this).attr('data-id');
                // alert(id);

                $.ajax({
                    type: 'GET',
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: "{{ url('admin/customers/view') }}/" + id,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting contentType
                    success: function (res) {
                        let data = res.success;

                        $('#view_full_name').html(res.full_name);
                        $('#viewImageShow').html('');
                        let imageUrl = data.image ? `{{ asset("` + data.image + `") }}` : '{{ asset("admin/assets/images/dummy-image.jpg") }}';
                        $('#viewImageShow').append(`
                            <a href="${imageUrl}" target="__blank">
                                <img src="${imageUrl}" alt="Preview Image" style="width: 75px;">
                            </a>
                        `);
                        $('#view_email').html(res.customer_email);
                        $('#view_phone').html(res.customer_phone);
                        $('#view_address').html(data.address);
                        $('#view_state').html(data.state);
                        $('#view_city').html(data.city);
                        $('#view_country').html(data.country);
                        $('#view_postal_code').html(data.postal_code);
                        $('#created_date').html(res.created_date);
                        $('#updated_date').html(res.updated_date);
                        $('#view_status').html(res.statusHtml);
                    },
                    error: function (error) {
                        console.log('error');
                    }
                });
            })
        })

    </script>
@endpush