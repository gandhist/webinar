<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KantorModel;
use App\LevelModel;
use App\ProvinsiModel;
use App\KotaModel;

class KantorController extends Controller
{
    //
    public function index() {
        $kantor = KantorModel::all();
        return view('kantor.index')->with(compact('kantor'));
    }

    public function create() {
        //
        $prop = ProvinsiModel::all();
        $kota = KotaModel::all();
        $level = LevelModel::all();
        return view('kantor.create')->with(compact('level', 'prop', 'kota'));
    }
}
