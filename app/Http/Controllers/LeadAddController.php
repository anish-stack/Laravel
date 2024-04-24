<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadAddController;
use App\Models\LeadAdd;
use App\Models\LeadProjectName;
use App\Models\LeadAvailableSize;
use App\Models\LeadSourceType;


class LeadAddController extends Controller
{   
    public function index(Request $request)
    {
// $data = LeadAdd::with('project')->get();
// dd($data);
        if ($request->ajax()) {
            // $data = LeadAdd::get(); 
            // $data = LeadAdd::with(['LeadProjectName', 'LeadAvailableSize'])->get();  
            $data = LeadAdd::select('lead_adds.*', 'lead_project_names.lpn_name', 'lead_available_sizes.las_name')
            ->leftJoin('lead_project_names', 'lead_adds.la_pn_id', '=', 'lead_project_names.lpn_id')
            ->leftJoin('lead_available_sizes', 'lead_adds.la_as_id', '=', 'lead_available_sizes.las_id')
            ->leftJoin('lead_source_types', 'lead_adds.la_source', '=', 'lead_source_types.lst_id')
            ->get();        
        
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('la_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->la_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->la_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    // <a href="{{ route('leadadd.edit', ['id' => $row->la_id]) }}" data-toggle="tooltip" data-id="{{ $row->la_id }}" data-original-title="Edit" class="edit btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i> Edit</a>

                    ->addColumn('action', function($row){
                        //    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                        //    $btn = '<a href="{{ route('leadadd.edit', ['id' => $row->la_id]) }}" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                               $btn = '<a href="' . route('leadadd.edit', ['id' => $row->la_id]) . '" data-toggle="tooltip"  data-id="' . $row->la_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';


                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['la_status', 'action'])
                    ->make(true);                   
        }          
        $projects = LeadProjectName::pluck('lpn_name', 'lpn_id');
        $sizes = LeadAvailableSize::pluck('las_name', 'las_id');

        return view('LeadAdd.show', compact('projects', 'sizes'));
        // return view('LeadAdd.create', compact('projects', 'sizes'));
    }

    public function createLead(){
         $projects = LeadProjectName::pluck('lpn_name', 'lpn_id');
        $sizes = LeadAvailableSize::pluck('las_name', 'las_id');
        $sources = LeadSourceType::pluck('lst_name', 'lst_id');

        return view('LeadAdd.create', compact('projects', 'sizes','sources'));
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
                'source' => 'required', 
                'mobile' => 'required', 
                'address' => 'required', 
                'city' => 'required', 
                'project_name' => 'required', 
                'a_size' => 'required', 
                'a_size' => 'required', 
                'remark' => 'required', 
                // 'detail' => 'required',
            ],
            [
                'name.required'=>'The name is Required',
                'source.required'=>'The source is Required',
                'mobile.required'=>'The Mobile No. is Required',
                'address.required'=>'The Address is Required',
                'city.required'=>'The City is Required',
                'project_name.required'=>'The Project Name  is Required',
                'a_size.required'=>'The Size is Required',
                'remark.required'=>'The remark is Required'
            ]
        );
          
//       $mobileNumbers = $request->input('mobile');
// dd($mobileNumbers);
// if ($request->has('mobile') && ($request->mobile!==null)) {
//     $la_mobile = implode(',', $request->mobile);
//     // Add $la_mobile to the database
// }
// dd($la_mobile);
        LeadAdd::updateOrCreate([
                    'la_id' => $request->product_id
                ],
                [
                    'la_customerNname' => $request->name, 
                    'la_source' => $request->source,              
                    'la_mobile' => implode(',', $request->mobile ),
                    'la_address' => $request->address, 
                    'la_city' => $request->city, 
                    'la_pn_id' => $request->project_name, 
                    'la_as_id' => $request->a_size,                     
                    'la_remark' => $request->remark,                     
                    'la_status' => $request->has('detail') ? 1 : 0,
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
        $lead = LeadAdd::find($id);
        return response()->json($lead);
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    // public function edit($id): JsonResponse
    // {
    //     $lead = LeadAdd::find($id);
    //     return response()->json($lead);
    // }
    public function edit($id) 
    {
        $lead = LeadAdd::find($id);

        $projects = LeadProjectName::pluck('lpn_name', 'lpn_id');
        $sizes = LeadAvailableSize::pluck('las_name', 'las_id');
        $sources = LeadSourceType::pluck('lst_name', 'lst_id');

        return view('LeadAdd.edit', compact('projects', 'sizes','sources','lead'));
    //    return view('LeadAdd.edit', compact('lead'));
    }
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        LeadAdd::find($id)->delete();
        
        return response()->json(['success'=>'Lead deleted successfully.']);
    }

     public function updateStatus(Request $request)
    {
        // dd($request->id);
        $leadCall = LeadAdd::findOrFail($request->id);
        $leadCall->la_status = $request->status;
        $leadCall->save();

        return response()->json(['success' => true]);
    }
     public function showData(Request $request)
    {
        dd("hh");
       if ($request->ajax()) {
            // $data = LeadAdd::get(); 
            $data = LeadAdd::with(['project', 'availableSize'])->get();
         
            return DataTables::of($data)
                    ->addIndexColumn()
                     ->addColumn('la_status', function($row) {                                          
                    return '<span class="switch">
                                <label>
                                    <input type="checkbox" ' . ($row->la_status ? 'checked' : '') . ' class="status-toggle" data-id="' . $row->la_id . '">
                                    <span class="slider round"></span>
                                </label>
                            </span>';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showLead"><i class="fa-regular fa-eye"></i> View</a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> Delete</a>';
                            return $btn;
                    })                    
                    ->rawColumns(['la_status', 'action'])
                    ->make(true);
                }
                return view('leadAdd.show');
    }
}



