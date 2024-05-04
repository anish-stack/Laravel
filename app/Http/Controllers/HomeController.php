<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use APP\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype =Auth()->user()->usertype;
            // die($usertype);
            if($usertype=='user')
            {
                return view('welcome');
            }

            else if($usertype=='admin')
            {
                return view('welcome');
            }
            else{
                return redirect->back();
            }
        }
    }
}
