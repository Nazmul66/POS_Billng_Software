<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Traits\ImageUploadTraits;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class BrandsController extends Controller
{
    use ImageUploadTraits;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.brands.index');
    }
 
    public function getData()
    {
        // get all data
        $brands= Brand::all();

        return DataTables::of($brands)
            ->addIndexColumn()
            ->addColumn('brandImage', function ($brand) {
                return '<a href="'.asset( $brand->image ).'" target="__blank">
                     <img src="'.asset( $brand->image ).'" width="50px" height="50px">
                </a>';
            })
            ->addColumn('status', function ($brand) {
                if ($brand->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$brand->id.'" data-status="'.$brand->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$brand->id.'" data-status="'.$brand->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($brand) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$brand->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$brand->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$brand->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['brand' => $brand]);
                return $actionHtml;
            })
            ->rawColumns(['brandImage', 'status', 'action'])
            ->make(true);
    }

    public function changeBrandStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Brand::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $brand = new Brand();
            $brand->brand_name             = Str::title($request->brand_name);
            $brand->slug                   = Str::slug($request->brand_name);
            $brand->status                 = $request->status;
            $brand->created_at             = now();
            $brand->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImage                   = $this->imageUpload($request, 'image', 'brand');
            $brand->image                  =  $uploadImage;

            // dd($brand);
            $brand->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Brand Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        // dd($brand);
        return response()->json(['success' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand  = Brand::find($id);

        DB::beginTransaction();
        try {
            $brand->brand_name             = Str::title($request->brand_name);
            $brand->slug                   = Str::slug($request->brand_name);
            $brand->status                 = $request->status;
            $brand->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                  = $this->deleteImageAndUpload($request, 'image', 'brand', $brand->image );
            $brand->image                  =  $uploadImages;

            $brand->save();
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
    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            if (file_exists($brand->image)) {
                unlink($brand->image);
            }
        }
        $brand->delete();
        return response()->json(['message' => 'Brand has been deleted.'], 200);
    }


    public function brandView($id)
    {
        $brand  = Brand::find($id);
        // dd($brand);

        $statusHtml = '';
        if ($brand->status == 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($brand->created_at));
        $updated_date = date('d F, Y', strtotime($brand->updated_at));

        return response()->json([
            'success'           => $brand,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }

}
