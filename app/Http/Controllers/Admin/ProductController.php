<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTraits;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class ProductController extends Controller
{
    use ImageUploadTraits;

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $categories        = Category::where('status', 1)->get();
        $subCategories     = Subcategory::where('status', 1)->get();
        $brands            = Brand::where('status', 1)->get();

        return view('admin.pages.products.index', compact('categories', 'subCategories', 'brands'));
    }

    public function create()
    {
        $categories        = Category::where('status', 1)->get();
        $subCategories     = Subcategory::where('status', 1)->get();
        $brands            = Brand::where('status', 1)->get();
        $units             = Unit::where('status', 1)->get();
        return view('admin.pages.products.create', compact('categories', 'subCategories', 'units', 'brands'));
    }

    public function getData(Request $request)
    {
        // get all data
        $products = "";
           $query = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                    ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                    ->leftJoin('brands', 'brands.id', 'products.brand_id');
                   
                    if( !empty($request->category_id) ){
                        $query->where('products.category_id', $request->category_id);
                    }

                    if( !empty($request->subCategory_id) ){
                        $query->where('products.subCategory_id', $request->subCategory_id);
                    }

                    if( !empty($request->product_qty) ){
                        $qtyRange = explode('-', $request->product_qty);
                        if (count($qtyRange) === 2) {
                            $query->whereBetween('qty', [$qtyRange[0], $qtyRange[1]]);
                        }
                    }

                    if( !empty($request->product_price) ){
                        $priceRange = explode('-', $request->product_price);
                        if (count($priceRange) === 2) {
                            $query->whereBetween('offer_price', [$priceRange[0], $priceRange[1]]);
                        }
                    }

            $products = $query->select('products.*', 'categories.name as cat_name', 'subcategories.subcategory_name as subCat_name', 'brands.brand_name')
                    ->get();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('product_img', function ($product) {
                return ' <a href="'.asset( $product->thumb_image ).'" target="__blank">
                      <img src="'.asset( $product->thumb_image ).'" width="100px" height="100px">
                </a>';
            })
            ->addColumn('categorized', function ($product) {
                $subCat = $product->subCat_name ?? 'N/A';
                return '<div class="">
                       <h6>Category Name: <span class="badge bg-success">'. $product->cat_name .'</span></h6> 
                       <h6>SubCategory Name : <span class="badge bg-success">'. $subCat .'</span></h6>
                </div>';
            })
            ->addColumn('product_details', function ($product) {
                return '<div class="">
                       <h6><span class="text-dark">'. $product->name .'</span></h6> 
                </div>';
            })
            ->addColumn('quantity', function ($product) {
                return '<div class="">
                       <h6><span class="text-dark">'. $product->qty .' '. $product->units .'</span></h6>
                </div>';
            })
            ->addColumn('status', function ($product) {
                if ($product->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$product->id.'" data-status="'.$product->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$product->id.'" data-status="'.$product->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($product) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a  href="'. route('admin.product.show', $product->id) .'" ><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="'. route('admin.product.edit', $product->id) .'" class="ms-2" data-id="'.$product->id.'"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$product->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['product' => $product]);
                return $actionHtml;
            })

            ->rawColumns(['categorized', 'quantity', 'product_details', 'product_img', 'status', 'action'])
            ->make(true);
    }

    public function changeProductStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Product::findOrFail($id);
        $page->status = $status;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $product = new Product();

            $product->name                      = $request->name;
            $product->slug                      = Str::slug($request->name);
            $product->sku                       = $request->sku;
            $product->barcode                   = 730 . rand(100000000, 999999999);
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->qty                       = $request->qty;
            $product->units                     = $request->units;
            $product->price                     = $request->purchase_price;
            $product->offer_price               = $request->selling_price;
            $product->long_description          = $request->long_description;
            $product->status                    = 1;
    
            // Handle image with ImageUploadTraits function
            $uploadImage                        = $this->imageUpload($request, 'thumb_image', 'product');
            $product->thumb_image               =  $uploadImage;
    
            $product->save();
            // dd($product);
        }

        catch(Exception $ex){
            DB::rollBack();
            // throw $ex;

            dd($ex);
            Toastr::error('Product create error', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back(); // Stop execution and redirect
        }

        DB::commit();
        Toastr::success('Product Create Successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.product.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($product);
        $categories        = Category::where('status', 1)->get();
        $subCategories     = Subcategory::where('status', 1)->get();
        $brands            = Brand::where('status', 1)->get();
        $units             = Unit::where('status', 1)->get();
        $product           = Product::findOrFail($id);

        return view('admin.pages.products.edit', compact('categories', 'subCategories', 'units', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product  = Product::find($id);

        DB::beginTransaction();
        try {

            $product->name                      = $request->name;
            $product->slug                      = Str::slug($request->name);
            $product->category_id               = $request->category_id;
            $product->subCategory_id            = $request->subCategory_id;
            $product->brand_id                  = $request->brand_id;
            $product->qty                       = $request->qty;
            $product->units                     = $request->units;
            $product->price                     = $request->purchase_price;
            $product->offer_price               = $request->selling_price;
            $product->long_description          = $request->long_description;
            $product->status                    = 1;
    
            // Handle image with ImageUploadTraits function
            $uploadImages                     = $this->deleteImageAndUpload($request, 'thumb_image', 'product', $product->thumb_image );
            $product->thumb_image           =  $uploadImages;
        
            $product->update();
        }
        catch(Exception $ex){
            DB::rollBack();
            // throw $ex;
            Toastr::error('Product updated error', 'Error', ["positionClass" => "toast-top-right"]);
        }

        DB::commit();
        Toastr::success('Product updated successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.product.index');
        // return response()->json(['message'=> "Successfully Product Updated!", 'status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->thumb_image) {
            if (file_exists($product->thumb_image)) {
                unlink($product->thumb_image);
            }
        }

        $product->delete();
        return response()->json(['message' => 'Product has been deleted.'], 200);
    }

    public function getSubCategories(Request $request, Category $category)
    {
        $subcats= SubCategory::where('category_id', $category->id)->get();
        return response()->json(['message' => 'success', 'data' => $subcats], 200);
    }


    public function get_product_subCategory_data(Request $request)
    {
        // dd($request->all());
        $subCategories = Subcategory::where('category_id', $request->id)->where('status', 1)->get();

        // 'subcategory_img' is the column name where image filename is stored
        foreach ($subCategories as $subCategory) {
            $subCategory->image_url = asset($subCategory->subcategory_img); 
        }

        return response()->json(['status' => true, 'data' => $subCategories]);
    }


    public function show($id)
    {
        $product = Product::leftJoin('categories', 'categories.id', 'products.category_id')
                ->leftJoin('subcategories', 'subcategories.id', 'products.subCategory_id')
                ->leftJoin('brands', 'brands.id', 'products.brand_id')
                ->select('products.*', 'categories.name as cat_name', 'subcategories.subcategory_name as subCat_name','brands.brand_name')
                ->where('products.id', $id)
                ->first();

       return view('admin.pages.products.view', compact('product'));
    }
}
