<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OurTask;
use App\Models\LeadAdd;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller {
    public function tasknotification() {

        $currentDateTime = now()->format( 'Y-m-d H:i:s' );
        // Get the current date and time in the format 'YYYY-MM-DD HH:MM:SS'

        $tasks = OurTask::where( 'ot_remind_dt', '>=', $currentDateTime )
        ->where( 'ot_status', 0 )
        ->get();
        // dd( $tasks );

        // return view( 'heder', compact( 'tasks' ) );
        return response()->json( $tasks );

    }

    public function leadnotification() {

        $currentDateTime = Carbon::now();

        $tasks = LeadAdd::where( 'la_status', 1 )->get();
        return response()->json( $tasks );

    }
}
