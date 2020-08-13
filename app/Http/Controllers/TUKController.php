<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TUKModel;

class TUKController extends Controller
{
    //
    public function index() {
        $tuk = TUKModel::all();
        return view('tuk.index')->with(compact('tuk'));
    }
}
