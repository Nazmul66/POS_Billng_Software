@extends('admin.layout.master')

@push('meta-title')
    Dashboard Layout
@endpush

@push('add-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css">
@endpush

{{-- Active Menu Sidebar --}}
@section("dashboard", 'mm-active')


@section('body-content')
    

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-10 bg-gradient-deepblue">
         <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">9526</h5>
                <div class="ms-auto">
                    <i class='bx bx-cart fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">Total Orders</p>
                <p class="mb-0 ms-auto">+4.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
            </div>
        </div>
      </div>
    </div>

    <div class="col">
        <div class="card radius-10 bg-gradient-ohhappiness">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-white">$8323</h5>
                <div class="ms-auto">
                    <i class='bx bx-dollar fs-3 text-white'></i>
                </div>
            </div>
            <div class="progress my-2 bg-white-transparent" style="height:4px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex align-items-center text-white">
                <p class="mb-0">Total Revenue</p>
                <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p>
            </div>
        </div>
      </div>
    </div>

</div><!--end row-->


<div class="card radius-10">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <h5 class="mb-0">Orders History</h5>
            </div>
        </div>

        <hr>

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