@extends('admin.layout.master')

@push('meta-title')
    All Products
@endpush

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("customer", 'mm-active')


@section('body-content')

    <!--breadcrumb-->
        @include('admin.include.breadcrumb', ['breadcrumb_name' => 'Manage Products'])
    <!--end breadcrumb-->


    <!-- Content part Start -->
    <div class="card">
        <div class="card-header p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">Products List</h4>

                <div class="">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary" >
                        <i class="bx bxs-plus-square"></i> Add New
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row px-3 pt-3">
            <div class="col-lg-3">
                <label for="">Categories</label>
                <select class="form-select submitable" name="category_id" id="category_id">
                        <option value="" selected>All</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" data-image-url="{{ asset($item->img) }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3">
                <label for="">Sub-Categories</label>
                <select class="form-select submitable" name="subCategory_id" id="subCategory_id">
                        <option value="" selected>All</option>
                    @foreach ($subCategories as $item)
                        <option value="{{ $item->id }}" data-image-url="{{ asset($item->subcategory_img) }}">{{ $item->subcategory_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3">
                <label for="">Product Quantity</label>
                <select class="form-select submitable" name="product_qty" id="product_qty">
                    <option value="" selected>All</option>
                    <option value="0-10">Quantity: 0 - 10</option>
                    <option value="11-25">Quantity: 11 - 25</option>
                    <option value="26-50">Quantity: 26 - 50</option>
                    <option value="51-100">Quantity: 51 - 100</option>
                    <option value="101-250">Quantity: 101 - 250</option>
                </select>
            </div>

            <div class="col-lg-3">
                <label for="">Product Price</label>
                <select class="form-select submitable" name="product_price" id="product_price">
                    <option value="" selected>All</option>
                    <option value="0-250">Price: $0 - $250</option>
                    <option value="251-500">Price: $251 - $500</option>
                    <option value="501-1000">Price: $501 - $1,000</option>
                    <option value="1001-2000">Price: $1,001 - $2,000</option>
                    <option value="2001-5000">Price: $2,001 - $5,000</option>
                    <option value="5001-10000">Price: $5,001 - $10,000</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="datatables">
                    <thead class="table-light">
                        <tr>
                            <th>#SL.</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Quantity</th>
                            <th>Product Categorized</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('add-js')
    {{-- data.setData(res.data.schedules_desc); --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="{{ asset('admin/assets/js/all_plugins.js') }}"></script>

    <script>
     $(document).ready(function () {

            // Show Data through Datatable
            let datatables = $('#datatables').DataTable({
                "order": [
                    [0, 'desc']
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url" : "{{ route('admin.product-data') }}",
                    "data": function(e){
                        e.category_id     = $('#category_id').val();
                        e.subCategory_id  = $('#subCategory_id').val();
                        e.product_qty     = $('#product_qty').val();
                        e.product_price   = $('#product_price').val();
                    }
                },
                // pageLength: 30,
                columns: [
                    { 
                        data: 'DT_RowIndex', 
                        name: 'DT_RowIndex', 
                        orderable: false, 
                        searchable: false 
                    },
                    {
                        data: 'product_img',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'product_details',
                    },
                    {
                        data: 'quantity',
                    },
                    {
                        data: 'categorized',
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
                    url: "{{ route('admin.product.status') }}",
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

            

            // Delete
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

                            url: "{{ url('admin/product') }}/" + id,
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
                        swal.fire('Your Data is Safe');
                    }
                })
            })
        })


        // Filterable data
        $('.submitable').on('change', function(e){
            $('#datatables').DataTable().ajax.reload();
        })

    </script>
@endpush

