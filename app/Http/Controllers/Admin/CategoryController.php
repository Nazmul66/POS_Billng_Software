<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Traits\ImageUploadTraits;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class CategoryController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.categories.index');
    }

    public function getData()
    {
        // get all data
        $categories= Category::all();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('categoryImg', function ($category) {
                return '<a href="'.asset( $category->img ).'" target="__target">
                     <img src="'.asset( $category->img ).'" width="50px" height="50px" >
                </a>';
            })
            ->addColumn('status', function ($category) {
                if ($category->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$category->id.'" data-status="'.$category->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$category->id.'" data-status="'.$category->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($category) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$category->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$category->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$category->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['category' => $category]);
                return $actionHtml;
            })
            ->rawColumns(['categoryImg', 'status', 'action'])
            ->make(true);
    }

    public function changeCategoryStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Category::findOrFail($id);
        $page->status = $status;
        $page->save();

        //Debugged this code --> return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        DB::beginTransaction();
        try {

            $category = new Category();
            $category->name                  = $request->name;
            $category->slug                   = Str::slug($request->name);
            $category->status                 = $request->status;

            // Handle image with ImageUploadTraits function
            $uploadImage                      = $this->imageUpload($request, 'img', 'category');
            $category->img                    =  $uploadImage;
            $category->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Category Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // dd($category);
        return response()->json(['success' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category  = Category::find($id);

        DB::beginTransaction();
        try {
            // Handle image with ImageUploadTraits function
            $category->name                   = $request->name;
            $category->slug                   = Str::slug($request->name);
            $category->status                 = $request->status;

            $uploadImages                     = $this->deleteImageAndUpload($request, 'img', 'category', $category->img );
            $category->img                   =  $uploadImages;

            $category->save();
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
    public function destroy(Category $category)
    {

        if ($category->img) {
            if (file_exists($category->img)) {
                unlink($category->img);
            }
        }

        $category->delete();

        return response()->json(['message' => 'Category has been deleted.'], 200);
    }

    public function CategoryView($id)
    {
        $category  = Category::find($id);
        // dd($category);

        $statusHtml = '';
        if ($category->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($category->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($category->updated_at));

        return response()->json([
            'success'           => $category,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
