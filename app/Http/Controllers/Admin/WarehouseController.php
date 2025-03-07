<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateWarehouseRequest;
use App\Http\Requests\Admin\UpdateWarehouseRequest;
use App\Models\Bill;
use App\Models\Warehouse;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class WarehouseController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.warehouse.index');
    }

    public function getData()
    {
        // get all data
        $warehouses = Warehouse::all();

        return DataTables::of($warehouses)
            ->addIndexColumn()
            ->addColumn('warehouse_phone', function ($warehouse) {
                return ' <a href="tel: '. $warehouse->phone .'" class="text-success" target="_blank">'. $warehouse->phone .'</a>';
            })
            ->addColumn('status', function ($warehouse) {
                if ($warehouse->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)" data-id="'.$warehouse->id.'" data-status="'.$warehouse->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$warehouse->id.'" data-status="'.$warehouse->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($warehouse) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$warehouse->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$warehouse->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$warehouse->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['warehouse' => $warehouse]);
                return $actionHtml;
            })
            ->rawColumns(['biller_name', 'warehouse_phone', 'status', 'action'])
            ->make(true);
    }

    public function changeWarehouseStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Warehouse::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWarehouseRequest $request)
    {
        DB::beginTransaction();
        try {
            $warehouse = new Warehouse();
            $warehouse->warehouse             = $request->warehouse;
            $warehouse->contact_person        = $request->contact_person;
            $warehouse->email                 = $request->email;
            $warehouse->phone                 = $request->phone;
            $warehouse->address               = $request->address;
            $warehouse->city                  = $request->city;
            $warehouse->state                 = $request->state;
            $warehouse->country               = $request->country;
            $warehouse->postal_code           = $request->postal_code;
            $warehouse->status                = $request->status;

            // Handle image with ImageUploadTraits function
            $uploadImage                     = $this->imageUpload($request, 'image', 'warehouse');
            $warehouse->image                 =  $uploadImage;

            $warehouse->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Warehouse Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        // dd($warehouse);
        return response()->json(['success' => $warehouse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, $id)
    {
        $warehouse  = Warehouse::find($id);

        DB::beginTransaction();
        try {
            $warehouse->warehouse             = $request->warehouse;
            $warehouse->contact_person        = $request->contact_person;
            $warehouse->email                 = $request->email;
            $warehouse->phone                 = $request->phone;
            $warehouse->address               = $request->address;
            $warehouse->city                  = $request->city;
            $warehouse->state                 = $request->state;
            $warehouse->country               = $request->country;
            $warehouse->postal_code           = $request->postal_code;
            $warehouse->status                = $request->status;
            $warehouse->updated_at            = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'warehouse', $warehouse->image );
            $warehouse->image                  =  $uploadImages;

            $warehouse->update();
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
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return response()->json(['message' => 'Warehouse has been deleted.'], 200);
    }

    public function warehouseView($id)
    {
        $warehouse  = Warehouse::find($id);
        // dd($warehouse);

        $warehouse_email = '<a href="mailto: '. $warehouse->email .'" class="text-success" target="_blank">'. $warehouse->email .'</a>';
        $warehouse_phone = '<a href="tel: '. $warehouse->phone .'" class="text-success" target="_blank">'. $warehouse->phone .'</a>';

        $statusHtml = '';
        if ($warehouse->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($warehouse->created_at));
        $updated_date = date('d F, Y', strtotime($warehouse->updated_at));

        return response()->json([
            'warehouse_email'   => $warehouse_email,
            'warehouse_phone'   => $warehouse_phone,
            'success'           => $warehouse,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
