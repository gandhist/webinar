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
        $kantor = KantorModel::orderBy('id','asc')->groupBy('nama_kantor')->get();
        $idlevel = KantorModel::select('level')->groupBy('level')->whereNotNull('level')->get()->toArray();
        $level = LevelModel::whereIn('id',$idlevel)->get();
        $idprop = KantorModel::select('prop')->groupBy('prop')->whereNotNull('prop')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$idprop)->get();
        $kota = KotaModel::where('id','=','~')->get();
        $data = KantorModel::orderBy('id','asc')->get();
        return view('kantor.index')->with(compact('data','prov','kota','level','kantor'));
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
    public function edit($id) {
        $data = KantorModel::find($id);
        $prop = ProvinsiModel::all();
        $kota = KotaModel::all();
        $kotapil = KotaModel::where('provinsi_id','=',$data->prop)->get();
        $level = LevelModel::all();
        $levelatas = KantorModel::where('level','=',$data->level-1)->get();
        return view('kantor.edit')->with(compact('prop','kota','level','data','kotapil','levelatas'));
    }
    public function update(Request $request, $id) {

        // $old = KantorModel::find($id);
        // $olddata['id_kantor'] = $old->id;
        // $olddata['nama_kantor'] = $old->nama_kantor;
        // $olddata['nama_singkat'] = $old->nama_singkat;
        // $olddata['level'] = $old->level;
        // $olddata['prop'] = $old->prop;
        // $olddata['kota'] = $old->kota;
        // $olddata['alamat'] = $old->alamat;
        // $olddata['no_tlp'] = $old->no_tlp;
        // $olddata['email'] = $old->email;
        // $olddata['web'] = $old->web;
        // $olddata['instansi_reff'] = $old->instansi_reff;
        // $olddata['nama_pimp'] = $old->nama_pimp;
        // $olddata['jab_pimp'] = $old->jab_pimp;
        // $olddata['hp_pimp'] = $old->hp_pimp;
        // $olddata['email_pimp'] = $old->email_pimp;
        // $olddata['kontak_p'] = $old->kontak_p;
        // $olddata['no_kontak_p'] = $old->no_kontak_p;
        // $olddata['jab_kontak_p'] = $old->jab_kontak_p;
        // $olddata['email_kontak_p'] = $old->email_kontak_p;
        // $olddata['keterangan'] = $old->keterangan;
        // $olddata['updated_by'] = Auth::id();
        // $olddata['updated_at'] = Carbon::now()->toDateTimeString();

        $request->validate([
            'nama_kantor' => 'required',
            'nama_singkat' => 'required',
            // 'level' => 'required',
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
        // $data['level'] = $request->level;
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
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        // Update Ke table Kantor
        $update = KantorModel::find($id)->update($data);

        // Insert ke table log kantor
        // LogKantor::create($olddata);

        return redirect('kantor')->with('message', 'Data berhasil dirubah');
    }
    public function destroy(Request $request) {

        $idData = explode(',', $request->idHapusData);
        // $old = Kantor::find($idData);

        // foreach ($old as $old) {

        //     $olddata['id_kantor'] = $old->id;
        //     $olddata['nama_kantor'] = $old->nama_kantor;
        //     $olddata['nama_singkat'] = $old->nama_singkat;
        //     $olddata['level'] = $old->level;
        //     $olddata['prop'] = $old->prop;
        //     $olddata['kota'] = $old->kota;
        //     $olddata['alamat'] = $old->alamat;
        //     $olddata['no_tlp'] = $old->no_tlp;
        //     $olddata['email'] = $old->email;
        //     $olddata['web'] = $old->web;
        //     $olddata['instansi_reff'] = $old->instansi_reff;
        //     $olddata['nama_pimp'] = $old->nama_pimp;
        //     $olddata['jab_pimp'] = $old->jab_pimp;
        //     $olddata['hp_pimp'] = $old->hp_pimp;
        //     $olddata['email_pimp'] = $old->email_pimp;
        //     $olddata['kontak_p'] = $old->kontak_p;
        //     $olddata['no_kontak_p'] = $old->no_kontak_p;
        //     $olddata['jab_kontak_p'] = $old->jab_kontak_p;
        //     $olddata['email_kontak_p'] = $old->email_kontak_p;
        //     $olddata['keterangan'] = $old->keterangan;
        //     $olddata['deleted_by'] = Auth::id();
        //     $olddata['deleted_at'] = Carbon::now()->toDateTimeString();
        // // Insert ke table log badan usaha
        // LogKantor::create($olddata);
        // }

        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        KantorModel::whereIn('id', $idData)->update($user_data);
        return redirect('kantor')->with('message', 'Data berhasil dihapus');
    }

    public function changelevelatas(Request $request) {
        return $data = KantorModel::where('level','=',$request->id_level_k-1)->get(['id','nama_kantor as text']);
    }


    public function filter(Request $request)
    {
        $idlevel = KantorModel::select('level')->groupBy('level')->whereNull('deleted_at')->get()->toArray();
        $level = LevelModel::whereIn('id',$idlevel)->get();
        $idprop = KantorModel::select('prop')->groupBy('prop')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$idprop)->get();

        $kantor = KantorModel::orderBy('id','asc')->groupBy('nama_kantor')->get();
        $data = KantorModel::orderBy('id','asc');

        if (isset($request->f_level)){
            $data->where('level', '=', $request->f_level);
        }

        if (isset($request->f_provinsi)){
            $data->where('prop', '=', $request->f_provinsi);
            $idkota = KantorModel::select('kota')->groupBy('kota')->get()->toArray();
            $kota = KotaModel::whereIn('id',$idkota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = KotaModel::where('id','=','~')->get();
        }

        if (isset($request->f_kantor)){
            $data->where('nama_singkat', '=', $request->f_kantor);
        }

        if (isset($request->f_kota)){
            $data->where('kota', '=', $request->f_kota);
        }

        $data->get();
        $data = $data->get();

        return view('kantor.index')->with(compact('data','prov','kota','level','kantor'));

        // dd($request->f_naker_prov);
    }
}
