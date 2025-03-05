<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.units.index');
    }

    public function getData()
    {
        // get all data
        $units = Unit::all();

        return DataTables::of($units)
            ->addIndexColumn()
            ->addColumn('status', function ($unit) {
                if ($unit->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$unit->id.'" data-status="'.$unit->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$unit->id.'" data-status="'.$unit->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($unit) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$unit->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$unit->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$unit->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['unit' => $unit]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeUnitStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Unit::findOrFail($id);
        $page->status = $status;
        $page->save();

        //Debugged this code --> return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
        return response()->json(['message' => 'success', 'status' => $status, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit' => ['required', 'unique:units,unit', 'max:155'],
            'short_name' => ['required', 'unique:units,short_name', 'max:155'],
        ]);

        DB::beginTransaction();
        try {
            $unit = new Unit();
            $unit->unit                  = $request->unit;
            $unit->short_name            = $request->short_name;
            $unit->status                = $request->status;
            $unit->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully Unit Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        // dd($unit);
        return response()->json(['success' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'unit' => ['required', 'unique:units,unit,' . $id, 'max:155'],
            'short_name' => ['required', 'unique:units,short_name,' . $id, 'max:155'],
        ]);

        $unit  = Unit::find($id);

        DB::beginTransaction();
        try {
            $unit->unit                  = $request->unit;
            $unit->short_name            = $request->short_name;
            $unit->status                = $request->status;
            $unit->updated_at            = now();
            $unit->update();
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
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json(['message' => 'Unit has been deleted.'], 200);
    }

    public function unitView($id)
    {
        $unit  = Unit::find($id);
        // dd($unit);

        $statusHtml = '';
        if ($unit->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y', strtotime($unit->created_at));
        $updated_date = date('d F, Y', strtotime($unit->updated_at));

        return response()->json([
            'success'           => $unit,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
