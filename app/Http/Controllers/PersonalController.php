<?php

namespace App\Http\Controllers;

use App\Personal;
use App\ProvinsiModel;
use App\KotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

class PersonalController extends Controller

{
    public function index() {
        return view('personal.index',['personals' => Personal::all()]);
    }
    public function create() {
        return view('personal.create',['provinsis' => ProvinsiModel::all() ]);
    }
    public function store(Request $request) {
        $validateData = $request->validate([
            'nama' => 'required|min:3|max:50',
            'no_hp' => 'required|numeric',
            'email' => 'required|email|unique:personal',
            'pekerjaan' => 'required|min:3|max:50',
            'instansi' => 'required|min:3|max:50',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required|min:3|max:50',
            'provinsi' => 'required',
            'kota' => 'required',
            'tgl_lahir' => 'required'
        ]);
        // simpan data peserta
        $data = new Personal;
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        
        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = "_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->foto = $dir_name.$file;
        }
        $peserta = $data->save();
        return redirect('/personals')->with('pesan',"Personal \"".$request->nama_personal.
        "\" berhasil ditambahkan");
    }
    public function show(Personal $personal){
        return view('personal.show',compact('personal'));
    }
    public function edit(Personal $personal) {
        return view('personal.edit',compact('personal'));
    }
    public function update(Request $request, Personal $personal) {
        $validateData = $request->validate([
        'nama_personal'
        => 'required',
        'nama_dekan'
        => 'required',
        'jumlah_mahasiswa' => 'required|min:10|integer',
        ]);
        $personal->update($validateData);
        
        return redirect('/personals/'.$personal->id)
        ->with('pesan',"Personal $personal->nama_personal berhasil diupdate");
    }
    public function destroy(Personal $personal) {
        $personal->delete();
        
        return redirect('/')
        ->with('pesan',"Personal $personal->nama_personal berhasil dihapus");
    }
    public function getKota($id) {        
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }
}