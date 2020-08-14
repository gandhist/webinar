<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TUKModel;
use App\ProvinsiModel;
use App\KotaModel;
use Carbon\Carbon;

class TUKController extends Controller
{
    //
    public function index() {
        $tuk = TUKModel::all();
        $prov = ProvinsiModel::pluck('nama','id');
        $kota = KotaModel::pluck('nama','id');
        return view('tuk.index')->with(compact('tuk','prov','kota'));
    }

    public function create() {
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        return view('tuk.create')->with(compact('provinsi','kota'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_tuk'  => 'required|min:3|max:100',
            'alamat'    => 'required_if:is_online,==,0|min:3|max:100',
            'provinsi'  => 'required_if:is_online,==,0',
            'kota'      => 'required_if:is_online,==,0',
            'pengelola' => 'sometimes|nullable|min:3|max:100',
            'email'     => 'sometimes|nullable|email',
            'no_hp'     => 'sometimes|nullable|',
            'website'   => 'sometimes|nullable|'
        ]);

        $data   = new TUKModel;
        $data->nama_tuk  = $request->nama_tuk       ;
        $data->is_online = $request->is_online        ;
        $data->alamat    = $request->alamat         ;
        $data->prov      = $request->provinsi       ;
        $data->kota      = $request->kota           ;
        $data->pengelola = $request->pengelola      ;
        $data->email     = $request->email          ;
        $data->no_hp     = $request->no_hp          ;
        $data->web       = $request->website        ;

        $data->created_by = Auth::id();

        $data->save();

        return redirect('/tuk')
        ->with('pesan',"Berhasil menambahkan TUK");
    }


    public function edit($id) {
        $tuk = TUKModel::find($id);
        if($tuk->is_online == '0') {
            $provinsi = ProvinsiModel::all();
            $kota = KotaModel::all();
            return view('tuk.edit')->with(compact('tuk','provinsi','kota','id'));
        } else {
            return view('tuk.edit')->with(compact('tuk','id'));
        }
    }

    public function update(Request $request) {
        // dd($request);
        $request->validate([
            'nama_tuk'  => 'required|min:3|max:100',
            'alamat'    => 'required_if:is_online,==,0|min:3|max:100',
            'provinsi'  => 'required_if:is_online,==,0',
            'kota'      => 'required_if:is_online,==,0',
            'pengelola' => 'sometimes|nullable|min:3|max:100',
            'email'     => 'sometimes|nullable|email',
            'no_hp'     => 'sometimes|nullable|',
            'website'   => 'sometimes|nullable|'
        ]);

        $data = TUKModel::find($request->id);
        // dd($request->id);
        $data->nama_tuk  = $request->nama_tuk       ;
        $data->alamat    = $request->alamat         ;
        $data->prov      = $request->provinsi       ;
        $data->kota      = $request->kota           ;
        $data->pengelola = $request->pengelola      ;
        $data->email     = $request->email          ;
        $data->no_hp     = $request->no_hp          ;
        $data->web       = $request->website        ;

        $data->updated_by = Auth::id();

        $data->update();
        return redirect('/tuk')
        ->with('pesan',"Berhasil mengubah TUK");
    }

    public function show($id) {
        $tuk = TUKModel::find($id);

        if($tuk->is_online == '0'){
            $provinsi = ProvinsiModel::find($tuk->prov);
            $kota = KotaModel::find($tuk->kota);
            return view('tuk.detail')->with(compact('tuk','provinsi','kota','id'));
        } else {
            return view('tuk.detail')->with(compact('tuk','id'));
        }
    }

    public function destroy(Request $request) {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        TUKModel::whereIn('id', $idData)->update($user_data);
        return redirect('/tuk')
        ->with('pesan',"Berhasil menghapus TUK");
    }

}
