<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeminarModel;
use App\InstansiModel;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;

class SeminarController extends Controller
{
    //
    public function index() {
        $seminar = SeminarModel::all();
        return view('seminar.index')->with(compact('seminar'));
    }
}
