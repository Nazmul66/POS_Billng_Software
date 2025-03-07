<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Bill;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class BillerController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.billers.index');
    }

    public function getData()
    {
        // get all data
        $bills = Bill::all();

        return DataTables::of($bills)
            ->addIndexColumn()
            ->addColumn('biller_name', function ($bill) {
                return $bill->first_name . $bill->last_name;
            })
            ->addColumn('biller_phone', function ($bill) {
                return ' <a href="tel: '. $bill->phone .'" class="text-success" target="_blank">'. $bill->phone .'</a>';
            })
            ->addColumn('status', function ($bill) {
                if ($bill->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)" data-id="'.$bill->id.'" data-status="'.$bill->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$bill->id.'" data-status="'.$bill->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($bill) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$bill->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$bill->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$bill->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['bill' => $bill]);
                return $actionHtml;
            })
            ->rawColumns(['biller_name', 'biller_phone', 'status', 'action'])
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

        $page = Bill::findOrFail($id);
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
            $bill = new Bill();
            $bill->first_name            = $request->first_name;
            $bill->last_name             = $request->last_name;
            $bill->email                 = $request->email;
            $bill->phone                 = $request->phone;
            $bill->address               = $request->address;
            $bill->city                  = $request->city;
            $bill->state                 = $request->state;
            $bill->country               = $request->country;
            $bill->postal_code           = $request->postal_code;
            $bill->status                = $request->status;

            // Handle image with ImageUploadTraits function
            $uploadImage                     = $this->imageUpload($request, 'image', 'bill');
            $bill->image                 =  $uploadImage;

            $bill->save();
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
    public function edit(Bill $bill)
    {
        // dd($bill);
        return response()->json(['success' => $bill]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $bill  = Bill::find($id);

        DB::beginTransaction();
        try {
            $bill->first_name            = $request->first_name;
            $bill->last_name             = $request->last_name;
            $bill->email                 = $request->email;
            $bill->phone                 = $request->phone;
            $bill->address               = $request->address;
            $bill->city                  = $request->city;
            $bill->state                 = $request->state;
            $bill->country               = $request->country;
            $bill->postal_code           = $request->postal_code;
            $bill->status                = $request->status;
            $bill->updated_at                = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'bill', $bill->image );
            $bill->image                  =  $uploadImages;

            $bill->update();
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
    public function destroy(Bill $bill)
    {
        if ($bill->image) {
            if (file_exists($bill->image)) {
                unlink($bill->image);
            }
        }
        $bill->delete();
        return response()->json(['message' => 'Bill has been deleted.'], 200);
    }

    public function billView($id)
    {
        $bill  = Bill::find($id);
        // dd($bill);

        $full_name = $bill->first_name . $bill->last_name;
        $biller_email = '<a href="mailto: '. $bill->email .'" class="text-success" target="_blank">'. $bill->email .'</a>';
        $biller_phone = '<a href="tel: '. $bill->phone .'" class="text-success" target="_blank">'. $bill->phone .'</a>';

        $statusHtml = '';
        if ($bill->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($bill->created_at));
        $updated_date = date('d F, Y', strtotime($bill->updated_at));

        return response()->json([
            'full_name'         => $full_name,
            'biller_email'      => $biller_email,
            'biller_phone'      => $biller_phone,
            'success'           => $bill,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
