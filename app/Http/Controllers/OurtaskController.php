<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\OurtaskController;
use App\Models\ourtask;


class OurtaskController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ourtask::get();
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('ot_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->ot_status ? 'checked' : '') . ' class="status-toggle btn btn-succuss" data-id="' . $row->ot_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                        //    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ot_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ot_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ot_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['ot_status', 'action'])
                    ->make(true);
        }
          
        // return view('lead');
        return view('ourtask.create');
    }
            
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ourtask' => 'required', 
            'ourremark' => 'required',
            'ourdate' => 'required',
        ],
        [
            'ourtask.required'=>'The Task name is Required',
            'ourremark.required'=>'The Remark is Required',
            'ourdate.required'=>'The Date is Required',
            // 'detail.required'=>'The Details is Required'
        ]
    );
          
        ourtask::updateOrCreate([
                    'ot_id' => $request->ot_id
                ],
                [
                    'ot_name' => $request->ourtask, 
                    'ot_remark' => $request->ourremark, 
                    'ot_remind_dt' => $request->ourdate, 
                    // 'ot_status' => $request->detail,
                    'ot_status' => $request->has('detail') ? 1 : 0,
                    // '' = $request->has('detail') ? 1 : 0;
                ],);        
       
        return response()->json(['success'=>'Lead saved successfully.']);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $lead = ourtask::find($id);
        return response()->json($lead);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit($id): JsonResponse
    {
        $lead = ourtask::find($id);
        return response()->json($lead);
    }
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        ourtask::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = ourtask::findOrFail($request->id);
        $leadCall->ot_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
}

