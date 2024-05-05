<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LeadUpdateRecordController;
use App\Models\LeadUpdateRecord;
use DataTables;
use Illuminate\Http\JsonResponse;

// use App\Http\Controllers\LeadAddController;
use App\Models\LeadAdd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
// use App\Models\User;

// use App\Models\LeadProjectName;
// use App\Models\LeadAvailableSize;
// use App\Models\LeadSourceType; 
// use App\Models\LeadStatus;

class LeadUpdateRecordController extends Controller
{

   public function index(Request $request)
    {
        $dataId = $request->input('dataId');

        if ($request->ajax()) {
            
            $data = LeadUpdateRecord::with('user')->where('lur_leadadd_id', $dataId)->get();
            // dd($data);
            return response()->json($data); // Return JSON response for AJAX request
        }          

        return response()->json([]); // Return an empty array if not an AJAX request
    }

     public function store(Request $request): JsonResponse
    {
        $user_id = Auth::user()->id;
         $request->validate([
                'remark' => 'required', 
                'status' => 'required', 

                // 'detail' => 'required',
            ],
            [
                'remark.required'=>'The Remark is Required',
                'status.required'=>'The Status is Required'
               
            ]
        );
           
       
        $formData = new LeadUpdateRecord();
        $formData->lur_remark = $request->remark;
        $formData->lur_interest = $request->status;
        $formData->lur_meeting_date = $request->date;
        $formData->lur_leadadd_Id = $request->lead_id;   
        $formData->lur_update_date = NOW();
        $formData->lur_user_id = $user_id;;
        $formData->save();

        // update record in lead add tbale
         $f_dtaa = [
            'la_remark' => $request->remark,     
            'la_last_update' => NOW(),     
            'la_meeting_date' => $request->date
            ]; 
            Leadadd::where('la_id',$request->lead_id)->update($f_dtaa);
         

    return response()->json(['success' => true, 'message' => 'Data stored successfully']);
    }
}



