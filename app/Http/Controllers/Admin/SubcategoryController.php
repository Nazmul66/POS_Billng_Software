<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSubCategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Traits\ImageUploadTraits;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class SubcategoryController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.subcategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getData()
    {
        // get all data
        $subCategories= Category::join('subcategories', 'subcategories.category_id', '=', 'categories.id')
                ->select('categories.name', 'subcategories.*')
                ->get();

        return DataTables::of($subCategories)
            ->addIndexColumn()
            ->addColumn('subCategoryImg', function ($subCategory) {
                return '<a href="'.asset( $subCategory->subcategory_img ).'" target="__blank">
                    <img src="'.asset( $subCategory->subcategory_img ).'" width="50px" height="50px">
                </a>';
            })
            ->addColumn('status', function ($subCategory) {
                if ($subCategory->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$subCategory->id.'" data-status="'.$subCategory->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$subCategory->id.'" data-status="'.$subCategory->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })

            ->addColumn('action', function ($subCategory) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$subCategory->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$subCategory->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$subCategory->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['subCategory' => $subCategory]);
                return $actionHtml;
            })
            ->rawColumns(['subCategoryImg','status','action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $SubCategory = new Subcategory();

            $SubCategory->category_id            = $request->category_id;
            $SubCategory->subcategory_name       = $request->subcategory_name;
            $SubCategory->slug                   = Str::slug($request->subcategory_name);
            $SubCategory->status                 = $request->status;
            $SubCategory->created_at             = now();
            $SubCategory->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImage                         = $this->imageUpload($request, 'subcategory_img', 'subCategory');
            $SubCategory->subcategory_img        =  $uploadImage;

            $SubCategory->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        return response()->json(['message'=> "Successfully SubCategory Created!", 'status' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function changeSubCategoryStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Subcategory::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        return response()->json(['success' => $subcategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, string $id)
    {
        $subcategory  = Subcategory::find($id);

        DB::beginTransaction();
        try {
            $subcategory->category_id            = $request->category_id;
            $subcategory->subcategory_name       = $request->subcategory_name;
            $subcategory->slug                   = Str::slug($request->subcategory_name);
            $subcategory->status                 = $request->status;
            $subcategory->updated_at             = now();

            // Handle image with ImageUploadTraits function
            $uploadImages                        = $this->deleteImageAndUpload($request, 'subcategory_img', 'subCategory', $subcategory->subcategory_img );
            $subcategory->subcategory_img        =  $uploadImages;
            $subcategory->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        return response()->json(['message'=> "success"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        if ($subcategory->subcategory_img) {
            if (file_exists($subcategory->subcategory_img)) {
                unlink($subcategory->subcategory_img);
            }
        }
        $subcategory->delete();
        return response()->json(['message' => 'SubCategory has been deleted.'], 200);
    }

    
    public function subCategoryView($id)
    {
        $subcategory  =  
                    Category::join('subcategories', 'subcategories.category_id', '=', 'categories.id')
                    ->select('categories.name', 'subcategories.*')
                    ->where('subcategories.id', $id)
                    ->first();

        $statusHtml = '';
        if ($subcategory->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($subcategory->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($subcategory->updated_at));

        return response()->json([
            'success'           => $subcategory,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
