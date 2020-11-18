<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KantorModel;
use App\KotaModel;
use App\ProvinsiModel;
use App\LevelKantor;
use App\TimProduksi;
use App\TimMarketing;
use App\JenisUsaha;
use App\BuModel;
use App\LevelTimProduksi;
use App\LevelTimMarketing;
use App\BentukBuModel;
use App\BankModel;
use App\GolHargaMkt;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TimMarketingController extends Controller
{
    //


    public function index($id,Request $request)
    {

        $id_jenis_usaha = "all";
        $nama_jenis_usaha = "";

        $iduser = Auth::id();
        $datamark = TimMarketing::where('user_id',$iduser)->first();

        if (Auth::user()->role_id == 1){
            $data = TimMarketing::orderBy('id','asc');
        }
        else if($datamark){
            $data = TimMarketing::where('user_id',$iduser)->orWhere('level_m_atas',$datamark->id)->orderBy('id','asc');
        }else{
            $data = TimMarketing::where('id','~')->orderBy('id','asc');
        }

        $timmarketing = TimMarketing::orderBy('id','asc');
        $idjensusaha = TimMarketing::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha');
        $idlevelmkt = TimMarketing::select('level_m')->groupBy('level_m')->whereNotNull('level_m');
        $instansi = TimMarketing::groupBy('instansi_reff')->whereNotNull('instansi_reff');
        $idprop = TimMarketing::select('prop')->groupBy('prop')->whereNotNull('prop');
        $idtimpro = TimMarketing::select('id_tim_prod')->groupBy('id_tim_prod')->whereNotNull('id_tim_prod');

        if($id!="all"){
            $data->where('jenis_usaha',$id);
            $timmarketing->where('jenis_usaha',$id);
            $idjensusaha->where('jenis_usaha',$id);
            $idlevelmkt->where('jenis_usaha',$id);
            $instansi->where('jenis_usaha',$id);
            $idprop->where('jenis_usaha',$id);
            $idtimpro->where('jenis_usaha',$id);

            $tipemarketing = JenisUsaha::find($id);
            $id_jenis_usaha = $tipemarketing->id;
            $nama_jenis_usaha = $tipemarketing->kode_jns_usaha;

        }
        $timmarketing = $timmarketing->get();
        $idjensusaha = $idjensusaha->get()->toArray();
        $idlevelmkt = $idlevelmkt->get()->toArray();
        $instansi = $instansi->get();
        $idprop = $idprop->get()->toArray();
        $idtimpro = $idtimpro->get()->toArray();

        $jenisUsaha = JenisUsaha::whereIn('id',$idjensusaha)->get();
        $leveltimmkt = LevelTimMarketing::whereIn('id',$idlevelmkt)->get();
        $id_level_tim_pro = TimProduksi::select('level_p')->groupBy('level_p')->whereNotNull('level_p')->whereIn('id',$idtimpro)->get()->toArray();
        $leveltimpro = LevelTimProduksi::whereIn('id',$id_level_tim_pro)->get();
        $timproduksi = TimProduksi::whereIn('id',$idtimpro)->get();
        $golharga = GolHargaMkt::orderBy('kode','asc')->get();
        $level = LevelKantor::all();
        $prov = ProvinsiModel::whereIn('id',$idprop)->get();

        $kantor = KantorModel::orderBy('id','asc')->groupBy('nama_kantor')->get();

        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $data->where('jenis_usaha', '=', $request->f_jenis_usaha);
        }

        if (!$request->f_tim_mkt===NULL || !$request->f_tim_mkt==""){
            $x = $request->f_tim_mkt;
            $data->where(function ($query) use($x) {
                $query->where('id', '=', $x)
                ->orWhere('level_m_atas', '=', $x);
            });
        }

        if (!$request->f_level_tim_mkt===NULL || !$request->f_level_tim_mkt==""){
            $data->where('level_m', '=', $request->f_level_tim_mkt);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $data->where('prop', '=', $request->f_provinsi);

            if($id=="all"){
                $id_kota = TimMarketing::select('kota')->groupBy('kota')->get()->toArray();
            }else{
                $id_kota = TimMarketing::select('kota')->groupBy('kota')->where('jenis_usaha',$id)->get()->toArray();
            }

            $kota = KotaModel::whereIn('id',$id_kota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = KotaModel::where('id','=','~')->get();
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $data->where('kota', '=', $request->f_kota);
        }

        if (!$request->f_instansi===NULL || !$request->f_instansi==""){
            $data->where('instansi_reff', '=', $request->f_instansi);
        }

        if (!$request->f_gol_harga===NULL || !$request->f_gol_harga==""){
            $data->where('gol_hrg_m', '=', $request->f_gol_harga);
        }

        if (!$request->f_tim_prod===NULL || !$request->f_tim_prod==""){
            $f_tim_prod = $request->f_tim_prod;
            $data->whereHas('tim_prod_r', function ($query) use($f_tim_prod) {
                $query->where('nama_tim_p', '=', $f_tim_prod);
            });
        }

        if (!$request->f_level_tim_pro===NULL || !$request->f_level_tim_pro==""){
            $f_level_tim_pro = $request->f_level_tim_pro;
            $data->whereHas('tim_prod_r', function ($query) use($f_level_tim_pro) {
                $query->where('level_p', '=', $f_level_tim_pro);
            });
        }

        $data->get();
        $data = $data->get();

        return view('timmarketing.index')->with(compact('data','prov','kota','level','kantor','jenisUsaha','timmarketing','leveltimmkt','timproduksi','leveltimpro','instansi','golharga','id_jenis_usaha','nama_jenis_usaha'));
    }

    public function create()
    {
        $golharga = GolHargaMkt::orderBy('kode','asc')->get();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::all();
        $bentukbu = BentukBuModel::all();
        $leveltimmkt = LevelTimMarketing::all();
        $bank = BankModel::all();
        $timproduksi = TimProduksi::orderBy('id','asc')->get();
        $timmarketing = TimMarketing::orderBy('id','asc')->get();
        $idjenisusaha = TimProduksi::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha')->get()->toArray();
        $jenisusaha = JenisUsaha::whereIn('id',$idjenisusaha)->get();
        return view('timmarketing.create')->with(compact('prov','kota','bentukbu','leveltimmkt','bank','golharga','timproduksi','timmarketing','jenisusaha'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nama_singkat' => 'required',
                // 'bentuk_bu' => 'required',
                'leveltimmkt' => 'required',
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

                // 'tim_prod' => 'required',


            ],[
                'nama.required' => "Nama tidak boleh kosong",
                'nama_singkat.required' => "Nama Singkat tidak boleh kosong",
                // 'bentuk_bu.required' => "Bentuk BU tidak boleh kosong",
                'leveltimmkt.required' => "Level tidak boleh kosong",
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
                'id_file_npwp.mimes'=>'Format file tidak sesuai',

                // 'tim_prod.required'=>'Tim Produksi tidak boleh kosong'


            ]);

            $data['id_bu'] = $request->id_bu;
            $data['jenis_usaha'] = $request->id_jenis_usaha;
            $data['nama_tim_m'] = $request->nama;
            $data['singkat_tim_m'] = $request->nama_singkat;
            $data['level_m'] = $request->leveltimmkt;
            $data['level_m_atas'] = $request->timmktatas;
            $data['id_tim_prod'] = $request->tim_prod;
            $data['gol_hrg_m'] = $request->gol_harga;
            $data['prop'] = $request->id_prov;
            $data['kota'] = $request->id_kota;
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
                $destinationPath = 'uploads/NPWP_Tim_Marketing'; // upload path
                $file = "NPWP_".$dir_name."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $data['file_npwp'] = $destinationPath."/".$file;
            }

            $dataMarkt = TimMarketing::create($data);

            // Buat User Login
            $dataUser['username'] = $request->id_email;
            $dataUser['email'] = $request->id_email;
            $dataUser['name'] = $request->nama;
            $id_role = Role::where('name','tim_marketing')->first();
            $dataUser['role_id'] = $id_role->id;
            // $dataUser['role_id'] = 21;
            $dataUser['is_active'] = 1;
            $dataUser['password'] = Hash::make('123456');
            $createIdUser =  User::updateOrCreate([
                'username' => $request->id_email,
                'role_id' => $id_role->id,
            ],$dataUser);

            $dataUser2['username'] = $request->id_email_kp;
            $dataUser2['email'] = $request->id_email_kp;
            $dataUser2['name'] = $request->id_nama_kp;
            $id_role2 = Role::where('name','tim_marketing')->first();
            $dataUser2['role_id'] = $id_role2->id;
            // $dataUser2['role_id'] = 21;
            $dataUser2['is_active'] = 1;
            $dataUser2['password'] = Hash::make('123456');
            User::updateOrCreate([
                'username' => $request->id_email_kp,
                'role_id' => $id_role2->id,
            ],$dataUser2);

            $dataUserMarkt['user_id'] = $createIdUser->id;
            TimMarketing::find($dataMarkt->id)->update($dataUserMarkt);

            return response()->json([
                'status' => true,
                'icon' => "success",
                'message' => 'Data berhasil ditambahkan!'
            ]);
    }


    public function edit($id)
    {
        $data = TimMarketing::find($id);
        if($data->id_bu==null){
            $badanusaha = BuModel::where('id',$data->id_bu)->get();
        }else{
            $badanusaha = BuModel::all();
        }

        $golharga = GolHargaMkt::orderBy('kode','asc')->get();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::where('provinsi_id',$data->prop)->get();
        $bentukbu = BentukBuModel::all();
        // $leveltimmkt = LevelTimMarketing::where('id','<=',$data->level_m)->get();
        $leveltimmkt = LevelTimMarketing::all();
        $bank = BankModel::all();
        $timproduksi = TimProduksi::where('jenis_usaha',$data->jenis_usaha)->orderBy('id','asc')->get();
        $timmarketing = TimMarketing::orderBy('id','asc')->get();
        $levelatas = TimMarketing::where('level_m','=',$data->level_m-1)->get();
        $idjenisusaha = TimProduksi::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha')->get()->toArray();
        $jenisusaha = JenisUsaha::whereIn('id',$idjenisusaha)->get();
        return view('timmarketing.edit')->with(compact('prov','kota','bentukbu','leveltimmkt','bank','golharga','timproduksi','timmarketing','data','levelatas','jenisusaha','badanusaha'));
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nama_singkat' => 'required',
                // 'bentuk_bu' => 'required',
                'leveltimmkt' => 'required',
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

                // 'tim_prod' => 'required',


            ],[
                'nama.required' => "Nama tidak boleh kosong",
                'nama_singkat.required' => "Nama Singkat tidak boleh kosong",
                // 'bentuk_bu.required' => "Bentuk BU tidak boleh kosong",
                'leveltimmkt.required' => "Level tidak boleh kosong",
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
                'id_file_npwp.mimes'=>'Format file tidak sesuai',

                // 'tim_prod.required'=>'Tim Produksi tidak boleh kosong'


            ]);

            $data['id_bu'] = $request->id_bu;
            $data['jenis_usaha'] = $request->id_jenis_usaha;
            $data['nama_tim_m'] = $request->nama;
            $data['singkat_tim_m'] = $request->nama_singkat;
            $data['level_m'] = $request->leveltimmkt;
            $data['level_m_atas'] = $request->timmktatas;
            $data['id_tim_prod'] = $request->tim_prod;
            $data['gol_hrg_m'] = $request->gol_harga;
            $data['prop'] = $request->id_prov;
            $data['kota'] = $request->id_kota;
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
                $destinationPath = 'uploads/NPWP_Tim_Marketing'; // upload path
                $file = "NPWP_".$dir_name."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $data['file_npwp'] = $destinationPath."/".$file;
            }

            TimMarketing::find($request->id_tim_mkt)->update($data);
            $level_m = $request->leveltimmkt;

            $datalevanak1['level_m'] = $level_m+1;
            TimMarketing::where('level_m_atas',$request->id_tim_mkt)->update($datalevanak1);
            $timlevanak1 = TimMarketing::select('id')->where('level_m_atas',$request->id_tim_mkt)->get()->toArray();
            // dd($timlevanak1);

            if($timlevanak1){
                $datalevanak2['level_m'] = $level_m+2;
                TimMarketing::whereIn('level_m_atas',$timlevanak1)->update($datalevanak2);
                $timlevanak2 = TimMarketing::select('id')->whereIn('level_m_atas',$timlevanak1)->get()->toArray();
            }else{
                $timlevanak2 = null;
            }

            if($timlevanak2){
                $datalevanak3['level_m'] = $level_m+3;
                TimMarketing::whereIn('level_m_atas',$timlevanak2)->update($datalevanak3);
                $timlevanak3 = TimMarketing::select('id')->whereIn('level_m_atas',$timlevanak2)->get()->toArray();
            }else{
                $timlevanak3=null;
            }

            if($timlevanak3){
                $datalevanak4['level_m'] = $level_m+4;
                TimMarketing::whereIn('level_m_atas',$timlevanak3)->update($datalevanak4);
                $timlevanak4 = TimMarketing::select('id')->whereIn('level_m_atas',$timlevanak3)->get()->toArray();
            }else{
                $timlevanak4=null;
            }

                     // Buat User Login
                     $dataUser['username'] = $request->id_email;
                     $dataUser['email'] = $request->id_email;
                     $dataUser['name'] = $request->nama;
                     $id_role = Role::where('name','tim_marketing')->first();
                     $dataUser['role_id'] = $id_role->id;
                     // $dataUser['role_id'] = 21;
                     $dataUser['is_active'] = 1;
                     $dataUser['password'] = Hash::make('123456');
                     $createIdUser = User::updateOrCreate([
                        'username' => $request->id_email,
                        'role_id' => $id_role->id,
                    ],$dataUser);

                     $dataUser2['username'] = $request->id_email_kp;
                     $dataUser2['email'] = $request->id_email_kp;
                     $dataUser2['name'] = $request->id_nama_kp;
                     $id_role2 = Role::where('name','tim_marketing')->first();
                     $dataUser2['role_id'] = $id_role2->id;
                     // $dataUser2['role_id'] = 21;
                     $dataUser2['is_active'] = 1;
                     $dataUser2['password'] = Hash::make('123456');
                     User::updateOrCreate([
                        'username' => $request->id_email_kp,
                        'role_id' => $id_role2->id,
                    ],$dataUser2);

                    $dataUserMarkt['user_id'] = $createIdUser->id;
                    TimMarketing::find($request->id_tim_mkt)->update($dataUserMarkt);

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
        TimMarketing::whereIn('id', $idData)->update($user_data);
        return redirect('timmarketing/all')->with('message', 'Data berhasil dihapus!');
    }

    public function changetimprod(Request $request){
        $select_jenis_usaha = TimProduksi::select('jenis_usaha')->where('id','=',$request->tim_prod)->first();
        return $data = JenisUsaha::where('id','=',$select_jenis_usaha['jenis_usaha'])->get(['id','nama_jns_usaha as text']);
    }

    public function changebadanusaha(Request $request){
        // return $request->status;
        $select_badan_usaha = BuModel::where('status_kantor',2)->get(['id','nama_bu as text']);
        return $select_badan_usaha;
        // return $data = masterJenisUsaha::where('id','=',$select_jenis_usaha['jenis_usaha'])->get(['id','nama_jns_usaha as text']);
    }

    public function changelevelatas(Request $request){
        return $data = TimMarketing::where('level_m','=',$request->leveltimmkt-1)->get(['id','nama_tim_m as text']);
    }

    public function filter(Request $request)
    {
        $timmarketing = TimMarketing::orderBy('id','asc')->get();
        $idjensusaha = TimMarketing::select('jenis_usaha')->groupBy('jenis_usaha')->whereNotNull('jenis_usaha')->get()->toArray();
        $jenisUsaha = masterJenisUsaha::whereIn('id',$idjensusaha)->get();
        $idlevelmkt = TimMarketing::select('level_m')->groupBy('level_m')->whereNotNull('level_m')->get()->toArray();
        $leveltimmkt = LevelTimMarketing::whereIn('id',$idlevelmkt)->get();
        $id_level_tim_pro = TimProduksi::select('level_p')->groupBy('level_p')->whereNotNull('level_p')->get()->toArray();
        $leveltimpro = LevelTimProduksi::whereIn('id',$id_level_tim_pro)->get();
        $instansi = TimMarketing::groupBy('instansi_reff')->whereNotNull('instansi_reff')->get();
        $timproduksi = TimProduksi::all();
        $golharga = GolHargaMkt::orderBy('kode','asc')->get();
        $level = LevelKantor::all();
        $idprop = TimMarketing::select('prop')->groupBy('prop')->whereNotNull('prop')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$idprop)->get();
        // $kota = Kota::where('id','=','~')->get();
        $data = TimMarketing::orderBy('id','asc');
        $kantor = KantorModel::orderBy('id','asc')->groupBy('nama_kantor')->get();

        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $data->where('jenis_usaha', '=', $request->f_jenis_usaha);
        }

        if (!$request->f_tim_mkt===NULL || !$request->f_tim_mkt==""){
            $x = $request->f_tim_mkt;
            $data->where(function ($query) use($x) {
                $query->where('id', '=', $x)
                ->orWhere('level_m_atas', '=', $x);
            });
        }

        if (!$request->f_level_tim_mkt===NULL || !$request->f_level_tim_mkt==""){
            $data->where('level_m', '=', $request->f_level_tim_mkt);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $data->where('prop', '=', $request->f_provinsi);
            $id_kota = TimMarketing::select('kota')->groupBy('kota')->get()->toArray();
            $kota = KotaModel::whereIn('id',$id_kota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
             $kota = KotaModel::where('provinsi_id',$request->f_provinsi)->get();
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $data->where('kota', '=', $request->f_kota);
        }

        if (!$request->f_instansi===NULL || !$request->f_instansi==""){
            $data->where('instansi_reff', '=', $request->f_instansi);
        }

        if (!$request->f_gol_harga===NULL || !$request->f_gol_harga==""){
            $data->where('gol_hrg_m', '=', $request->f_gol_harga);
        }

        if (!$request->f_tim_prod===NULL || !$request->f_tim_prod==""){
            $f_tim_prod = $request->f_tim_prod;
            $data->whereHas('tim_prod_r', function ($query) use($f_tim_prod) {
                $query->where('nama_tim_p', '=', $f_tim_prod);
            });
        }

        if (!$request->f_level_tim_pro===NULL || !$request->f_level_tim_pro==""){
            $f_level_tim_pro = $request->f_level_tim_pro;
            $data->whereHas('tim_prod_r', function ($query) use($f_level_tim_pro) {
                $query->where('level_p', '=', $f_level_tim_pro);
            });
        }

        $data->get();
        $data = $data->get();

        return view('timmarketing.index')->with(compact('data','prov','kota','level','kantor','jenisUsaha','timmarketing','leveltimmkt','timproduksi','leveltimpro','instansi','golharga'));
    }

    public function autofillnpwp(Request $request){
        $data = BuModel::find($request->value);
        // $request->value;
        return $data;
    }

    public function autofilltimprod(Request $request){

        $data = TimProduksi::where('jenis_usaha',$request->value)->get(['id','nama_tim_p as text']);
        // $request->value;
        return $data;
    }
}
