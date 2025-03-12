<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleReport;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VehicleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.vehicle_report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function history()
    {
        $vehicles_reports = VehicleReport::orderBy('id', "DESC")->get();
        return view('admin.pages.vehicle_report.invoice', compact('vehicles_reports'));
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
            'customer_experience' => 'required|string',
            'test_drive_experience' => 'required|string',
            'additional_part' => 'nullable|string',
            'remarks' => 'nullable|string',
            'time_in'  => 'required',
            'time_out' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $vehicleReport = New VehicleReport();

            $vehicleReport->invoice_number         = $request->invoice_number;
            $vehicleReport->customer_name          = $request->customer_name;
            $vehicleReport->address                = $request->address;
            $vehicleReport->contact_number         = $request->contact_number;
            $vehicleReport->engineer_name          = $request->engineer_name;
            $vehicleReport->mechanic_name          = $request->mechanic_name;
            $vehicleReport->car_name               = $request->car_name;
            $vehicleReport->registration_number    = $request->registration_number;
            $vehicleReport->chassis_number         = $request->chassis_number;
            $vehicleReport->engine_number          = $request->engine_number;
            $vehicleReport->color                  = $request->color;
            $vehicleReport->customer_experience    = $request->customer_experience;
            $vehicleReport->test_drive_experience  = $request->test_drive_experience;
            $vehicleReport->additional_part        = $request->additional_part;
            $vehicleReport->remarks                = $request->remarks;
            $vehicleReport->time_in                = $request->time_in;
            $vehicleReport->time_out               = $request->time_out;
            // dd($vehicleReport);
            $vehicleReport->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            dd($ex);
            Toastr::error('Vehicles Reports shown error', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('Vehicles Reports created', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.vehicle-report-invoice-history');
    }

    /**
     * Display the specified resource.
     */
    public function view(string $id)
    {
        $vehicleReport  = VehicleReport::find($id);
        // dd($vehicleReport);

        $contact_number = '<a href="tel: '. $vehicleReport->contact_number .'" class="text-success" target="_blank">'. $vehicleReport->contact_number .'</a>';

        $created_date = $vehicleReport->time_in;
        $updated_date = $vehicleReport->time_out;

        return response()->json([
            'contact_number'    => $contact_number,
            'success'           => $vehicleReport,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicles_report = VehicleReport::findOrFail($id);
        return view('admin.pages.vehicle_report.edit', compact('vehicles_report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
            'customer_experience' => 'required|string',
            'test_drive_experience' => 'required|string',
            'additional_part' => 'nullable|string',
            'remarks'  => 'nullable|string',
            'time_in'  => 'required',
            'time_out' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $vehicleReport = VehicleReport::findOrFail($id);

            $vehicleReport->customer_name          = $request->customer_name;
            $vehicleReport->address                = $request->address;
            $vehicleReport->contact_number         = $request->contact_number;
            $vehicleReport->engineer_name          = $request->engineer_name;
            $vehicleReport->mechanic_name          = $request->mechanic_name;
            $vehicleReport->car_name               = $request->car_name;
            $vehicleReport->registration_number    = $request->registration_number;
            $vehicleReport->chassis_number         = $request->chassis_number;
            $vehicleReport->engine_number          = $request->engine_number;
            $vehicleReport->color                  = $request->color;
            $vehicleReport->customer_experience    = $request->customer_experience;
            $vehicleReport->test_drive_experience  = $request->test_drive_experience;
            $vehicleReport->additional_part        = $request->additional_part;
            $vehicleReport->remarks                = $request->remarks;
            $vehicleReport->time_in                = $request->time_in;
            $vehicleReport->time_out               = $request->time_out;
            // dd($vehicleReport);
            $vehicleReport->update();
        }
        catch(\Exception $ex){
            DB::rollBack();
            // throw $ex;
            dd($ex);
            Toastr::error('Vehicles Reports Updated Shown Error', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('Vehicles Reports Updated', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.vehicle-report-invoice-history');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicleReport = VehicleReport::findOrFail($id);
        $vehicleReport->delete();

        Toastr::success('Vehicles Reports Successful Delete', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }

    public function pdf(string $id)
    {
        $vehicle_pdf = VehicleReport::findOrFail($id);
        $pdf = Pdf::loadView('admin.pages.vehicle_report.pdf', ['vehicle_pdf' => $vehicle_pdf]);
        return $pdf->download('invoice.pdf');
      
        // return view('admin.pages.vehicle_report.pdf', compact('vehicle_pdf'));
    }
}
