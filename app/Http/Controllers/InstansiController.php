<?php

namespace App\Http\Controllers;


// use App\NegaraModel;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\BentukBuModel;
use App\StatusBUModel;
use App\BankModel;
use App\Personal;
use App\Peserta;
use App\User;
use App\TargetBlasting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use File;
use DB;

class InstansiController extends Controller
{
    //
    public function index () {
        $instansi = BuModel::all();
        $reff = BuModel::whereNotNull('instansi_reff')->get();
        $statusmodel = StatusBUModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        return view('instansi.index')->with(compact('instansi', 'statusmodel','provinsi','kota', 'reff'));
    }

    public function filter(Request $request)
    {
    //     $id_status = BUModel::select('status_kantor')->groupBy('status_kantor')->whereNotNull('status_kantor')->get()->toArray();
    //     $statusmodel = StatusModel::whereIn('id',$id_status)->get();
    //     $id_prop = BUModel::select('id_prop')->groupBy('id_prop')->whereNotNull('id_prop')->get()->toArray();
    //     $prov = Provinsi::whereIn('id',$id_prop)->get();
    //     $jenisusaha = masterJenisUsaha::orderBy('id', 'asc')->get();
    //     $instansi = masterBadanUsaha::groupBy('instansi_reff')->whereNotNull('instansi_reff')->get();
    //     $pjk3 = masterBadanUsaha::orderBy('id','asc')->get();
    //     $data = masterBadanUsaha::orderBy('id','asc');
        // $kota = Kota::where('id','=','~')->get();


        $instansi = BuModel::all();
        $reff = BuModel::whereNotNull('instansi_reff')->get();
        $statusmodel = StatusBUModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();

        if (!$request->f_pjk3===NULL || !$request->f_pjk3==""){
            $instansi->where('id', '=', $request->f_pjk3);
        }

        if (!$request->f_naker_prov===NULL || !$request->f_naker_prov==""){
            $instansi->where('prop_naker', '=', $request->f_naker_prov);
        }

        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $instansi = $instansi->where('id_prop', '=', $request->f_provinsi);
            $idkota = BUModel::select('id_kota')->groupBy('id_kota')->whereNotNull('id_kota')->get()->toArray();
            $kota = KotaModel::whereIn('id',$idkota)->where('provinsi_id',$request->f_provinsi)->get();
        }else{
            $kota = KotaModel::where('id','=','~')->get();
        }

        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $instansi = $instansi->where('id_kota', '=', $request->f_kota);
        }

        if (!$request->f_instansi===NULL || !$request->f_instansi==""){
            $instansi = $instansi->where('instansi_reff', '=', $request->f_instansi);
        }

        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $instansi = $instansi->where('jns_usaha', '=', $request->f_jenis_usaha);
        }

        if (!$request->f_status===NULL || !$request->f_status==""){
            $instansi = $instansi->where('status_kantor', '=', $request->f_status);
        }

        // $instansi->all();
        // $instansi = $instansi->all();

        return view('instansi.index')->with(compact('instansi', 'statusmodel','provinsi','kota', 'reff'));
        // return view('suket.badanusaha.index')->with(compact('data','prov','kota','jenisusaha','instansi','pjk3','statusmodel'));

        // dd($request->f_naker_prov);
    }
    public function show ($id) {
        $instansi = BuModel::where('id', $id)->first();
        // $negara = NegaraModel::where('id', $id)->first();
        $provinsi = ProvinsiModel::where('id', $instansi->id_prop)->first();
        $kota = KotaModel::where('id', $instansi->id_kota)->first();
        $bank = BankModel::where('id_bank', $instansi->id_bank)->first();
        $statusmodel = StatusBUModel::all();
        return view('instansi.show')->with(compact('instansi','provinsi','kota','bank','id'));

    }
    public function create() {
        // $negara = NegaraModel::all();
        $personal = Personal::where('is_activated', '1')->get();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $bank = BankModel::all();
        $bentukusaha = BentukBUModel::all();
        $statusmodel = StatusBUModel::all();
        // return view('instansi.create')->with(compact('negara','provinsi','kota'));
        return view('instansi.create')->with(compact('provinsi','kota','bank', 'bentukusaha', 'statusmodel', 'personal'));
    }
    public function store(Request $request) {
        // dd($request);
        // dd($request->isi_manual);
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);

        $request->validate([
            "nama_bu" => "required",
            "email" => "sometimes|nullable|email|unique:badan_usaha",
            "telp" => "required|numeric|unique:badan_usaha",
            "web" => "sometimes|nullable|url",
            "bentuk_bu" => "required",
            "status_kantor" => "required",
            "alamat" => "required",
            "id_prop" => "required",
            "id_kota" => "required",
            "singkat_bu" => "required",
            "nama_pimp_text" => "required_with:isi_manual,on",
            "jab_pimp" => "required_with:isi_manual,on",
            "email_pimp" => "sometimes|nullable|required_with:isi_manual,on|email",
            // "hp_pimp" => "required",
            "kontak_p" => "required|min:3|max:100",
            // "jab_kontak_p" => "required|min:3|max:100",
            // "email_kontak_p" => "required|email|unique:badan_usaha",
            "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha",
            "no_rek" => "sometimes|nullable|min:4|max:20",
            "id_bank" => "sometimes|required_with:no_rek",
            "nama_rek" => "sometimes|nullable|required_with:no_rek",
            'npwpClean' => 'sometimes|nullable|digits:15',
            "npwp_pdf" => "sometimes|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048",
            "logo" => "sometimes|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ],[
            'nama_bu.required' => 'Mohon isi Nama Badan Usaha',
            'nama_bu.min' => 'Nama Badan Usaha minimal 3 karakter',
            'nama_bu.max' => 'Nama Badan Usaha maksimal 500 karakter',
            'email.required' => 'Mohon isi Email Badan Usaha',
            'email.email' => 'Mohon isi dengan format email yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'telp.required' => 'Mohon isi Nomor Telepon Badan Usaha',
            'telp.numeric' => 'Mohon hanya isi dengan angka',
            'telp.digits_between' => 'Mohon isi Nomor Telepon dengan formar yang valid',
            'web.required' => 'Mohon isi Website Badan Usaha',
            'web.url' => 'Mohon isi Website dengan format yang valid (diawali dengan http:// atau https://)',
            'web.min' => 'Website minimal 3 karakter',
            'web.max' => 'Website maksimal 100 karakter',
            'bentuk_bu.required' => 'Mohon isi Bentuk Badan Usaha',
            'status_kantor.required' => 'Mohon isi Status Badan Usaha',
            'alamat.required' => 'Mohon isi Alamat Badan Usaha',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'id_prop.required' => 'Mohon isi Provinsi',
            'id_kota.required' => 'Mohon isi Kota',
            'singkat_bu.required' => 'Mohon isi Nama Singkat Badan Usaha',
            'singkat_bu.min' => 'Nama Singkat minimal 2 karakter',
            'singkat_bu.max' => 'Nama Singkat maksimal 100 karakter',
            'nama_pimp_text.required_with' => 'Mohon isi Nama Pimpinan (Jika isi manual)',
            'nama_pimp.min' => 'Nama Pimpinan minimal 3 karakter',
            'nama_pimp.max' => 'Nama Pimpinan maksimal 100 karakter',
            'jab_pimp.required_with' => 'Mohon isi Jabatan Pimpinan (Jika isi manual)',
            'jab_pimp.min' => 'Jabatan Pimpinan minimal 3 karakter',
            'jab_pimp.max' => 'Jabatan Pimpinan maksimal 100 karakter',
            'email_pimp.required_with' => 'Mohon isi Email Pimpinan (Jika isi manual)',
            'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
            'email_pimp.unique' => 'Email sudah terdaftar',
            'hp_pimp.required_with' => 'Mohon isi Nomor Telepon Pimpinan (Jika isi manual)',
            'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
            'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'kontak_p.required' => 'Mohon isi Nama Contact Person',
            'kontak_p.min' => 'Contact Person minimal 3 karakter',
            'kontak_p.max' => 'Contact Person maksimal 100 karakter',
            'jab_kontak_p.required' => 'Mohon isi Jabatan Contact Person',
            'jab_kontak_p.min' => 'Jabatan Contact Person minimal 3 karakter',
            'jab_kontak_p.max' => 'Jabatan Contact Person maksimal 100 karakter',
            'email_kontak_p.required' => 'Mohon isi Email Contact Person',
            'email_kontak_p.email' => 'Mohon isi dengan format Email yang valid',
            'email_kontak_p.unique' => 'Email sudah terdaftar',
            'no_kontak_p.required' => 'Mohon isi Nomor Telepon Contact Person',
            'no_kontak_p.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_kontak_p.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_kontak_p.unique' => 'Nomor Telepon sudah terdaftar',
            'no_kontak_p.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_rek.min' => 'Nomor Rekening minimal 4 digit',
            'no_rek.max' => 'Nomor Rekening maksimal 20 digit',
            'id_bank.required_with' => 'Mohon lengkapi Nama Bank',
            'nama_rek.required_with' => 'Mohon lengkapi Nama Pada Rekening',
            'nama_rek.min' => 'Nama pada Rekening minimal 3 karakter',
            'nama_rek.max' => 'Nama pada Rekening maksimal 100 karakter',
            'npwpClean.required' => 'Mohon isi NPWP',
            'npwpClean.numeric' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.digits' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.gt' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwp_pdf.mimes' => 'Mohon isi Lampiran NPWP dengan file gambar atau PDF',
            'npwp_pdf.max' => 'Lampiran Maksimal 2MB',
            'logo.required' => 'Mohon lampirkan Logo Badan Usaha',
            'logo.mimes' => 'Mohon lampirkan Logo berupa gambar',
            'logo.max' => 'Logo maksimal berukuran 2MB',
        ]);
        if($request->isi_manual){
            // dd('masuk bos');
            $request->validate([
                "email_pimp" => "unique:personal,email"
            ],[
                'email_pimp.unique' => 'Email sudah terdaftar',
            ]);
        }

        $data = new BuModel;
        $data->nama_bu          = $request->nama_bu        ;
        $data->email            = $request->email          ;
        $data->instansi_reff    = $request->instansi_reff  ;
        $data->id_bentuk_usaha  = $request->bentuk_bu      ;
        $data->telp             = $request->telp           ;
        $data->web              = $request->web            ;
        $data->alamat           = $request->alamat         ;
        $data->id_prop          = $request->id_prop        ;
        $data->id_kota          = $request->id_kota        ;
        $data->singkat_bu       = $request->singkat_bu     ;
        // $data->nama_pimp        = $request->nama_pimp      ;
        $data->jab_pimp         = $request->jab_pimp       ;
        $data->email_pimp       = $request->email_pimp     ;
        $data->hp_pimp          = $request->hp_pimp        ;
        $data->kontak_p         = $request->kontak_p       ;
        $data->jab_kontak_p     = $request->jab_kontak_p   ;
        $data->email_kontak_p   = $request->email_kontak_p ;
        $data->no_kontak_p      = $request->no_kontak_p    ;
        $data->no_rek           = $request->no_rek         ;
        $data->id_bank          = $request->id_bank        ;
        $data->nama_rek         = $request->nama_rek       ;
        $data->npwp             = $request->npwp           ;
        $data->is_actived      = '1'                       ;
        $data->status_kantor             = $request->status_kantor  ;
        $data->level_atas             = $request->bu_atas        ;

        $data->created_by       = Auth::id()               ;

        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama_bu);

        if ($files = $request->file('npwp_pdf')) {
            $destinationPath = 'uploads/lampiran/badan_usaha/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_npwp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->npwp_pdf = $destinationPath."/".$file;
        }

        if ($files = $request->file('logo')) {
            $destinationPath = 'uploads/lampiran/badan_usaha/'.$dir_name; // upload path
            if (!is_dir($destinationPath)) {
                // mkdir($destinationPath, 777, true);
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
            }
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path
            $resize_image = Image::make($files);
            // $resize_image->resize(354, 472)->save($destinationPathTemp.$file);
            $resize_image->resize(250,null, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path($destinationPathTemp.$file));
            $temp = $destinationPathTemp.$file;
            rename($temp, $destinationFile );
            $data->logo = $destinationFile;

        }

        $data->save();
        if(($request->isi_manual == "on") ) {

            if($request->email_pimp && $request->email_pimp) {
                $user = User::where('email',$request->email_pimp)->first();

                if(!isset($user)) {
                    $password = str_random(8);

                    $user               = new User;
                    $user->username     = $request->email_pimp;
                    $user->email        = $request->email_pimp;
                    $user->password     = Hash::make($password);
                    $user->name         = isset($request->nama_pimp_text) ? $request->nama_pimp_text : $request->email_pimp;
                    $user->role_id      = 2;
                    $user->is_active    = 1;
                    // $user->created_by   = Auth::id();
                    $user->save();

                    $target = new TargetBlasting;
                    $target->nama  = $request->nama_pimp_text;
                    $target->email  = $request->email_pimp;
                    $target->no_hp  = $request->hp_pimp;
                    $target->save();

                    $detail = ['nama' => $request->nama_pimp_text,
                    'password' => $password,
                    'email' => $request->email_pimp, 'nope' => $request->hp_pimp];
                    dispatch(new \App\Jobs\UserBaruPersonal($detail));

                }

                $personal = Personal::where('email',$request->email_pimp)->first();

                if(!isset($personal)) {
                    $pimp = new Personal;
                    $pimp->instansi         = $data->id                ;
                    $pimp->user_id          = $user->id                ;
                    $pimp->nama             = $request->nama_pimp_text      ;
                    $pimp->jabatan          = $request->jab_pimp       ;
                    $pimp->email            = $request->email_pimp     ;
                    $pimp->no_hp            = $request->hp_pimp        ;
                    $pimp->is_activated     = '1'                       ;
                    $pimp->is_pimpinan      = '1'                      ;

                    $pimp->created_by       = Auth::id()               ;
                    // dd($pimp);
                    $pimp->save()                                      ;

                    $data->id_personal_pimp = $pimp->id                ;
                    $data->nama_pimp        = $request->nama_pimp_text      ;
                    $data->save();

                    return redirect('/instansi')
                    ->with('pesan',"Badan Usaha berhasil ditambahkan");
                    // return redirect('/instansi/lengkapi/'.$data->id.'/'.$pimp->id)
                    // ->with('pesan',"Badan Usaha \"".$request->nama_bu.
                    // "\" berhasil ditambahkan, mohon lengkapi data diri pimpinan");
                } else {
                    $data->id_personal_pimp = $personal->id                ;
                    $data->nama_pimp        = $request->nama_pimp_text      ;
                    $data->save();
                    return redirect('/instansi')
                    ->with('pesan',"Badan Usaha berhasil ditambahkan");
                }
            } else {
                return redirect('/instansi')
                ->with('pesan',"Badan Usaha berhasil ditambahkan");
            }

        } else {
            $pers = Personal::where('id', $request->nama_pimp_select)->first();
            $data->id_personal_pimp = $pers->nama;                ;
            $data->save();

            if(isset($request->nama_pimp_select)) {
                $pers->is_pimpinan = '1';
                $pers->save();
                return redirect('/instansi')
                ->with('pesan',"Badan Usaha berhasil ditambahkan");
            }
        }


    }
    public function lengkapi($id, $id_personal) {
        // dump($id);
        // dump(BuModel::find($id));
        // dump($id_personal);
        // dump(Personal::find($id_personal));
        $instansi = BuModel::find($id);
        $personal = Personal::find($id_personal);
        $provinsis = ProvinsiModel::all();
        $kotas = KotaModel::all();
        $banks = BankModel::all();

        return view('instansi.lengkapi')
        ->with(compact('id','id_personal','instansi',
        'personal','provinsis','kotas','banks'));
    }

    public function storeLengkapi(Request $request) {
        // dd($request);
        // $personal = Personal::find($id);
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);
        $request->validate([
            'nama' => 'required|min:3|max:100',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email',
            'no_hp' => 'required|numeric|digits_between:9,14',
            'jenis_kelamin' => 'required',Rule::in(['L','P']),
            // 'instansi' => 'required',
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
            // 'email.max' => 'Email maksimal 100 karakter',
            'no_hp.required' => 'Mohon isi Nomor Telepon',
            'no_hp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_hp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'jenis_kelamin.required' => 'Mohon isi Jenis Kelamin',
            // 'instansi.required' => 'Mohon isi Instansi',
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

        $user = User::where('id',$data->user_id)->first();
        if(isset($user) && $user->email != $request->email){
            $user->email = $request->email;

            $user->updated_at = Carbon::now();
            // $user->updated_by = Auth::id();
            $user->save();
        }


        $data->jenis_kelamin = $request->jenis_kelamin;
        // $data->instansi = $request->instansi;
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
            // if (file_exists(public_path()."/".$data->lampiran_ktp) && file_exists(public_path()."/".$lampiran_ktp_lama)  && $lampiran_ktp_lama != null) {
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
            // if (file_exists(public_path()."/".$data->lampiran_npwp) && file_exists(public_path()."/".$lampiran_npwp_lama)  && $lampiran_npwp_lama != null) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_npwp_lama);
            // }
        }


        $data->updated_at = Carbon::now();
        $data->updated_by = Auth::id();
        $data->save();

        $data->save();

        $instansi = BuModel::find($request->id_instansi);
        $instansi->is_actived = '1';
        $instansi->updated_at = Carbon::now();
        $instansi->updated_by = Auth::id();
        $instansi->save();

        if($data->nama != $request->nama){
            $request->validate([
                'nama' => 'required|min:3|max:100',
            ], [
                'nama.required' => 'Mohon isi Nama',
                'nama.min' => 'Email maksimal 3 karakter',
                'nama.max' => 'Email maksimal 100 karakter',
            ]);
            $data->nama = $request->nama;
            $instansi->nama_pimp = $request->nama;
        }
        if($request->nik != $data->nik){
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
        if($request->email != $data->email){
            $request->validate([
                'email' => 'required|email|unique:personal',
            ], [
                'email.required' => 'Mohon isi Email',
                'email.email' => 'Mohon isi Email dengan format yang valid',
                // 'email.max' => 'Email maksimal 100 karakter',
                'email.unique' => 'Email sudah terdaftar',
            ]);
            $data->email = $request->email;
            $instansi->email_pimp = $request->email;
        }
        if($request->no_hp != $data->no_hp){
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
            $instansi->hp_pimp = $request->no_hp;
        }
        $data->save();
        $instansi->save();

        $peserta = new Peserta;

        $peserta->id_personal = $data->id;
        $peserta->nama = $request->nama;
        $peserta->email = $request->email;
        $peserta->no_hp = $request->no_hp;
        $peserta->instansi = $instansi->id;
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

        return redirect('/instansi')->with('pesan',"Data instansi berhasil dilengkapi");
    }


    public function edit($id) {
        $instansi = BuModel::where('id',$id)->first();
        if($instansi->is_actived == '1'){
            // $negara = NegaraModel::all();
            $provinsi = ProvinsiModel::all();
            $kota = KotaModel::all();
            $bank = BankModel::all();
            // return view('instansi.edit')->with(compact('negara','provinsi','kota'));
            return view('instansi.edit')->with(compact('instansi','provinsi','kota','bank','id'));
        } else {
            return redirect('/instansi/lengkapi/'.$instansi->id.'/'.$instansi->id_personal_pimp)
                ->with('pesan',"Mohon lengkapi Data Pimpinan terlebih dulu");
        }
    }
    public function update(Request $request) {
        $instansi = BuModel::where('id', $request->id)->first();

        if($instansi->npwp_pdf){
            $npwp_pdf_lama = $instansi->npwp_pdf;
        }
        if($instansi->logo){
            $logo_lama = $instansi->logo;
        }

        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);

        $request->validate([
            "nama_bu" => "required|min:3|max:500",
            "email" => "required|email",
            "telp" => "required|numeric|digits_between:6,20",
            "web" => "required|url|min:3|max:100",
            "alamat" => "required|min:3|max:100",
            "id_prop" => "required",
            "id_kota" => "required",
            "singkat_bu" => "required|min:2|max:100",
            // "nama_pimp" => "required|min:3|max:50",
            // "jab_pimp" => "required|min:3|max:50",
            // "email_pimp" => "required|email",
            // "hp_pimp" => "required|numeric|digits_between:6,20",
            "kontak_p" => "required|min:3|max:100",
            "jab_kontak_p" => "required|min:3|max:100",
            "email_kontak_p" => "required|email",
            "no_kontak_p" => "required|numeric|digits_between:6,20",
            "no_rek" => "sometimes|nullable|min:4|max:20",
            "id_bank" => "sometimes|nullable|required_with:no_rek",
            "nama_rek" => "sometimes|nullable|required_with:no_rek|min:3|max:100",
            'npwpClean' => 'sometimes|nullable|numeric|digits:15',
            "npwp_pdf" => "sometimes|nullable|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048",
            "logo" => "mimes:jpeg,png,jpg,gif,svg|max:2048"
        ], [
            'nama_bu.required' => 'Mohon isi Nama Instansi',
            'nama_bu.min' => 'Nama Instansi minimal 3 karakter',
            'nama_bu.max' => 'Nama Instansi maksimal 200 karakter',
            'email.required' => 'Mohon isi Email Instansi',
            'email.email' => 'Mohon isi dengan format email yang valid',
            'telp.required' => 'Mohon isi Nomor Telepon Instansi',
            'telp.numeric' => 'Mohon hanya isi dengan angka',
            'telp.digits_between' => 'Mohon isi Nomor Telepon dengan formar yang valid',
            'web.required' => 'Mohon isi Website Instansi',
            'web.url' => 'Mohon isi Website dengan format yang valid (diawali dengan http:// atau https://)',
            'web.min' => 'Website minimal 3 karakter',
            'web.max' => 'Website maksimal 100 karakter',
            'alamat.required' => 'Mohon isi Alamat Instansi',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'id_prop.required' => 'Mohon isi Provinsi',
            'id_kota.required' => 'Mohon isi Kota',
            'singkat_bu' => 'Mohon isi Nama Singkat Instansi',
            'singkat_bu.min' => 'Nama Singkat minimal 3 karakter',
            'singkat_bu.max' => 'Nama Singkat maksimal 100 karakter',
            // 'nama_pimp.required' => 'Mohon isi Nama Pimpinan',
            // 'nama_pimp.min' => 'Nama Pimpinan minimal 3 karakter',
            // 'nama_pimp.max' => 'Nama Pimpinan maksimal 50 karakter',
            // 'jab_pimp.required' => 'Mohon isi Jabatan Pimpinan',
            // 'jab_pimp.min' => 'Jabatan Pimpinan minimal 3 karakter',
            // 'jab_pimp.max' => 'Jabatan Pimpinan maksimal 50 karakter',
            // 'email_pimp.required' => 'Mohon isi Email Pimpinan',
            // 'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
            // 'hp_pimp.required' => 'Mohon isi Nomor Telepon Pimpinan',
            // 'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            // 'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            // 'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
            // 'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'kontak_p.required' => 'Mohon isi Nama Contact Person',
            'kontak_p.min' => 'Contact Person minimal 3 karakter',
            'kontak_p.max' => 'Contact Person maksimal 100 karakter',
            'jab_kontak_p.required' => 'Mohon isi Jabatan Contact Person',
            'jab_kontak_p.min' => 'Jabatan Contact Person minimal 3 karakter',
            'jab_kontak_p.max' => 'Jabatan Contact Person maksimal 100 karakter',
            'email_kontak_p.required' => 'Mohon isi Email Contact Person',
            'email_kontak_p.email' => 'Mohon isi dengan format Email yang valid',
            'no_kontak_p.required' => 'Mohon isi Nomor Telepon Contact Person',
            'no_kontak_p.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_kontak_p.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_kontak_p.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'no_rek.min' => 'Nomor Rekening minimal 4 digit',
            'no_rek.max' => 'Nomor Rekening maksimal 20 digit',
            'id_bank.required_with' => 'Mohon lengkapi Nama Bank',
            'nama_rek.required_with' => 'Mohon lengkapi Nama Pada Rekening',
            'nama_rek.min' => 'Nama pada Rekening minimal 3 karakter',
            'nama_rek.max' => 'Nama pada Rekening maksimal 100 karakter',
            'npwpClean.numeric' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.digits' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwpClean.gt' => 'Mohon masukkan NPWP dengan format yang valid',
            'npwp_pdf.mimes' => 'Mohon isi Lampiran NPWP dengan file gambar atau PDF',
            'npwp_pdf.max' => 'Lampiran Maksimal 2MB',
            'logo.required' => 'Mohon lampirkan Logo Instansi',
            'logo.mimes' => 'Mohon lampirkan Logo berupa gambar',
            'logo.max' => 'Logo maksimal berukuran 2MB',
        ]);

        if($request->email != $instansi->email ) {
            $request->validate([
                'email' => "required|email|unique:badan_usaha",
            ],[
                'email.required' => 'Mohon isi Email Instansi',
                'email.email' => 'Mohon isi dengan format email yang valid',
                'email.unique' => 'Email sudah terdaftar',
            ]);
        }


        if($request->telp != $instansi->telp ) {
            $request->validate([
                "telp" => "required|numeric|digits_between:6,20|unique:badan_usaha",
            ],[
                'telp.required' => 'Mohon isi Nomor Telepon Instansi',
                'telp.numeric' => 'Mohon hanya isi dengan angka',
                'telp.digits_between' => 'Mohon isi Nomor Telepon dengan formar yang valid',
            ]);
        }

        // if($request->email_pimp != $instansi->email_pimp ) {
        //     $request->validate([
        //         "email_pimp" => "required|email|unique:badan_usaha",
        //     ],[
        //         'email_pimp.required' => 'Mohon isi Email Pimpinan',
        //         'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
        //         'email_pimp.unique' => 'Email sudah terdaftar',
        //     ]);
        // }

        // if($request->hp_pimp != $instansi->hp_pimp ) {
        //     $request->validate([
        //         "hp_pimp" => "required|numeric|digits_between:6,20|unique:badan_usaha",
        //     ],[
        //         'hp_pimp.required' => 'Mohon isi Nomor Telepon Pimpinan',
        //         'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
        //         'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
        //         'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
        //         'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
        //     ]);
        // }

        if($request->email_kontak_p != $instansi->email_kontak_p ) {
            $request->validate([
                "email_kontak_p" => "required|email|unique:badan_usaha",
            ],[
                'email_kontak_p.required' => 'Mohon isi Email Contact Person',
                'email_kontak_p.email' => 'Mohon isi dengan format Email yang valid',
                'email_kontak_p.unique' => 'Email sudah terdaftar',
            ]);
        }

        if($request->no_kontak_p != $instansi->no_kontak_p ) {
            $request->validate([
                "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha",
            ],[
                'no_kontak_p.required' => 'Mohon isi Nomor Telepon Contact Person',
                'no_kontak_p.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'no_kontak_p.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'no_kontak_p.unique' => 'Nomor Telepon sudah terdaftar',
                'no_kontak_p.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            ]);
        }

        $data = BuModel::find($request->id);
        $data->nama_bu          = $request->nama_bu                     ;
        $data->email            = $request->email                       ;
        $data->telp             = $request->telp                        ;
        $data->web              = $request->web                         ;
        $data->alamat           = $request->alamat                      ;
        $data->id_prop          = $request->id_prop                     ;
        $data->id_kota          = $request->id_kota                     ;
        $data->singkat_bu       = $request->singkat_bu                  ;
        // $data->nama_pimp        = $request->nama_pimp                   ;
        // $data->jab_pimp         = $request->jab_pimp                    ;
        // $data->email_pimp       = $request->email_pimp                  ;
        // $data->hp_pimp          = $request->hp_pimp                     ;
        $data->kontak_p         = $request->kontak_p                    ;
        $data->jab_kontak_p     = $request->jab_kontak_p                ;
        $data->email_kontak_p   = $request->email_kontak_p              ;
        $data->no_kontak_p      = $request->no_kontak_p                 ;
        $data->no_rek           = $request->no_rek                      ;
        $data->id_bank          = $request->id_bank                     ;
        $data->nama_rek         = $request->nama_rek                    ;
        $data->npwp             = $request->npwp                        ;

        $data->updated_by       = Auth::id()                            ;
        $data->updated_at       = Carbon::now()->toDateTimeString()    ;

        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama_bu);

        if ($files = $request->file('npwp_pdf')) {
            $destinationPath = 'uploads/lampiran/badan_usaha/'.$dir_name; // upload path
            $file = $dir_name."_lampiran_npwp_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->npwp_pdf = $destinationPath."/".$file;
            // if($npwp_pdf_lama) {
            //     if (file_exists(public_path()."/".$data->npwp_pf) && file_exists(public_path()."/".$npwp_pdf_lama)) {
            //         // mkdir($destinationPath, 777, true);
            //         unlink(public_path()."/".$npwp_pdf_lama);
            //     }
            // }

        }

        if ($files = $request->file('logo')) {
            $destinationPath = 'uploads/lampiran/badan_usaha/'.$dir_name; // upload path
            if (!is_dir($destinationPath)) {
                // mkdir($destinationPath, 777, true);
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
            }
            $file = $dir_name."_lampiran_foto_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path
            $resize_image = Image::make($files);
            // $resize_image->resize(354, 472)->save($destinationPathTemp.$file);
            $resize_image->resize(250,null, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path($destinationPathTemp.$file));
            $temp = $destinationPathTemp.$file;
            rename($temp, $destinationFile );
            $data->logo = $destinationFile;

            // if($logo_lama) {
            //     if (file_exists(public_path()."/".$data->logo) && file_exists(public_path()."/".$logo_lama)) {
            //         // mkdir($destinationPath, 777, true);
            //         unlink(public_path()."/".$logo_lama);
            //     }
            // }

        }
        $instansi = $data->save();
        return redirect('/instansi')->with('pesan',"Instansi \"".$request->nama_bu.
        "\" berhasil diubah");
    }
    public function destroy(Request $request) {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        $pers = BuModel::whereIn('id', $idData)->pluck('id_personal_pimp');

        if($pers){
            $msg = "Gagal menghapus! \nMohon hapus personal yang terkait pada badan usaha terlebih dahulu!";
            return redirect()->back()->with('errHapus',$msg);
        }
        BuModel::whereIn('id', $idData)->update($user_data);
        return redirect('/instansi')
        ->with('pesan',"Berhasil menghapus instansi");
    }
    public function getKota($id) {
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }

    public function changelevelatas(Request $request){
        return $data = KantorModel::where('level','=',$request->id_level_k-1)->get(['id','nama_kantor as text']);
    }


    public function filterprovbu(Request $req){
        $idkota = BUModel::select('id_kota')->groupBy('id_kota')->get()->toArray();
        $kota = KotaModel::whereIn('id',$idkota)->where('provinsi_id',$req->prov)->get(['id','nama as text']);
        return $kota;
    }


}
