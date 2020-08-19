<?php

namespace App\Http\Controllers;

use App\Peserta;
use App\ProvinsiModel;
use App\KotaModel;
use App\PesertaSeminar;
use App\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
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

        $seminar = Seminar::all();
        $detailseminar = PesertaSeminar::where('id_peserta','=',$id)->get();
        $jumlahdetail = PesertaSeminar::where('id_peserta','=',$id)->count();


        return view('peserta.show',
        ['peserta' => $peserta,
        'kota' => $kota,
        'provinsi' => $prov,
        'id' => $id])
        ->with(compact('seminar','peserta','detailseminar','jumlahdetail'));

    }

    public function edit($id) {
        $peserta = Peserta::where('id', $id)->get();
        return view('peserta.edit',['id'=>$id, 'peserta'=>$peserta,
        'provinsis' => ProvinsiModel::all(),
        'kotas' => KotaModel::where('provinsi_id',$peserta[0]['provinsi'])->get()]);

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
                'email' => 'required|email|unique:srtf_peserta',
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
                    $destinationPath = 'uploads/peserta/'.$dir_name; // upload path
                    if (!is_dir($destinationPath)) {
                        File::makeDirectory($destinationPath, $mode = 0777, true, true);
                    }
                    $file = "foto_".$dir_name.Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $destinationFile = $destinationPath."/".$file;
                    $destinationPathTemp = 'uploads/tmp/'; // upload path temp
                    $resize_image = Image::make($files);
                    $resize_image->resize(354, 472)->save(public_path($destinationPathTemp.$file));
                    $temp = $destinationPathTemp.$file;
                    rename($temp, $destinationFile);
                    // $data['foto'] = $destinationPath.'/'.$file;
                    $data['foto'] = $dir_name.'/'.$file;
                }
            }
        } else {
            $data->foto = $data->foto;
        }


        $request->validate([
            'nama' => 'required|min:3|max:100|regex:/^[a-zA-Z\s\-\.\,]+$/',
            'no_hp' => 'required|numeric',
            'pekerjaan' => 'required|min:3|max:100',
            'instansi' => 'required|min:3|max:100',
            // 'foto' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required|min:3|max:100',
            'provinsi' => 'required',
            'kota' => 'required',
            'tgl_lahir' => 'required',
        ],[
            'nama.required' => 'Mohon isi Nama Peserta',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 100 karakter',
            'no_hp.required' =>  'Mohon isi Nomor Telepon',
            'no_hp.numeric' => 'Mohon hanya mengisi dengan angka',
            'pekerjaan.required' => 'Mohon isi Pekerjaan',
            'pekerjaan.min' => 'Pekerjaan minimal 3 karakter',
            'pekerjaan.max' => 'Pekerjaan maksimal 100 karakter',
            'instansi.required' => 'Mohon isi Instansi',
            'instansi.min' => 'Instansi minimal 3 karakter',
            'instansi.max' => 'Instansi maksimal 100 karakter',
            'foto.image' => 'Mohon isi Foto dengan format yang valid',
            'foto.mimes' => 'Mohon isi Foto dengan format yang valid',
            'foto.max' => 'Ukuran Foto maksimal 2MB',
            'alamat.required' => 'Mohon isi Alamat Peserta',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'provinsi.required' => 'Mohon isi Provinsi',
            'kota.required' => 'Mohon isi Kota',
            'tgl_lahir.required' => 'Mohon isi Tanggal Lahir',

        ]);
        if($request->email != $data->email) {
            $request->validate([
                'email' => 'required|email|unique:srtf_peserta',
            ], [
                'email.required' => 'Mohon isi Email',
                'email.email' => 'Mohon isi format email yang valid',
                'email.unique' => 'Email sudah digunakan peserta lain',
            ]);
            $data->email = $request->email;
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
