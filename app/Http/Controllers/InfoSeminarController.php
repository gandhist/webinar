<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use Carbon\Carbon;

class InfoSeminarController extends Controller
{
    public function index()
    {
        $data = Seminar::where('status','=','published')->get();
        
        return view('infoseminar.index')->with(compact('data'));
    }
    public function detail($id)
    {
        $data = Seminar::find($id);
        return view('infoseminar.detail')->with(compact('data'));
    }
}
