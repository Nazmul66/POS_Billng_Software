<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Blade;

class QNAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.qna.index');
    }

    public function getData()
    {
        // get all data
        $qnas = Qna::all();

        return DataTables::of($qnas)
            ->addIndexColumn()
            ->addColumn('status', function ($qna) {
                if ($qna->status == 1) {
                    return ' <a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$qna->id.'" data-status="'.$qna->status.'"> <i
                            class="fa-solid fa-toggle-on fa-2x"></i>
                    </a>';
                } else {
                    return '<a class="status text-success" id="status" href="javascript:void(0)"
                        data-id="'.$qna->id.'" data-status="'.$qna->status.'"> <i
                            class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
                }
            })
            ->addColumn('action', function ($qna) {
                $actionHtml = Blade::render('
                    <div class="d-flex order-actions">
                        <a href="javascript:;" id="viewButton" data-id="'.$qna->id.'" data-bs-toggle="modal" data-bs-target="#viewModal"><ion-icon name="eye-outline"></ion-icon></a>
                        
                        <a href="javascript:;" id="editButton" class="ms-2" data-id="'.$qna->id.'" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bx bx-edit"></i></a>

                        <a href="javascript:;" class="ms-2" data-id="'.$qna->id.'" id="deleteBtn"><i class="bx bx-trash"></i></a>
                    </div>
                ', ['qna' => $qna]);
                return $actionHtml;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function changeQnaStatus(Request $request)
    {
        $id = $request->id;
        $Current_status = $request->status;

        if ($Current_status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $page = Qna::findOrFail($id);
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
            'question' => 'required|max:400|unique:qnas,question',
            'answer'   => 'required|max:400|unique:qnas,answer',
        ]);

        DB::beginTransaction();
        try {
            $qna                     = new Qna();
            $qna->question           = $request->question;
            $qna->answer             = $request->answer;
            $qna->status             = $request->status;
            $qna->save();
        }
        catch(\Exception $ex){
            DB::rollBack();
            throw $ex;
            // dd($ex->getMessage());
        }

        DB::commit();
        return response()->json(['message'=> "Successfully QNA Created!", 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qna $qna)
    {
        // dd($qna);
        return response()->json(['success' => $qna]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|max:400|unique:qnas,question,' .$id,
            'answer'   => 'required|max:400|unique:qnas,answer,' .$id,
        ]);

        $qna  = Qna::find($id);

        DB::beginTransaction();
        try {
            $qna->question           = $request->question;
            $qna->answer             = $request->answer;
            $qna->status                 = $request->status;
            $qna->save();
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
    public function destroy(Qna $qna)
    {
        $qna->delete();

        return response()->json(['message' => 'QNA has been deleted.'], 200);
    }

    public function qnaView($id)
    {
        $qna  = Qna::find($id);
        // dd($qna);

        $statusHtml = '';
        if ($qna->status === 1) {
            $statusHtml = '<span class="text-success">Active</span>';
        } else {
            $statusHtml = '<span class="text-danger">Inactive</span>';
        }

        $created_date = date('d F, Y H:i:s A', strtotime($qna->created_at));
        $updated_date = date('d F, Y H:i:s A', strtotime($qna->updated_at));

        return response()->json([
            'success'           => $qna,
            'statusHtml'        => $statusHtml,
            'created_date'      => $created_date,
            'updated_date'      => $updated_date,
        ]);
    }
}
