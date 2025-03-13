<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingPos;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\VehicleReport;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingPosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.pages.billing_pos.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function history()
    {
        $billing_pos = BillingPos::orderBy('id', "DESC")->get();
        return view('admin.pages.billing_pos.invoice', compact('billing_pos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'invoice_number' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'engineer_name' => 'required|string|max:255',
            'mechanic_name' => 'required|string|max:255',
            'car_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'time_in'  => 'required',
            'time_out' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $billing_pos = New BillingPos();

            $billing_pos->invoice_number         = $request->invoice_number;
            $billing_pos->customer_name          = $request->customer_name;
            $billing_pos->address                = $request->address;
            $billing_pos->contact_number         = $request->contact_number;
            $billing_pos->engineer_name          = $request->engineer_name;
            $billing_pos->mechanic_name          = $request->mechanic_name;
            $billing_pos->car_name               = $request->car_name;
            $billing_pos->registration_number    = $request->registration_number;
            $billing_pos->chassis_number         = $request->chassis_number;
            $billing_pos->engine_number          = $request->engine_number;
            $billing_pos->color                  = $request->color;
            $billing_pos->remarks                = $request->remarks;
            $billing_pos->time_in                = $request->time_in;
            $billing_pos->time_out               = $request->time_out;
            
            $products = [];
            for ($i = 0; $i < count($request->product_name); $i++) {
                $products[] = [
                    'product_id' => $request->product_id[$i],
                    'productSlug' => $request->productSlug[$i],
                    'product_name' => $request->product_name[$i],
                    'prdt_qty' => $request->prdt_qty[$i],
                    'prdt_price' => $request->prdt_price[$i],
                    'totals' => $request->totals[$i],
                ];
            }

            $services = [];
            for ($i = 0; $i < count($request->service_name); $i++) {
                $services[] = [
                    'service_name' => $request->service_name[$i],
                    'unit_price' => $request->unit_price[$i],
                    'total_price' => $request->total_price[$i],
                ];
            }

            // dd($services);
            $billing_pos->products               = json_encode($products);
            $billing_pos->services               = json_encode($services);

            // dd($billing_pos);
            $billing_pos->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            dd($ex);
            Toastr::error('Billing POS shown error', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('Billing POS created', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.billing-pos-invoice-history');
    }

    /**
     * Display the specified resource.
     */
    public function view(string $id)
    {
        $billing_pos  = BillingPos::find($id);
        // dd($billing_pos);

        return view('admin.pages.billing_pos.view', compact('billing_pos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::orderBy('id', 'DESC')->get();
        $billing_pos = BillingPos::findOrFail($id);
        return view('admin.pages.billing_pos.edit', compact('billing_pos', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'engineer_name' => 'required|string|max:255',
            'mechanic_name' => 'required|string|max:255',
            'car_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'chassis_number' => 'required|string|max:255',
            'engine_number' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'time_in'  => 'required',
            'time_out' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $billing_pos = BillingPos::findOrFail($id);

            $billing_pos->customer_name          = $request->customer_name;
            $billing_pos->address                = $request->address;
            $billing_pos->contact_number         = $request->contact_number;
            $billing_pos->engineer_name          = $request->engineer_name;
            $billing_pos->mechanic_name          = $request->mechanic_name;
            $billing_pos->car_name               = $request->car_name;
            $billing_pos->registration_number    = $request->registration_number;
            $billing_pos->chassis_number         = $request->chassis_number;
            $billing_pos->engine_number          = $request->engine_number;
            $billing_pos->color                  = $request->color;
            $billing_pos->remarks                = $request->remarks;
            $billing_pos->time_in                = $request->time_in;
            $billing_pos->time_out               = $request->time_out;
            
            $products = [];
            if (!empty($request->product_id) && is_array($request->product_name)) { 
                for ($i = 0; $i < count($request->product_name); $i++) {
                    $products[] = [
                        'product_id' => $request->product_id[$i] ?? null,
                        'productSlug' => $request->productSlug[$i] ?? null,
                        'product_name' => $request->product_name[$i] ?? null,
                        'prdt_qty' => $request->prdt_qty[$i] ?? 0,
                        'prdt_price' => $request->prdt_price[$i] ?? 0,
                        'totals' => $request->totals[$i] ?? 0,
                    ];
                }
            }


            $services = [];
            for ($i = 0; $i < count($request->service_name); $i++) {
                $services[] = [
                    'service_name' => $request->service_name[$i],
                    'unit_price' => $request->unit_price[$i],
                    'total_price' => $request->total_price[$i],
                ];
            }

            // dd($services);
            $billing_pos->products               = $products ? json_encode($products) : NULL;
            $billing_pos->services               = json_encode($services);

            // dd($billing_pos);
            $billing_pos->update();
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            dd($ex);
            Toastr::error('Billing POS Update Shown Error', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('Billing POS Update', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.billing-pos-invoice-history');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $billing_pos = BillingPos::findOrFail($id);
        $billing_pos->delete();

        Toastr::success('Billing POS Successful Delete', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    public function pdf(string $id)
    {
        $billing_pos = BillingPos::findOrFail($id);
        $pdf = Pdf::loadView('admin.pages.billing_pos.pdf', ['billing_pos' => $billing_pos]);
        return $pdf->download('bill-invoice.pdf');

        // return view('admin.pages.billing_pos.pdf', compact('billing_pos'));
    }
}
