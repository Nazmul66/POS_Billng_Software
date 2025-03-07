<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Unit;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class CustomerController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.customers.index');
    }

    public function getData()
    {
        // get all data
        $customers = Customer::all();

        return DataTables::of($customers)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($customer) {
                return $customer->first_name . $customer->last_name;
            })
            ->addColumn('customer_phone', function ($customer) {
                return ' <a href="tel: '. $customer->phone .'" class="text-success" target="_blank">'. $customer->phone .'</a>';
            })
            ->addColumn('status', function ($customer) {
                if ($customer->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)" data-id="'.$customer->id.'" data-status="'.$customer->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$customer->id.'" data-status="'.$customer->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($customer) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$customer->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$customer->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$customer->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['customer' => $customer]);
                return $actionHtml;
            })
            ->rawColumns(['customer_name', 'customer_phone', 'status', 'action'])
            ->make(true);
    }

    public function changeCustomerStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Customer::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->first_name            = $request->first_name;
            $customer->last_name             = $request->last_name;
            $customer->email                 = $request->email;
            $customer->phone                 = $request->phone;
            $customer->address               = $request->address;
            $customer->city                  = $request->city;
            $customer->state                 = $request->state;
            $customer->country               = $request->country;
            $customer->postal_code           = $request->postal_code;
            $customer->status                = $request->status;

            // Handle image with ImageUploadTraits function
            $uploadImage                     = $this->imageUpload($request, 'image', 'customer');
            $customer->image                 =  $uploadImage;

            $customer->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Customer Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // dd($customer);
        return response()->json(['success' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer  = Customer::find($id);

        DB::beginTransaction();
        try {
            $customer->first_name            = $request->first_name;
            $customer->last_name             = $request->last_name;
            $customer->email                 = $request->email;
            $customer->phone                 = $request->phone;
            $customer->address               = $request->address;
            $customer->city                  = $request->city;
            $customer->state                 = $request->state;
            $customer->country               = $request->country;
            $customer->postal_code           = $request->postal_code;
            $customer->status                = $request->status;
            $customer->updated_at                = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'customer', $customer->image );
            $customer->image                  =  $uploadImages;

            $customer->update();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "success"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->image) {
            if (file_exists($customer->image)) {
                unlink($customer->image);
            }
        }
        $customer->delete();
        return response()->json(['message' => 'Customer has been deleted.'], 200);
    }

    public function customerView($id)
    {
        $customer  = Customer::find($id);
        // dd($customer);

        $full_name = $customer->first_name . $customer->last_name;
        $customer_email = '<a href="mailto: '. $customer->email .'" class="text-success" target="_blank">'. $customer->email .'</a>';
        $customer_phone = '<a href="tel: '. $customer->phone .'" class="text-success" target="_blank">'. $customer->phone .'</a>';

        $statusHtml = '';
        if ($customer->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($customer->created_at));
        $updated_date = date('d F, Y', strtotime($customer->updated_at));

        return response()->json([
            'full_name'         => $full_name,
            'customer_email'    => $customer_email,
            'customer_phone'    => $customer_phone,
            'success'           => $customer,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
