<?php

namespace App\Http\Controllers;

use App\Personal;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\BankModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
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
            ['personals' => Personal::where('deleted_at',NULL)->get(),
            'provinsis' => $provinsi,
            'kotas' => $kota,
            'bu' => $bu] 
        );
    }

    public function create() {
        return view('personal.create',['provinsis' => ProvinsiModel::all(), 
                                        'kotas' => KotaModel::all(),
                                        'bus' => BuModel::all(),
                                        'banks' =>  BankModel::all()]);
    }

    public function store(Request $request) {
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'nik' => 'required|numeric|unique:personal|digits:16',
            'email' => 'required|email|unique:personal|max:100',
            'no_hp' => 'required|numeric|unique:personal|digits_between:9,14',
            'jenis_kelamin' => 'required',Rule::in(['L','P']),
            'instansi' => 'required',
            'jabatan' => 'required|min:3,max:50',
            'alamat' => 'required|min:3|max:100',
            'provinsi' => 'required',
            'kota' => 'required',
            'temp_lahir' => 'required',
            'nomor_rek' => 'numeric|digits_between:4,20',
            'nama_rek' => 'max:50',
            'npwpClean' => 'numeric|digits:15',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_npwp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_ktp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
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
        
        $data->created_by = Auth::id();

        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path
            $resize_image = Image::make($files);
            $resize_image->resize(354, 472)->save($destinationPathTemp.$file);
            // $resize_image->resize(354, 472, function($constraint){
            //     $constraint->aspectRatio();
            // })->save();
            $temp = $destinationPathTemp.$file;
            if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 777, true);
                }
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


        $personal = $data->save();
        return redirect('/personals')->with('pesan',"Personal \"".$request->nama.
        "\" berhasil ditambahkan");
    }


    public function show($id){
        $personal = Personal::where('id', $id)->get();
        $kota = KotaModel::where('id',$personal[0]['kota_id'])->get();
        $prov = ProvinsiModel::where('id',$personal[0]['provinsi_id'])->get();
        $bu = BuModel::where('id',$personal[0]['instansi'])->get();
        $temp_lahir = KotaModel::where('id',$personal[0]['temp_lahir'])->get();
        $bank = BankModel::where('id_bank',$personal[0]['instansi'])->get();
        return view('personal.show',['personal' => $personal, 'kota' => $kota,
         'provinsi' => $prov, 'id' => $id,
         'bu' => $bu, 'bank' => $bank,
         'temp_lahir' => $temp_lahir]);

    }
    
    public function edit($id) {

        $personal = Personal::where('id', $id)->get();
        $prov = ProvinsiModel::all();
        // $provinsi = $prov->pluck('nama', 'id');
        // $provinsi->all();

        $kotas = KotaModel::all();
        // $kota = $cities->pluck('nama', 'id');
        // $kota->all();


        $bu = BuModel::all();

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
        $personal = Personal::where('id', $request->id)->get();
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email|max:100',
            'no_hp' => 'required|numeric|digits_between:9,14',
            'jenis_kelamin' => 'required',Rule::in(['L','P']),
            'instansi' => 'required',
            'jabatan' => 'required|min:3,max:50',
            'alamat' => 'required|min:3|max:100',
            'provinsi' => 'required',
            'kota' => 'required',
            'temp_lahir' => 'required',
            'nomor_rek' => 'numeric|digits_between:4,20',
            'nama_rek' => 'max:50',
            'npwpClean' => 'numeric|digits:15',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_npwp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            'lampiran_ktp' => 'mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // simpan data peserta
        $data = Personal::find($request->id);
        $data->nama = $request->nama;
        if($request->nik != $personal[0]['nik']){
            $request->validate([
                'nik' => 'required|numeric|unique:personal|digits:16',
            ]);
            $data->nik = $request->nik;
        }
        if($request->email != $personal[0]['email']){
            $request->validate([
                'email' => 'required|email|unique:personal|max:100',
            ]);
            $data->email = $request->email;
        }
        if($request->no_hp != $personal[0]['no_hp']){
            $request->validate([
                'no_hp' => 'required|numeric|unique:no_hp|digits_between:9,14',
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
        
        $data->created_by = Auth::id();

        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/foto/personal/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path
            $resize_image = Image::make($files);
            $resize_image->resize(354, 472)->save($destinationPathTemp.$file);
            // $resize_image->resize(354, 472, function($constraint){
            //     $constraint->aspectRatio();
            // })->save();
            $temp = $destinationPathTemp.$file;
            if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 777, true);
                }
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


        $data->updated_at = Carbon::now();
        $data->updated_by = Auth::id();
        $data->save();

        $personal = $data->save();
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
