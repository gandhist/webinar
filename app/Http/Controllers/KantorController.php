<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KantorModel;
use App\LevelModel;
use App\ProvinsiModel;
use App\KotaModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function store(Request $request) {

        $request->validate([
            'nama_kantor' => 'required',
            'nama_singkat' => 'required',
            'level' => 'required',
            'alamat'=> 'required',
            'prop'=> 'required',
            'kota'=> 'required',
            'no_tlp'=> 'required',
            'email'=> 'required',
            'kontak_p'=> 'required',
            'no_kontak_p'=> 'required',
            'email_kontak_p'=> 'required'
        ],
        [
        'nama_kantor.required'=>'Nama Kantor harus diisi',
        'nama_singkat.required'=>'Singkatan Nama Kantor harus diisi',
        'level.required'=>'Level Kantor Kantor harus diisi',
        'alamat.required'=>'Alamat harus diisi',
        'prop.required'=>'Provinsi harus diisi',
        'kota.required'=>'Kota harus diisi',
        'no_tlp.required'=>'No Tlp harus diisi',
        'email.required'=>'Email harus diisi',
        'kontak_p.required'=>'Nama Kontak Person harus diisi',
        'no_kontak_p.required'=>'No HP Kontak Person harus diisi',
        'email_kontak_p.required'=>'Email Kontak Person harus diisi'
        ]
        );

        $data['nama_kantor'] = $request->nama_kantor;
        $data['nama_singkat'] = $request->nama_singkat;
        $data['level'] = $request->level;
        $data['level_atas'] = $request->level_atas;
        $data['prop'] = $request->prop;
        $data['kota'] = $request->kota;
        $data['alamat'] = $request->alamat;
        $data['no_tlp'] = $request->no_tlp;
        $data['email'] = $request->email;
        $data['web'] = $request->web;
        $data['instansi_reff'] = $request->instansi_reff;
        $data['nama_pimp'] = $request->nama_pimp;
        $data['jab_pimp'] = $request->jab_pimp;
        $data['hp_pimp'] = $request->hp_pimp;
        $data['email_pimp'] = $request->email_pimp;
        $data['kontak_p'] = $request->kontak_p;
        $data['no_kontak_p'] = $request->no_kontak_p;
        $data['jab_kontak_p'] = $request->jab_kontak_p;
        $data['email_kontak_p'] = $request->email_kontak_p;
        $data['keterangan'] = $request->keterangan;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();

        $simpan = KantorModel::create($data);

        return redirect('kantor')->with('message', 'Data berhasil ditambahkan');

    }

    public function changelevelatas(Request $request) {
        return $data = KantorModel::where('level','=',$request->id_level_k-1)->get(['id','nama_kantor as text']);
    }
}
