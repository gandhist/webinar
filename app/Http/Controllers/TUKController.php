<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TUKModel;
use App\ProvinsiModel;
use App\KotaModel;

class TUKController extends Controller
{
    //
    public function index() {
        $tuk = TUKModel::all();
        return view('tuk.index')->with(compact('tuk'));
    }

    public function create() {
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        return view('tuk.create')->with(compact('provinsi','kota'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_tuk'  => 'required|min:3|max:100',
            'alamat'    => 'required|min:3|max:100',
            'provinsi'  => 'required',
            'kota'      => 'required',
            'pengelola' => 'sometimes|nullable|min:3|max:100',
            'email'     => 'sometimes|nullable|email',
            'no_hp'     => 'sometimes|nullable|',
            'website'   => 'sometimes|nullable|'
        ]);

        $data   = new TUKModel;
        $data->nama_tuk  = $request->nama_tuk       ;
        $data->alamat    = $request->alamat         ;
        $data->prov      = $request->provinsi       ;
        $data->kota      = $request->kota           ;
        $data->pengelola = $request->pengelola      ;
        $data->email     = $request->email          ;
        $data->no_hp     = $request->no_hp          ;
        $data->web       = $request->website        ;

        $data->created_by = Auth::id();

        $data->save();
    }
}
