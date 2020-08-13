<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tasks;
use App\Drivers;
use App\Cars;
use App\SertModel;

class HomeController extends Controller
{
    public function index(){
        // handle sementara aja biar user ga kesini 
        if(Auth::user()->role_id == 2){
            return redirect(url('infoseminar'));
        }
        else {
            return view('home');
        }
        return view('sert.dashboard')->with(compact('data'));
    }
}
