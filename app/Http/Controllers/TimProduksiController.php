<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\KantorModel;
use App\BentukBuModel;
use App\BankModel;
use App\JenisUsaha;
use App\GolHargaProd;
use App\LevelTimProduksi;
use App\LevelKantor;
use App\TimProduksi;

use App\Role;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class TimProduksiController extends Controller
{
    //
    public function index($id,Request $request)
    {
        $id_jns_usaha = "all";
        $nama_jenis_usaha = "";

        $timproduksi = TimProduksi::orderBy('id','asc');
        $id_jenis_usaha = TimProduksi::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha');
        $id_bu = TimProduksi::select('pjk3')->groupBy('pjk3')->whereNotNull('pjk3');
        $id_level = TimProduksi::select('level_p')->groupBy('level_p')->whereNotNull('level_p');
        $instansireff = TimProduksi::groupBy('instansi_reff')->whereNotNull('instansi_reff');
        $id_prop = TimProduksi::select('prop_tim')->groupBy('prop_tim')->whereNotNull('prop_tim');
        $data = TimProduksi::orderBy('id','asc');

        if($id!="all"){
            $timproduksi->where('jenis_usaha',$id);
            $id_jenis_usaha->where('jenis_usaha',$id);
            $id_bu->where('jenis_usaha',$id);
            $id_level->where('jenis_usaha',$id);
            $instansireff->where('jenis_usaha',$id);
            $id_prop->where('jenis_usaha',$id);
            $data->where('jenis_usaha',$id);

            $tipeproduksi = JenisUsaha::find($id);
            $id_jns_usaha = $tipeproduksi->id;
            $nama_jenis_usaha = $tipeproduksi->kode_jns_usaha;
        }

        $timproduksi = $timproduksi->get();
        $id_jenis_usaha = $id_jenis_usaha->get()->toArray();
        $id_bu = $id_bu->get()->toArray();
        $id_level = $id_level->get()->toArray();
        $instansireff = $instansireff->get();
        $id_prop = $id_prop->get()->toArray();

        $jenisUsaha = JenisUsaha::whereIn('id',$id_jenis_usaha)->get();
        $badanusaha = BuModel::whereIn('id',$id_bu)->get();
        $leveltimpro = LevelTimProduksi::whereIn('id',$id_level)->get();
        $level = LevelKantor::all();
        $prov = ProvinsiModel::whereIn('id',$id_prop)->get();
        $kantor = KantorModel::orderBy('id','asc')->groupBy('nama_kantor')->get();

        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $data->where('jenis_usaha', '=', $request->f_jenis_usaha);
        }

        if (!$request->f_pjk3===NULL || !$request->f_pjk3==""){
            $data->where('pjk3', '=', $request->f_pjk3);
        }

        if (!$request->f_tim_pro===NULL || !$request->f_tim_pro==""){
            $x = $request->f_tim_pro;
            $data->where(function ($query) use($x) {
                $query->where('id', '=', $x)
                ->orWhere('level_p_atas', '=', $x);
            });
        }

        if (!$request->f_level_tim_pro===NULL || !$request->f_level_tim_pro==""){
            $data->where('level_p', '=', $request->f_level_tim_pro);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $data->where('prop_tim', '=', $request->f_provinsi);

            if($id=="all"){
                $id_kota = TimProduksi::select('kota_tim')->groupBy('kota_tim')->get()->toArray();
            }else{
                $id_kota = TimProduksi::select('kota_tim')->groupBy('kota_tim')->where('jenis_usaha',$id)->get()->toArray();
            }

            $kota = KotaModel::whereIn('id',$id_kota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = KotaModel::where('id','=','~')->get();
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $data->where('kota_tim', '=', $request->f_kota);
        }

        if (!$request->f_instansi_reff===NULL || !$request->f_instansi_reff==""){
            $data->where('instansi_reff', '=', $request->f_instansi_reff);
        }

        $data = $data->get();

        return view('timproduksi.index')->with(compact('data','prov','kota','level','kantor','jenisUsaha','badanusaha','timproduksi','leveltimpro','instansireff','id_jns_usaha','nama_jenis_usaha'));
    }

    public function create()
    {
        $golharga = GolHargaProd::orderBy('kode','asc')->get();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::all();
        $badanusaha = BuModel::all();
        $bentukbu = BentukBuModel::all();
        $leveltimprod = LevelTimProduksi::all();
        $jenisUsaha = JenisUsaha::whereNotIn('id',['4'])->get();
        $bank = BankModel::all();
        return view('timproduksi.create')->with(compact('prov','kota','bentukbu','leveltimprod','jenisUsaha','badanusaha','bank','golharga'));
    }


    public function store(Request $request)
    {

        $request->validate(
            [
                'nama' => 'required',
                'nama_singkat' => 'required',
                // 'bentuk_bu' => 'required',
                'leveltimprod' => 'required',
                // 'id_jenis_usaha' => 'required',
                // 'id_pjk3' => 'required',
                'id_alamat' => 'required',
                'id_prov' => 'required',
                'id_kota' => 'required',
                'id_no_telp' => 'required',
                'id_email' => 'required',

                // 'id_nama_p' => 'required',
                // 'id_hp_p' => 'required',
                'id_nama_kp' => 'required',
                'id_hp_kp' => 'required',

                // 'id_email_p' => 'required',
                'id_email_kp' => 'required',
                // 'id_npwp' => 'required',
                'id_file_npwp' => 'mimes:pdf,jpg,jpeg,png',
                // 'gol_harga' => 'required',

            ],[
                'nama.required' => "Nama tidak boleh kosong",
                'nama_singkat.required' => "Nama Singkat tidak boleh kosong",
                // 'bentuk_bu.required' => "Bentuk BU tidak boleh kosong",
                'leveltimprod.required' => "Level tidak boleh kosong",
                // 'id_jenis_usaha.required' => "Jenis Usaha tidak boleh kosong",
                // 'id_pjk3.required' => "PJK3 tidak boleh kosong",
                'id_alamat.required' => "Alamat tidak boleh kosong",
                'id_prov.required' => "Provinsi tidak boleh kosong",
                'id_kota.required' => "Kota tidak boleh kosong",
                'id_no_telp.required' => "No Tlp tidak boleh kosong",

                // 'id_nama_p.required' => "Nama Pimpinan tidak boleh kosong",
                // 'id_hp_p.required' => "No Hp Pimpinan tidak boleh kosong",
                'id_nama_kp.required' => "Nama Kontak Person tidak boleh kosong",
                'id_hp_kp.required' => "No Hp Kontak Person tidak boleh kosong",

                'id_email.required' => "Email tidak boleh kosong",
                // 'id_email_p.required' => "Email pimpinan tidak boleh kosong",
                'id_email_kp.required' => "Email kontak person tidak boleh kosong",
                // 'id_npwp.required' => "No NPWP tidak boleh kosong",
                // 'id_file_npwp.required' => "File NPWP tidak boleh kosong",
                // 'gol_harga.required' => "Golongan Harga Produksi tidak boleh kosong",
                'id_file_npwp.mimes'=>'Format file tidak sesuai'

            ]);

            $data['pjk3'] = $request->id_pjk3;
            // $data['bentuk_bu'] = $request->bentuk_bu;
            $data['id_bu'] = $request->id_bu;
            $data['jenis_usaha'] = $request->id_jenis_usaha;
            $data['nama_tim_p'] = $request->nama;
            $data['singkat_tim_p'] = $request->nama_singkat;
            $data['level_p'] = $request->leveltimprod;
            $data['level_p_atas'] = $request->timprodatas;
            $data['gol_hrg_p'] = $request->gol_harga;
            $data['prop_tim'] = $request->id_prov;
            $data['kota_tim'] = $request->id_kota;
            $data['alamat'] = $request->id_alamat;
            $data['no_tlp'] = $request->id_no_telp;
            $data['email'] = $request->id_email;
            $data['no_npwp'] = $request->id_npwp;
            $data['instansi_reff'] = $request->id_instansi;
            $data['web'] = $request->id_web;
            $data['nama_pimp'] = $request->id_nama_p;
            $data['jab_pimp'] = $request->id_jab_p;
            $data['hp_pimp'] = $request->id_hp_p;
            $data['email_pimp'] = $request->id_eml_p;
            $data['kontak_p'] = $request->id_nama_kp;
            $data['no_kontak_p'] = $request->id_hp_kp;
            $data['jab_kontak_p'] = $request->id_jab_kp;
            $data['email_kontak_p'] = $request->id_email_kp;
            $data['no_rek'] = $request->id_no_rek;
            $data['nama_rek'] = $request->id_nama_rek;
            $data['id_bank'] = $request->id_bank;
            $data['keterangan'] = $request->id_keterangan;
            $data['created_by'] = Auth::id();
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);

            if ($files = $request->file('id_file_npwp')) {
                $destinationPath = 'uploads/NPWP_Tim_Produksi'; // upload path
                $file = "NPWP_".$dir_name."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $data['file_npwp'] = $destinationPath."/".$file;
            }

            TimProduksi::create($data);

            // Buat User Login
                     $dataUser['username'] = $request->id_email;
                     $dataUser['email'] = $request->id_email;
                     $dataUser['name'] = $request->nama;
                     $id_role = Role::where('name','tim_produksi')->first();
                     $dataUser['role_id'] = $id_role->id;
                     $dataUser['is_active'] = 1;
                     $dataUser['password'] = Hash::make('123456');
                     User::create($dataUser);

            return response()->json([
                'status' => true,
                'icon' => "success",
                'message' => 'Data berhasil ditambahkan!'
            ]);
    }

    public function edit($id)
    {

        $data = TimProduksi::find($id);

        if($data->id_bu==null){
            $badanusaha = BuModel::where('id',$data->id_bu)->get();
        }else{
            $badanusaha = BuModel::all();
        }
        $golharga = GolHargaProd::orderBy('kode','asc')->get();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::where('provinsi_id',$data->prop_tim)->get();
        $pjk3 = BuModel::all();
        $bentukbu = BentukBuModel::all();
        $leveltimprod = LevelTimProduksi::all();
        $levelatas = TimProduksi::where('level_p','=',$data->level_p-1)->get();
        $jenisUsaha = JenisUsaha::all();
        $bank = BankModel::all();
        return view('timproduksi.edit')->with(compact('prov','kota','bentukbu','leveltimprod','jenisUsaha','pjk3','badanusaha','bank','data','golharga','levelatas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nama_singkat' => 'required',
                // 'bentuk_bu' => 'required',
                'leveltimprod' => 'required',
                // 'id_jenis_usaha' => 'required',
                // 'id_pjk3' => 'required',
                'id_alamat' => 'required',
                'id_prov' => 'required',
                'id_kota' => 'required',
                'id_no_telp' => 'required',

                // 'id_nama_p' => 'required',
                // 'id_hp_p' => 'required',
                'id_nama_kp' => 'required',
                'id_hp_kp' => 'required',

                'id_email' => 'required',
                // 'id_email_p' => 'required',
                'id_email_kp' => 'required',
                // 'id_npwp' => 'required',
                'id_file_npwp' => 'mimes:pdf,jpg,jpeg,png',
                // 'gol_harga' => 'required',

            ],[
                'nama.required' => "Nama tidak boleh kosong",
                'nama_singkat.required' => "Nama Singkat tidak boleh kosong",
                // 'bentuk_bu.required' => "Bentuk BU tidak boleh kosong",
                'leveltimprod.required' => "Level tidak boleh kosong",
                // 'id_jenis_usaha.required' => "Jenis Usaha tidak boleh kosong",
                // 'id_pjk3.required' => "PJK3 tidak boleh kosong",
                'id_alamat.required' => "Alamat tidak boleh kosong",
                'id_prov.required' => "Provinsi tidak boleh kosong",
                'id_kota.required' => "Kota tidak boleh kosong",
                'id_no_telp.required' => "No Tlp tidak boleh kosong",

                // 'id_nama_p.required' => "Nama Pimpinan tidak boleh kosong",
                // 'id_hp_p.required' => "No Hp Pimpinan tidak boleh kosong",
                'id_nama_kp.required' => "Nama Kontak Person tidak boleh kosong",
                'id_hp_kp.required' => "No Hp Kontak Person tidak boleh kosong",

                'id_email.required' => "Email tidak boleh kosong",
                // 'id_email_p.required' => "Email pimpinan tidak boleh kosong",
                'id_email_kp.required' => "Email kontak person tidak boleh kosong",
                // 'id_npwp.required' => "No NPWP tidak boleh kosong",
                // 'gol_harga.required' => "Golongan Harga Produksi tidak boleh kosong",
                'id_file_npwp.mimes'=>'Format file tidak sesuai'

            ]);

            $data['pjk3'] = $request->id_pjk3;
            $data['id_bu'] = $request->id_bu;
            $data['jenis_usaha'] = $request->id_jenis_usaha;
            $data['nama_tim_p'] = $request->nama;
            $data['singkat_tim_p'] = $request->nama_singkat;
            $data['level_p'] = $request->leveltimprod;
            $data['level_p_atas'] = $request->timprodatas;
            $data['gol_hrg_p'] = $request->gol_harga;
            $data['prop_tim'] = $request->id_prov;
            $data['kota_tim'] = $request->id_kota;
            $data['alamat'] = $request->id_alamat;
            $data['no_tlp'] = $request->id_no_telp;
            $data['email'] = $request->id_email;
            $data['no_npwp'] = $request->id_npwp;
            $data['instansi_reff'] = $request->id_instansi;
            $data['web'] = $request->id_web;
            $data['nama_pimp'] = $request->id_nama_p;
            $data['jab_pimp'] = $request->id_jab_p;
            $data['hp_pimp'] = $request->id_hp_p;
            $data['email_pimp'] = $request->id_eml_p;
            $data['kontak_p'] = $request->id_nama_kp;
            $data['no_kontak_p'] = $request->id_hp_kp;
            $data['jab_kontak_p'] = $request->id_jab_kp;
            $data['email_kontak_p'] = $request->id_email_kp;
            $data['no_rek'] = $request->id_no_rek;
            $data['nama_rek'] = $request->id_nama_rek;
            $data['id_bank'] = $request->id_bank;
            $data['keterangan'] = $request->id_keterangan;
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);

            if ($files = $request->file('id_file_npwp')) {
                $destinationPath = 'uploads/NPWP_Tim_Produksi'; // upload path
                $file = "NPWP_".$dir_name."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $data['file_npwp'] = $destinationPath."/".$file;
            }

            TimProduksi::find($request->id_tim_prod)->update($data);

            return response()->json([
                'status' => true,
                'icon' => "success",
                'message' => 'Data berhasil diubah!'
            ]);
    }

    public function destroy(Request $request)
    {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        TimProduksi::whereIn('id', $idData)->update($user_data);
        return redirect('timproduksi/all')->with('message', 'Data berhasil dihapus !');
    }


    public function filter(Request $request)
    {
        $instansireff = TimProduksi::groupBy('instansi_reff')->whereNotNull('instansi_reff')->get();
        $timproduksi = TimProduksi::orderBy('id','asc')->get();
        $id_jenis_usaha = TimProduksi::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha')->get()->toArray();
        $jenisUsaha = JenisUsaha::whereIn('id',$id_jenis_usaha)->get();
        $id_bu = TimProduksi::select('pjk3')->groupBy('pjk3')->whereNotNull('pjk3')->get()->toArray();
        $badanusaha = BuModel::whereIn('id',$id_bu)->get();
        $id_level = TimProduksi::select('level_p')->groupBy('level_p')->whereNotNull('level_p')->get()->toArray();
        $leveltimpro = LevelTimProduksi::whereIn('id',$id_level)->get();
        $level = LevelKantor::all();
        $id_prop = TimProduksi::select('prop_tim')->groupBy('prop_tim')->whereNotNull('prop_tim')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$id_prop)->get();

        $data = TimProduksi::orderBy('id','asc');
        $kantor = Kantor::orderBy('id','asc')->groupBy('nama_kantor')->get();

        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $data->where('jenis_usaha', '=', $request->f_jenis_usaha);
        }

        if (!$request->f_pjk3===NULL || !$request->f_pjk3==""){
            $data->where('pjk3', '=', $request->f_pjk3);
        }

        if (!$request->f_tim_pro===NULL || !$request->f_tim_pro==""){
            $x = $request->f_tim_pro;
            $data->where(function ($query) use($x) {
                $query->where('id', '=', $x)
                ->orWhere('level_p_atas', '=', $x);
            });
        }

        if (!$request->f_level_tim_pro===NULL || !$request->f_level_tim_pro==""){
            $data->where('level_p', '=', $request->f_level_tim_pro);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $data->where('prop_tim', '=', $request->f_provinsi);
            $id_kota = TimProduksi::select('kota_tim')->groupBy('kota_tim')->get()->toArray();
            $kota = KotaModel::whereIn('id',$id_kota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = KotaModel::where('id','=','~')->get();
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $data->where('kota_tim', '=', $request->f_kota);
        }

        if (!$request->f_instansi_reff===NULL || !$request->f_instansi_reff==""){
            $data->where('instansi_reff', '=', $request->f_instansi_reff);
        }

        $data->get();
        $data = $data->get();

        return view('timproduksi.index')->with(compact('data','prov','kota','level','kantor','jenisUsaha','badanusaha','timproduksi','leveltimpro','instansireff'));

        // dd($request->f_naker_prov);
    }

    public function autofillnpwp(Request $request){
        $data = BuModel::find($request->value);
        // $request->value;
        return $data;
    }
}
