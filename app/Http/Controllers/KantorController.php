<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KantorModel;

class KantorController extends Controller
{
    //
    public function index() {
        $kantor = KantorModel::all();
        return view('kantor.index')->with(compact('kantor'));
    }

    public function create() {
        //
        return view('kantor.create');
    }
}
