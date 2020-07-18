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
        return view('personal.index',
            ['personals' => Personal::all(),
            'provinsis' => ProvinsiModel::all(),
            'kotas' => KotaModel::all()]);
    }
    public function create() {
        return view('personal.create',['provinsis' => ProvinsiModel::all() ]);
    }
    public function store(Request $request) {
        $request->validate([
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
        $data->provinsi = $request->provinsi;
        $data->kota = $request->kota;
        $data->alamat = $request->alamat;
        $data->tgl_lahir = Carbon::parse($request->tgl_lahir);
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        
        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->foto = $file;
        }
        $peserta = $data->save();
        return redirect('/personals')->with('pesan',"Personal \"".$request->nama.
        "\" berhasil ditambahkan");
    }
    public function show($id){
        $personal = Personal::where('id', $id)->get();
        $kota = KotaModel::where('id',$personal[0]['kota'])->get();
        $prov = ProvinsiModel::where('id',$personal[0]['provinsi'])->get();
        return view('personal.show',['personal' => $personal, 'kota' => $kota, 'provinsi' => $prov, 'id' => $id]);

    }
    public function edit($id) {
        $personal = Personal::where('id', $id)->get();
        return view('personal.edit',['id'=>$id, 'personal'=>$personal,
        'provinsis' => ProvinsiModel::all(),
        'kotas' => KotaModel::all()]);

    }
    public function update(Request $request, Personal $personal) {
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'no_hp' => 'required|numeric',
            'email' => 'required|email|unique:personal',
            'pekerjaan' => 'required|min:3|max:50',
            'instansi' => 'required|min:3|max:50',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required|min:3|max:50',
            'provinsi' => 'required',
            'kota' => 'required',
            'tgl_lahir' => 'required',
        ]);
        $data = Personal::find($id);
        $data->updated_at = Carbon::now();
        $data->updated_by = Auth::id();
        $data->update($request->all());
        return redirect('/personals')->with('pesan', 'User berhasil dibuat');
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