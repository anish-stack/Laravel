<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadCallOutComeController;
use App\Models\LeadCallOutCome;


class LeadCallOutComeController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LeadCallOutCome::get();
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('lco_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->lco_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->lco_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lco_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lco_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lco_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['lco_status', 'action'])
                    ->make(true);
        }
          
        // return view('lead');
        return view('leadcalloutcome.create');
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
          
        LeadCallOutCome::updateOrCreate([
                    'lco_id' => $request->product_id
                ],
                [
                    'lco_name' => $request->name, 
                    // 'lco_status' => $request->detail,
                    'lco_status' => $request->has('detail') ? 1 : 0,
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
        $lead = LeadCallOutCome::find($id);
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
        $lead = LeadCallOutCome::find($id);
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
        LeadCallOutCome::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = LeadCallOutCome::findOrFail($request->id);
        $leadCall->lco_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
}
