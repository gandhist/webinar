<?php

namespace App\Http\Controllers;

use App\Peserta;
use App\ProvinsiModel;
use App\KotaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;


class PesertaController extends Controller
{
    //
    public function index() {
        return view('peserta.index',
            ['pesertas' => Peserta::where('deleted_at',NULL)->get(),
            'provinsis' => ProvinsiModel::all(),
            'kotas' => KotaModel::all()]);
    }

    public function show($id){
        $peserta = Peserta::where('id', $id)->get();
        if($peserta[0]['kota'] == NULL){
            $kota[0]['nama'] ="";
        } else {
            $kota = KotaModel::where('id',$peserta[0]['kota'])->get();
        }
        if($peserta[0]['provinsi'] == NULL){
            $prov[0]['nama'] ="";
        } else {
            $prov = ProvinsiModel::where('id',$peserta[0]['provinsi'])->get();
        }
        
        return view('peserta.show',['peserta' => $peserta, 'kota' => $kota, 'provinsi' => $prov, 'id' => $id]);

    }

    public function edit($id) {
        $peserta = Peserta::where('id', $id)->get();
        return view('peserta.edit',['id'=>$id, 'peserta'=>$peserta,
        'provinsis' => ProvinsiModel::all(),
        'kotas' => KotaModel::all()]);

    }
    public function update(Request $request) {
        $data = Peserta::find($request->id);

        // Nama
        if($request->nama != $data->nama && $request->nama != ""){
            $nama = Validator::make($request->all(),[
                'nama' => 'required|min:3|max:50|regex:/^[a-zA-Z ]+$/',
            ]);
            if($nama->fails()){
                $data->nama = $data->nama;
            }else{
                $data->nama = $request->nama;
            }
        } else {
            $data->nama = $request->nama;
        }

        // No Hp
        if($request->no_hp != $data->no_hp && $request->no_hp != ""){
            $no_hp =  Validator::make($request->all(),[
                'no_hp' => 'required|numeric|min:8|max:14',
            ]);
            if($no_hp->fails()){
                $data->no_hp = $data->no_hp;
            }else{
                $data->no_hp = $request->no_hp;
            }
        } else {
            $data->no_hp = $data->no_hp;
        }

        // Email
        if($request->email != $data->email && $request->email != ""){
            $email =  Validator::make($request->all(),[
                'no_hp' => 'required|email|unique:peserta',
            ]);
            if($email->fails()){
                $data->email = $data->email;
            }else{
                $data->email = $request->email;
            }
        } else {
            $data->email = $data->email;
        }

        // Provinsi
        if($request->provinsi != $data->provinsi && $request->provinsi != ""){
            $provinsi =  Validator::make($request->all(),[
                'provinsi' => 'required|numeric',
            ]);
            if($provinsi->fails()){
                $data->provinsi = $data->provinsi;
            }else{
                $data->provinsi = $request->provinsi;
            }
        } else {
            $data->provinsi = $data->provinsi;
        }

        // Kota
        if($request->kota != $data->kota && $request->kota != ""){
            $kota =  Validator::make($request->all(),[
                'kota' => 'required|numeric',
            ]);
            if($kota->fails()){
                $data->kota = $data->kota;
            }else{
                $data->kota = $request->kota;
            }
        } else {
            $data->kota = $data->kota;
        }

        // Alamat
        if($request->alamat != $data->alamat && $request->alamat != ""){
            $alamat =  Validator::make($request->all(),[
                'alamat' => 'required|min:3|max:50',
            ]);
            if($alamat->fails()){
                $data->alamat = $data->alamat;
            }else{
                $data->alamat = $request->alamat;
            }
        } else {
            $data->alamat = $data->alamat;
        }

        // Tanggal Lahir
        if(Carbon::parse($request->tgl_lahir) != Carbon::parse($data->tgl_lahir) && $request->alamat != ""){
            $tgl_lahir =  Validator::make($request->all(),[
                'tgl_lahir' => 'required',
            ]);
            if($tgl_lahir->fails()){
                $data->tgl_lahir = $data->tgl_lahir;
            }else{
                $data->tgl_lahir = Carbon::parse($request->tgl_lahir);
            }
        } else {
            $data->tgl_lahir = $data->tgl_lahir;
        }


        // Pekerjaan
        if($request->pekerjaan != $data->pekerjaan && $request->pekerjaan != ""){
            $pekerjaan = Validator::make($request->all(),[
                'pekerjaan' => 'required|min:3|max:50',
            ]);
            if($pekerjaan->fails()){
                $data->pekerjaan = $data->pekerjaan;
            }else{
                $data->pekerjaan = $request->pekerjaan;
            }
        } else {
            $data->pekerjaan = $data->pekerjaan;
        }


        // Instansi
        if($request->instansi != $data->instansi && $request->instansi != ""){
            $instansi = Validator::make($request->all(),[
                'instansi' => 'required|min:3|max:50',
            ]);
            if($instansi->fails()){
                $data->instansi = $data->instansi;
            }else{
                $data->instansi = $request->instansi;
            }
        } else {
            $data->instansi = $data->instansi;
        }


        // Instansi
        if($request->foto != ""){
            $foto = Validator::make($request->all(),[
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if($foto->fails()){
                $data->foto = $data->foto;
            }else{
                // handle upload Foto
                $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
                if ($files = $request->file('foto')) {
                    $destinationPath = 'uploads/foto/peserta/'.$dir_name; // upload path
                    $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $data->foto = $file;
                }
            }
        } else {
            $data->foto = $data->foto;
        }


        $request->validate([
            'nama' => 'required|min:3|max:50|regex:/^[a-zA-Z ]+$/',
            'no_hp' => 'required|numeric',
            'pekerjaan' => 'required|min:3|max:50',
            'instansi' => 'required|min:3|max:50',
            // 'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required|min:3|max:50',
            'provinsi' => 'required',
            'kota' => 'required',
            'tgl_lahir' => 'required',
        ]);
        if($request->email != $data->email) {
            $request->validate([
                'email' => 'required|email|unique:peserta',
            ]);
        }
        $data->updated_at = Carbon::now();
        $data->updated_by = Auth::id();
        $data->save();
        return redirect('/pesertas')->with('pesan', 'Data '.$request->nama.' Berhasil diubah');
    }
    public function getKota($id) {
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }
}
