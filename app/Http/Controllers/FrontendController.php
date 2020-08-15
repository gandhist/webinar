<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function index()
    {
        if(Auth::check())
        if(Auth::user()->role_id == 2){
            // return redirect(url('infoseminar'));
            return view('homeUI');
        }
        else {
            return view('home');
        }
        return view('homeUI');
    }
}
