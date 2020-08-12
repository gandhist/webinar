<?php

namespace App\Http\Controllers;

use App\Personal;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\BankModel;
use App\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use File;
use DB;

class PersonalController extends Controller
{
    //
    public function index() {
        $prov = ProvinsiModel::all();
        $provinsi = $prov->pluck('nama', 'id');
        $provinsi->all();

        $cities = KotaModel::all();
        $kota = $cities->pluck('nama', 'id');
        $kota->all();

        $bus = BuModel::all();
        $bu = $bus->pluck('nama_bu', 'id');
        $bu->all();

        return view('personal.index',
            ['personals' => Personal::where('is_activated','1')->get(),
            'provinsis' => $provinsi,
            'kotas' => $kota,
            'bu' => $bu]
        );
    }

    public function create() {
        return view('personal.create',['provinsis' => ProvinsiModel::all(),
                                        'kotas' => KotaModel::all(),
                                        'bus' => BuModel::where('deleted_at',NULL)->get(),
                                        'banks' =>  BankModel::all()]);
    }

    public function store(Request $request) {
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);
        $request->validate([
            'nama' => 'required|min:3|max:100',
            'nik' => 'required|numeric|unique:personal|digits:16',
            'email' => 'required|email|unique:personal',
            'no_hp' => 'required|numeric|unique:personal|digits_between:9,14',
            'jenis_kelamin' => 'required',Rule::in(['L','P']),
            'instansi' => 'required',
            'jabatan' => 'required|min:3,max:100',
            'alamat' => 'required|min:3|max:100',
            'provinsi' => 'required',
            'kota' => 'required',
            'temp_lahir' => 'required',
            'no_rek' => 'sometimes|nullable|numeric|digits_between:4,20',
            'bank_id' => 'required_with:no_rek',
            'nama_rek' => 'sometimes|nullable|required_with:no_rek|min:3|max:50',
            'npwpClean' => 'sometimes|nullable|numeric|digits:15',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_npwp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_ktp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'reff_p' => 'sometimes|nullable|min:3|max:100',
        ],[
            'nama.required' => 'Mohon isi Nama',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 100 karakter',
            'nik.required' => 'Mohon isi NIK',
            'nik.numeric' => 'Mohon isi NIK dengan format yang valid',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.digits' => 'Mohon isi NIK dengan format yang valid',
            'nik.gt' => 'Mohon isi NIK dengan format yang valid',
            'email.required' => 'Mohon isi Email',
            'email.email' => 'Mohon isi Email dengan format yang valid',
            // 'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Mohon isi Nomor Telepon',
            'no_hp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.unique' => 'Nomor Telepon sudah terdaftar',
            'no_hp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'jenis_kelamin.required' => 'Mohon isi Jenis Kelamin',
            'instansi.required' => 'Mohon isi Instansi',
            'jabatan.required' => 'Mohon isi Jabatan',
            'jabatan.min' => 'Jabatan minimal 3 karakter',
            'jabatan.max' => 'Jabatan maksimal 100 karakter',
            'alamat.required' => 'Mohon isi Alamat',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'provinsi.required' => 'Mohon isi Provinsi',
            'kota.required' => 'Mohon isi Kota',
            'temp_lahir.required' => 'Mohon isi Tempat Lahir',
            'no_rek.numeric' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'no_rek.digits_between' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'no_rek.gt' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'bank_id.required_with' => 'Mohon lengkapi Bank',
            'nama_rek.required_with' => 'Mohon lengkapi Nama pada Rekening',
            'nama_rek.min' => 'Nama pada Rekening minimal 3 karakter',
            'nama_rek.max' => 'Nama pada Rekening maksimal 100 karakter',
            'npwpClean.numeric' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.digits' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.gt' => 'Mohon masukkan NPWP dengan format yang valid',
            'foto.required' => 'Mohon isi Foto (3x4)',
            'foto.image' => 'Mohon masukkan Foto dengan format yang valid',
            'foto.mimes' => 'Mohon masukkan Foto dengan format yang valid',
            'foto.max' => 'Foto maksimal berukuran 2MB',
            'lampiran_npwp.mimes' => 'Mohon masukkan Lampiran NPWP dengan format yang valid (gambar / PDF)',
            'lampiran_npwp.max' => 'Lampiran NPWP maksimal berukuran 2MB',
            'lampiran_ktp.mimes' => 'Mohon masukkan Lampiran KTP dengan format yang valid (gambar / PDF)',
            'lampiran_ktp.max' => 'Lampiran KTP maksimal berukuran 2MB',
            'reff_p.min' => 'Referensi Pendaftaran minimal 3 karakter',
            'reff_p.max' => 'Referensi Pendaftaran maksimal 100 karakter',
        ]);

