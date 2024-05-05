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
use App\Models\LeadStatus;


class LeadAddController extends Controller
{   
    public function index(Request $request)
    {
  
        if ($request->ajax()) {
            
            if(Auth()->user()->usertype=='admin'){
            $data = LeadAdd::select('lead_adds.*', 'lead_project_names.lpn_name', 'lead_available_sizes.las_name')
            ->leftJoin('lead_project_names', 'lead_adds.la_pn_id', '=', 'lead_project_names.lpn_id')
            ->leftJoin('lead_available_sizes', 'lead_adds.la_as_id', '=', 'lead_available_sizes.las_id')
            ->leftJoin('lead_source_types', 'lead_adds.la_source', '=', 'lead_source_types.lst_id')
            ->get();        
            }
            else{
                  $data = LeadAdd::where('la_user_id',Auth()->user()->id)->select('lead_adds.*', 'lead_project_names.lpn_name', 'lead_available_sizes.las_name')
            ->leftJoin('lead_project_names', 'lead_adds.la_pn_id', '=', 'lead_project_names.lpn_id')
            ->leftJoin('lead_available_sizes', 'lead_adds.la_as_id', '=', 'lead_available_sizes.las_id')
            ->leftJoin('lead_source_types', 'lead_adds.la_source', '=', 'lead_source_types.lst_id')
            ->get(); 
            }
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
                         $btn = '<span class="svg-icon svg-icon-primary svg-icon-2x" onclick="openModal(' . $row->la_id . ')"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Clock.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000000"/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>';
                                if(Auth()->user()->usertype=='admin'){
                           $btn .= '<a href="' . route('leadadd.edit', ['id' => $row->la_id]) . '" data-toggle="tooltip"  data-id="' . $row->la_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> </a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> </a>';
                        }
                            return $btn;
                    })                    
                    ->rawColumns(['la_status', 'action'])
                    ->make(true);                   
        }          
        $projects = LeadProjectName::pluck('lpn_name', 'lpn_id');
        $sizes = LeadAvailableSize::pluck('las_name', 'las_id');
        $status = LeadStatus::pluck('ls_name', 'ls_id');
        return view('LeadAdd.show', compact('projects', 'sizes','status'));
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



