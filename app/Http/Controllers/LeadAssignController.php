<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\LeadAssignController;
use App\Models\LeadAdd;
use App\Models\LeadProjectName;
use App\Models\LeadAvailableSize;
use App\Models\LeadSourceType; 
use App\Models\LeadStatus;
use App\Models\User;
use App\Models\LeadAssignment;


class LeadAssignController extends Controller
{



public function assignLead(Request $request)
{
    $leadIds = $request->input('lead_ids');
    $userId = $request->input('user_id');
// dd($leadId[0]+"____"+$userId);
    foreach ($leadIds as $leadId) {
        // Check if lead assignment already exists
        $existingAssignment = LeadAdd::where('la_id', $leadId)->first();

        if ($existingAssignment) {
            // Update existing lead assignment
            $existingAssignment->la_user_id = $userId;
            $existingAssignment->save();
        } else {
            // Create new lead assignment
            LeadAdd::create([
                'la_id' => $leadId,
                'la_user_id' => $userId,
            ]);
        }
    }

    return response()->json(['success' => true]);
}


        public function index(Request $request)
    {    

        if ($request->ajax()) {
           
            $data = LeadAdd::wherenull('la_user_id')->select('lead_adds.*', 'lead_project_names.lpn_name', 'lead_available_sizes.las_name')
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
                    ->addColumn('action', function($row){
                       
                        $btn = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="' . $row->la_id . '" onclick="openModal(this)">Open Modal</button>';                       
                           $btn .= '<a href="' . route('leadadd.edit', ['id' => $row->la_id]) . '" data-toggle="tooltip"  data-id="' . $row->la_id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead"><i class="fa-regular fa-pen-to-square"></i> </a>';
                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->la_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead"><i class="fa-solid fa-trash"></i> </a>';
                            return $btn;
                    })                    
                    ->rawColumns(['la_status', 'action'])
                    ->make(true);                   
        }          
        $projects = LeadProjectName::pluck('lpn_name', 'lpn_id');
        $sizes = LeadAvailableSize::pluck('las_name', 'las_id');
        $status = LeadStatus::pluck('ls_name', 'ls_id');
        $users = User::all();
        return view('Leadassign.show', compact('projects', 'sizes','status','users'));
       
    }
}
