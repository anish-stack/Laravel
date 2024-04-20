<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadPipelineStageController;
use App\Models\LeadPipelineStage;


class LeadPipelineStageController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LeadPipelineStage::get();
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('lps_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->lps_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->lps_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lps_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lps_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lps_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['lps_status', 'action'])
                    ->make(true);
        }
          
        // return view('lead');
        return view('LeadPipelineStage.create');
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
            'name' => 'required', 
            // 'detail' => 'required',
        ],
        [
            'name.required'=>'The name is Required',
            // 'detail.required'=>'The Details is Required'
        ]
    );
          
        LeadPipelineStage::updateOrCreate([
                    'lps_id' => $request->product_id
                ],
                [
                    'lps_name' => $request->name, 
                    // 'lps_status' => $request->detail,
                    'lps_status' => $request->has('detail') ? 1 : 0,
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
        $lead = LeadPipelineStage::find($id);
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
        $lead = LeadPipelineStage::find($id);
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
        LeadPipelineStage::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = LeadPipelineStage::findOrFail($request->id);
        $leadCall->lps_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
}
