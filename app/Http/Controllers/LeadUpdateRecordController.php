<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LeadUpdateRecordController;

use App\Models\LeadUpdateRecord;
use DataTables;
use Illuminate\Http\JsonResponse;

class LeadUpdateRecordController extends Controller
{

   public function index(Request $request)
    {
        $dataId = $request->input('dataId');

        if ($request->ajax()) {
            
            $data = LeadUpdateRecord::where('lur_leadadd_id', $dataId)->get();

            
            return response()->json($data); // Return JSON response for AJAX request
        }          

        return response()->json([]); // Return an empty array if not an AJAX request
    }

     public function store(Request $request): JsonResponse
    {
        // dd("aacd");
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
        $formData->lur_user_id = 1;
        $formData->save();

    return response()->json(['success' => true, 'message' => 'Data stored successfully']);
    }
}
