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
        $pendukung = BuModel::pluck('nama_bu','id');
        return view('seminar.create')->with(compact('inisiator','provinsi','kota','instansi','pendukung'));
    }

    public function store(Request $request) {
        dd($request);
    }

    public function getKota($id) {
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }
}
