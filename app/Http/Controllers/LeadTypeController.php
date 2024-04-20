<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadTypeController;
use App\Models\LeadType;


class LeadTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LeadType::get();
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('lt_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->lt_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->lt_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lt_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lt_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->lt_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['lt_status', 'action'])
                    ->make(true);
        }
          
        // return view('lead');
        return view('LeadType.create');
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
          
        LeadType::updateOrCreate([
                    'lt_id' => $request->product_id
                ],
                [
                    'lt_name' => $request->name, 
                    // 'lt_status' => $request->detail,
                    'lt_status' => $request->has('detail') ? 1 : 0,
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
        $lead = LeadType::find($id);
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
        $lead = LeadType::find($id);
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
        LeadType::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = LeadType::findOrFail($request->id);
        $leadCall->lt_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
}
