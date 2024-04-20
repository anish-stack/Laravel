<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadStatusController;
use App\Models\LeadStatus;


class LeadStatusController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LeadStatus::get();
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('ls_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->ls_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->ls_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ls_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ls_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->ls_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['ls_status', 'action'])
                    ->make(true);
        }
          
        // return view('lead');
        return view('LeadStatus.create');
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
          
        LeadStatus::updateOrCreate([
                    'ls_id' => $request->product_id
                ],
                [
                    'ls_name' => $request->name, 
                    // 'ls_status' => $request->detail,
                    'ls_status' => $request->has('detail') ? 1 : 0,
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
        $lead = LeadStatus::find($id);
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
        $lead = LeadStatus::find($id);
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
        LeadStatus::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = LeadStatus::findOrFail($request->id);
        $leadCall->ls_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
}

