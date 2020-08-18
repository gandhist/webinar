<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SeminarModel;

class FrontendController extends Controller
{
    function index()
    {
        $data = SeminarModel::where('status','=','published')->orderBy('id','desc')->get();
        if(Auth::check())
        if(Auth::user()->role_id == 2){
            return view('homeUI')->with(compact('data'));
        }
        else {
            return view('home');
        }
        return view('homeUI')->with(compact('data'));
    }
}