        // simpan data peserta
        $data = new Personal;
        $data->nama = $request->nama;
        $data->nik = $request->nik;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->instansi = $request->instansi;
        $data->jabatan = $request->jabatan;
        $data->alamat = $request->alamat;
        $data->provinsi_id = $request->provinsi;
        $data->kota_id = $request->kota;
        $data->temp_lahir = $request->temp_lahir;
        $data->tgl_lahir = Carbon::parse($request->tgl_lahir);
        $data->no_rek = $request->no_rek;
        $data->id_bank = $request->bank_id;
        $data->nama_rek = $request->nama_rek;
        $data->npwp =  $request->npwp;
        $data->reff_p = $request->reff_p;
        $data->is_activated = '1';
        $data->is_pimpinan = '0';

        $data->created_by = Auth::id();


        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);

        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            if (!is_dir($destinationPath)) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path
            $resize_image = Image::make($files);
            $resize_image->resize(354, 472)->save(public_path($destinationPathTemp.$file));
            // $resize_image->resize(354, 472, function($constraint){
            //     $constraint->aspectRatio();
            // })->save();
            $temp = $destinationPathTemp.$file;
            rename($temp, $destinationFile );
            $data->lampiran_foto = $destinationFile;
        }

        if ($files = $request->file('lampiran_ktp')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_ktp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->lampiran_ktp = $destinationPath."/".$file;
        }

        if ($files = $request->file('lampiran_npwp')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_npwp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->lampiran_npwp = $destinationPath."/".$file;
        }

        $data->save();

        $peserta = new Peserta;

        $peserta->id_personal = $data->id;
        $peserta->nama = $request->nama;
        $peserta->email = $request->email;
        $peserta->no_hp = $request->no_hp;
        $peserta->instansi = $request->instansi;
        $peserta->pekerjaan = $request->jabatan;
        $peserta->alamat = $request->alamat;
        $peserta->provinsi = $request->provinsi;
        $peserta->kota = $request->kota;
        $peserta->tgl_lahir = Carbon::parse($request->tgl_lahir);
        $peserta->created_by = Auth::id();

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
            $peserta->foto = $dir_name."/".$file;
        }

        $peserta->save();

        return redirect('/personals')->with('pesan',"Personal \"".$request->nama.
        "\" berhasil ditambahkan");


    }


    public function show($id){
        $personal = Personal::find($id);
        $kota = KotaModel::find($personal->kota_id);
        $prov = ProvinsiModel::find($personal->provinsi_id);
        $bu = BuModel::find($personal->instansi);
        $temp_lahir = KotaModel::find($personal->temp_lahir);
        $bank = BankModel::where('id_bank',$personal->id_bank)->first();
        // dd($personal);
        return view('personal.show',['personal' => $personal, 'kota' => $kota,
         'provinsi' => $prov, 'id' => $id,
         'bu' => $bu, 'bank' => $bank,
         'temp_lahir' => $temp_lahir]);

    }

    public function edit($id) {

        $personal = Personal::where('id', $id)->first();
        $prov = ProvinsiModel::all();
        // $provinsi = $prov->pluck('nama', 'id');
        // $provinsi->all();

        $kotas = KotaModel::all();
        // $kota = $cities->pluck('nama', 'id');
        // $kota->all();


        $bu = BuModel::where('deleted_at',NULL)->get();

        $banks = BankModel::all();
        // $banks = $banks->pluck('Nama_Bank', 'id_bank');
        // $banks->all();

        return view('personal.edit',['personal'=>$personal,
        'provinsis' => $prov,
        'kotas' => $kotas,
        'bus' => $bu,
        'banks' => $banks,
        'id' => $id]);

    }

    public function update(Request $request) {
        $personal = Personal::where('id', $request->id)->first();
        // dd($personal);
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);
        $request->validate([
            'nama' => 'required|min:3|max:100',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email|max:100',
            'no_hp' => 'required|numeric|digits_between:9,14',
            'jenis_kelamin' => 'required',Rule::in(['L','P']),
            'instansi' => 'required',
            'jabatan' => 'required|min:3,max:100',
            'alamat' => 'required|min:3|max:100',
            'provinsi' => 'required',
            'kota' => 'required',
            'temp_lahir' => 'required',
            'no_rek' => 'sometimes|nullable|numeric|digits_between:4,20',
            'bank_id' => 'required_with:no_rek',
            'nama_rek' => 'sometimes|nullable|required_with:no_rek|min:3|max:100',
            'npwpClean' => 'sometimes|nullable|numeric|digits:15',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_npwp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_ktp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'reff_p' => 'sometimes|nullable|min:3|max:100',
        ],[
            'nama.required' => 'Mohon isi Nama',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 100 karakter',
            'nik.required' => 'Mohon isi NIK',
            'nik.numeric' => 'Mohon isi NIK dengan format yang valid',
            'nik.digits' => 'Mohon isi NIK dengan format yang valid',
            'nik.gt' => 'Mohon isi NIK dengan format yang valid',
            'email.required' => 'Mohon isi Email',
            'email.email' => 'Mohon isi Email dengan format yang valid',
            'email.max' => 'Email maksimal 100 karakter',
            'no_hp.required' => 'Mohon isi Nomor Telepon',
            'no_hp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'jenis_kelamin.required' => 'Mohon isi Jenis Kelamin',
            'instansi.required' => 'Mohon isi Instansi',
            'jabatan.required' => 'Mohon isi Jabatan',
            'jabatan.min' => 'Jabatan minimal 3 karakter',
            'jabatan.max' => 'Jabatan maksimal 100 karakter',
            'alamat.required' => 'Mohon isi Alamat',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'provinsi.required' => 'Mohon isi Provinsi',
            'kota.required' => 'Mohon isi Kota',
            'temp_lahir.required' => 'Mohon isi Tempat Lahir',
            'no_rek.numeric' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'no_rek.digits_between' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'no_rek.gt' => 'Mohon isi Nomor Rekening dengan format yang valid',
            'bank_id.required_with' => 'Mohon lengkapi Bank',
            'nama_rek.required_with' => 'Mohon lengkapi Nama pada Rekening',
            'nama_rek.min' => 'Nama pada Rekening minimal 3 karakter',
            'nama_rek.max' => 'Nama pada Rekening maksimal 100 karakter',
            'npwpClean.numeric' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.digits' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.gt' => 'Mohon masukkan NPWP dengan format yang valid',
            'foto.image' => 'Mohon masukkan Foto dengan format yang valid',
            'foto.mimes' => 'Mohon masukkan Foto dengan format yang valid',
            'foto.max' => 'Foto maksimal berukuran 2MB',
            'lampiran_npwp.mimes' => 'Mohon masukkan Lampiran NPWP dengan format yang valid (gambar / PDF)',
            'lampiran_npwp.max' => 'Lampiran NPWP maksimal berukuran 2MB',
            'lampiran_ktp.mimes' => 'Mohon masukkan Lampiran KTP dengan format yang valid (gambar / PDF)',
            'lampiran_ktp.max' => 'Lampiran KTP maksimal berukuran 2MB',
            'reff_p.min' => 'Referensi Pendaftaran minimal 3 karakter',
            'reff_p.max' => 'Referensi Pendaftaran maksimal 100 karakter',
        ]);

        // simpan data peserta
        $data = Personal::find($request->id);
        $data->nama = $request->nama;
        // dd($data->nama);
        if($request->nik != $personal->nik){
            $request->validate([
                'nik' => 'required|numeric|unique:personal|digits:16',
            ], [
                'nik.required' => 'Mohon isi NIK',
                'nik.numeric' => 'Mohon isi NIK dengan format yang valid',
                'nik.unique' => 'NIK sudah terdaftar',
                'nik.digits' => 'Mohon isi NIK dengan format yang valid',
                'nik.gt' => 'Mohon isi NIK dengan format yang valid',
            ]);
            $data->nik = $request->nik;
        }
        if($request->email != $personal->email){
            $request->validate([
                'email' => 'required|email|unique:personal',
            ], [
                'email.required' => 'Mohon isi Email',
                'email.email' => 'Mohon isi Email dengan format yang valid',
                // 'email.max' => 'Email maksimal 100 karakter',
                'email.unique' => 'Email sudah terdaftar',
            ]);
            $data->email = $request->email;
        }
        if($request->no_hp != $personal->no_hp){
            $request->validate([
                'no_hp' => 'required|numeric|unique:personal|digits_between:9,14',
            ],[
                'no_hp.required' => 'Mohon isi Nomor Telepon',
                'no_hp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'no_hp.unique' => 'Nomor Telepon sudah terdaftar',
                'no_hp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'no_hp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            ]);
            $data->no_hp = $request->no_hp;
        }


        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->instansi = $request->instansi;
        $data->jabatan = $request->jabatan;
        $data->alamat = $request->alamat;
        $data->provinsi_id = $request->provinsi;
        $data->kota_id = $request->kota;
        $data->temp_lahir = $request->temp_lahir;
        $data->tgl_lahir = Carbon::parse($request->tgl_lahir);
        $data->no_rek = $request->no_rek;
        $data->id_bank = $request->bank_id;
        $data->nama_rek = $request->nama_rek;
        $data->npwp =  $request->npwp;
        $data->reff_p = $request->reff_p;

        $data->updated_by = Auth::id();
        $data->updated_at = Carbon::now()->toDateTimeString();

        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);

        if ($files = $request->file('foto')) {
            $lampiran_foto_lama = $data->lampiran_foto;

            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            if (!is_dir($destinationPath)) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory($destinationPath, $mode = 0777, true, true);
                }

            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path

            $resize_image = Image::make($files);
            $resize_image->resize(354, 472)->save(public_path($destinationPathTemp.$file));
            // $resize_image->resize(354, 472, function($constraint){
            //     $constraint->aspectRatio();
            // })->save();

            $temp = $destinationPathTemp.$file;
            rename($temp, $destinationFile );

            $data->lampiran_foto = $destinationFile;
            // if (file_exists(public_path()."/".$data->lampiran_foto) && file_exists(public_path()."/".$lampiran_foto_lama) && $lampiran_foto_lama != null) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_foto_lama);
            // }
        }

        if ($files = $request->file('lampiran_ktp')) {
            $lampiran_ktp_lama = $data->lampiran_ktp;
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_ktp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->lampiran_ktp = $destinationPath."/".$file;
            // if (file_exists(public_path()."/".$data->lampiran_ktp) && file_exists(public_path()."/".$lampiran_ktp_lama) && $lampiran_ktp_lama != null) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_ktp_lama);
            // }

        }

        if ($files = $request->file('lampiran_npwp')) {
            $lampiran_npwp_lama = $data->lampiran_npwp;
            // dd(public_path().$lampiran_npwp_lama);
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_npwp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->lampiran_npwp = $destinationPath."/".$file;
            // if (file_exists(public_path()."/".$data->lampiran_npwp) && file_exists(public_path()."/".$lampiran_npwp_lama) && $lampiran_npwp_lama != null) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_npwp_lama);
            // }
        }


        $data->updated_at = Carbon::now();
        $data->updated_by = Auth::id();

        $peserta = Peserta::where('id_personal',$request->id)->first();
        $peserta->id_personal = $request->id;
        $peserta->nama = $request->nama;
        $peserta->email = $request->email;
        $peserta->no_hp = $request->no_hp;
        $peserta->instansi = $request->instansi;
        $peserta->pekerjaan = $request->jabatan;
        $peserta->alamat = $request->alamat;
        $peserta->provinsi = $request->provinsi;
        $peserta->kota = $request->kota;
        $peserta->tgl_lahir = Carbon::parse($request->tgl_lahir);
        $peserta->updated_by = Auth::id();
        $peserta->updated_at = Carbon::now();

        if($data->is_pimpinan == '1'){
            $instansi = BuModel::where('id_personal_pimp',$request->id)->first();
            $instansi->nama_pimp = $request->nama;
            $instansi->jab_pimp = $request->jabatan;
            $instansi->hp_pimp = $request->no_hp;
            $instansi->email_pimp = $request->email;

            $instansi->save();
        }
        $peserta->save();
        $data->save();

        $instansi = $data->save();
        return redirect('/personals')->with('pesan',"Personal \"".$request->nama.
        "\" berhasil diubah");
    }

    public function destroy(Request $request) {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        Personal::whereIn('id', $idData)->update($user_data);
        return redirect('/personals')
        ->with('pesan',"Berhasil menghapus personal");
    }

    public function getKota($id) {
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }

}
