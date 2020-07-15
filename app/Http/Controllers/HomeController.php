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
        return view('home');
        return view('sert.dashboard')->with(compact('data'));
    }
}
