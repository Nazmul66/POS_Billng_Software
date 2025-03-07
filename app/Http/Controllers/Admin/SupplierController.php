<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Supplier;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class SupplierController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.supplier.index');
    }

    public function getData()
    {
        // get all data
        $suppliers = Supplier::all();

        return DataTables::of($suppliers)
            ->addIndexColumn()
            ->addColumn('supplier_name', function ($supplier) {
                return $supplier->first_name . $supplier->last_name;
            })
            ->addColumn('supplier_phone', function ($supplier) {
                return ' <a href="tel: '. $supplier->phone .'" class="text-success" target="_blank">'. $supplier->phone .'</a>';
            })
            ->addColumn('status', function ($supplier) {
                if ($supplier->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)" data-id="'.$supplier->id.'" data-status="'.$supplier->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$supplier->id.'" data-status="'.$supplier->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($supplier) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$supplier->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$supplier->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$supplier->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['supplier' => $supplier]);
                return $actionHtml;
            })
            ->rawColumns(['supplier_name', 'supplier_phone', 'status', 'action'])
            ->make(true);
    }

    public function changeBillStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Supplier::findOrFail($id);
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
            $supplier = new Supplier();
            $supplier->first_name            = $request->first_name;
            $supplier->last_name             = $request->last_name;
            $supplier->email                 = $request->email;
            $supplier->phone                 = $request->phone;
            $supplier->address               = $request->address;
            $supplier->city                  = $request->city;
            $supplier->state                 = $request->state;
            $supplier->country               = $request->country;
            $supplier->postal_code           = $request->postal_code;
            $supplier->status                = $request->status;

            // Handle image with ImageUploadTraits function
            $uploadImage                     = $this->imageUpload($request, 'image', 'supplier');
            $supplier->image                 =  $uploadImage;

            $supplier->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Bill Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        // dd($supplier);
        return response()->json(['success' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $supplier  = Supplier::find($id);

        DB::beginTransaction();
        try {
            $supplier->first_name            = $request->first_name;
            $supplier->last_name             = $request->last_name;
            $supplier->email                 = $request->email;
            $supplier->phone                 = $request->phone;
            $supplier->address               = $request->address;
            $supplier->city                  = $request->city;
            $supplier->state                 = $request->state;
            $supplier->country               = $request->country;
            $supplier->postal_code           = $request->postal_code;
            $supplier->status                = $request->status;
            $supplier->updated_at                = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'supplier', $supplier->image );
            $supplier->image                  =  $uploadImages;

            $supplier->update();
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
    public function destroy(Supplier $supplier)
    {
        if ($supplier->image) {
            if (file_exists($supplier->image)) {
                unlink($supplier->image);
            }
        }
        $supplier->delete();
        return response()->json(['message' => 'Supplier has been deleted.'], 200);
    }

    public function billView($id)
    {
        $supplier  = Supplier::find($id);
        // dd($supplier);

        $full_name = $supplier->first_name . $supplier->last_name;
        $supplier_email = '<a href="mailto: '. $supplier->email .'" class="text-success" target="_blank">'. $supplier->email .'</a>';
        $supplier_phone = '<a href="tel: '. $supplier->phone .'" class="text-success" target="_blank">'. $supplier->phone .'</a>';

        $statusHtml = '';
        if ($supplier->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($supplier->created_at));
        $updated_date = date('d F, Y', strtotime($supplier->updated_at));

        return response()->json([
            'full_name'         => $full_name,
            'supplier_email'    => $supplier_email,
            'supplier_phone'    => $supplier_phone,
            'success'           => $supplier,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
