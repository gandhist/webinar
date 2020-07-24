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

    public function create() {
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $instansi = BuModel::all();
        return view('seminar.create2')->with(compact('judul','inisiator','provinsi','kota'));
    }
}
