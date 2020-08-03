<?php

namespace App\Http\Controllers;


// use App\NegaraModel;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\BankModel;

use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use File;
use DB;

class InstansiController extends Controller
{
    //
    public function index () {
        $instansi = BuModel::where('deleted_at',NULL)->get();
        return view('instansi.index')->with(compact('instansi'));
    }
    public function show ($id) {
        $instansi = BuModel::where('id', $id)->first();
        // $negara = NegaraModel::where('id', $id)->first();
        $provinsi = ProvinsiModel::where('id', $instansi->id_prop)->first();
        $kota = KotaModel::where('id', $instansi->id_kota)->first();
        $bank = BankModel::where('id_bank', $instansi->id_bank)->first();
        return view('instansi.show')->with(compact('instansi','provinsi','kota','bank','id'));

    }
    public function create() {
        // $negara = NegaraModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $bank = BankModel::all();
        // return view('instansi.create')->with(compact('negara','provinsi','kota'));
        return view('instansi.create')->with(compact('provinsi','kota','bank'));
    }
    public function store(Request $request) {
        $request->npwpClean = preg_replace('/\s+/', "",  $request->npwp);
        $request->npwpClean = preg_replace("/[\.-]/", "",  $request->npwpClean);

        $request->validate([
            "nama_bu" => "required|min:3|max:50",
            "email" => "required|email|unique:badan_usaha",
            "telp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            "web" => "required|url|min:3|max:100",
            "alamat" => "required|min:3|max:100",
            "id_prop" => "required",
            "id_kota" => "required",
            "singkat_bu" => "required|min:3|max:50",
            "nama_pimp" => "required|min:3|max:50",
            "jab_pimp" => "required|min:3|max:50",
            "email_pimp" => "required|email|unique:badan_usaha",
            "hp_pimp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            "kontak_p" => "required|min:3|max:50",
            "jab_kontak_p" => "required|min:3|max:50",
            "email_kontak_p" => "required|email|unique:badan_usaha",
            "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            "no_rek" => "sometimes|nullable|min:4|max:20",
            "id_bank" => "sometimes|required_with:no_rek",
            "nama_rek" => "sometimes|nullable|required_with:no_rek|min:3|max:50",
            'npwpClean' => 'sometimes|nullable|numeric|digits:15|gt:0',
            "npwp_pdf" => "sometimes|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048",
            "logo" => "required|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ],[
            'nama_bu.required' => 'Mohon isi Nama Instansi',
            'nama_bu.min' => 'Nama Instansi minimal 3 karakter',
            'nama_bu.max' => 'Nama Instansi maksimal 50 karakter',
            'email.required' => 'Mohon isi Email Instansi',
            'email.email' => 'Mohon isi dengan format email yang valid',
            'email.unique' => 'Email sudah terdaftar',
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
            'singkat_bu.max' => 'Nama Singkat maksimal 50 karakter',
            'nama_pimp.required' => 'Mohon isi Nama Pimpinan',
            'nama_pimp.min' => 'Nama Pimpinan minimal 3 karakter',
            'nama_pimp.max' => 'Nama Pimpinan maksimal 50 karakter',
            'jab_pimp.required' => 'Mohon isi Jabatan Pimpinan',
            'jab_pimp.min' => 'Jabatan Pimpinan minimal 3 karakter',
            'jab_pimp.max' => 'Jabatan Pimpinan maksimal 50 karakter',
            'email_pimp.required' => 'Mohon isi Email Pimpinan',
            'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
            'email_pimp.unique' => 'Email sudah terdaftar',
            'hp_pimp.required' => 'Mohon isi Nomor Telepon Pimpinan',
            'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
            'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'kontak_p.required' => 'Mohon isi Nama Contact Person',
            'kontak_p.min' => 'Contact Person minimal 3 karakter',
            'kontak_p.max' => 'Contact Person maksimal 50 karakter',
            'jab_kontak_p.required' => 'Mohon isi Jabatan Contact Person',
            'jab_kontak_p.min' => 'Jabatan Contact Person minimal 3 karakter',
            'jab_kontak_p.max' => 'Jabatan Contact Person maksimal 50 karakter',
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
            'nama_rek.max' => 'Nama pada Rekening maksimal 50 karakter',
            'npwpClean.numeric' => 'Mohon masukkan NPWP dengan format yang valid', 
            'npwpClean.digits' => 'Mohon masukkan NPWP dengan format yang valid', 
            'npwpClean.gt' => 'Mohon masukkan NPWP dengan format yang valid', 
            'npwp_pdf.mimes' => 'Mohon isi Lampiran NPWP dengan file gambar atau PDF',
            'npwp_pdf.max' => 'Lampiran Maksimal 2MB',
            'logo.required' => 'Mohon lampirkan Logo Instansi',
            'logo.mimes' => 'Mohon lampirkan Logo berupa gambar',
            'logo.max' => 'Logo maksimal berukuran 2MB',
        ]);
        
        $data = new BuModel;
        $data->nama_bu          = $request->nama_bu        ;  
        $data->email            = $request->email          ; 
        $data->telp             = $request->telp           ; 
        $data->web              = $request->web            ;           
        $data->alamat           = $request->alamat         ;       
        $data->id_prop          = $request->id_prop        ;       
        $data->id_kota          = $request->id_kota        ;   
        $data->singkat_bu       = $request->singkat_bu     ;      
        $data->nama_pimp        = $request->nama_pimp      ;     
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
            if (!file_exists($destinationPath)) {
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
        $instansi = $data->save();
        return redirect('/instansi')->with('pesan',"Instansi \"".$request->nama_bu.
        "\" berhasil ditambahkan");
    }
    public function edit($id) {
        $instansi = BuModel::where('id',$id)->first();
        // $negara = NegaraModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $bank = BankModel::all();
        // return view('instansi.edit')->with(compact('negara','provinsi','kota'));
        return view('instansi.edit')->with(compact('instansi','provinsi','kota','bank','id'));

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
            "nama_bu" => "required|min:3|max:50",
            "email" => "required|email",
            "telp" => "required|numeric|digits_between:6,20|gt:0",
            "web" => "required|url|min:3|max:100",
            "alamat" => "required|min:3|max:100",
            "id_prop" => "required",
            "id_kota" => "required",
            "singkat_bu" => "required|min:3|max:50",
            "nama_pimp" => "required|min:3|max:50",
            "jab_pimp" => "required|min:3|max:50",
            "email_pimp" => "required|email",
            "hp_pimp" => "required|numeric|digits_between:6,20|gt:0",
            "kontak_p" => "required|min:3|max:50",
            "jab_kontak_p" => "required|min:3|max:50",
            "email_kontak_p" => "required|email",
            "no_kontak_p" => "required|numeric|digits_between:6,20|gt:0",
            "no_rek" => "sometimes|nullable|min:4|max:20",
            "id_bank" => "sometimes|nullable|required_with:no_rek",
            "nama_rek" => "sometimes|nullable|required_with:no_rek|min:3|max:50",
            'npwpClean' => 'sometimes|nullable|numeric|digits:15|gt:0',
            "npwp_pdf" => "sometimes|nullable|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048",
            "logo" => "mimes:jpeg,png,jpg,gif,svg|max:2048"
        ], [
            'nama_bu.required' => 'Mohon isi Nama Instansi',
            'nama_bu.min' => 'Nama Instansi minimal 3 karakter',
            'nama_bu.max' => 'Nama Instansi maksimal 50 karakter',
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
            'singkat_bu.max' => 'Nama Singkat maksimal 50 karakter',
            'nama_pimp.required' => 'Mohon isi Nama Pimpinan',
            'nama_pimp.min' => 'Nama Pimpinan minimal 3 karakter',
            'nama_pimp.max' => 'Nama Pimpinan maksimal 50 karakter',
            'jab_pimp.required' => 'Mohon isi Jabatan Pimpinan',
            'jab_pimp.min' => 'Jabatan Pimpinan minimal 3 karakter',
            'jab_pimp.max' => 'Jabatan Pimpinan maksimal 50 karakter',
            'email_pimp.required' => 'Mohon isi Email Pimpinan',
            'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
            'hp_pimp.required' => 'Mohon isi Nomor Telepon Pimpinan',
            'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
            'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            'kontak_p.required' => 'Mohon isi Nama Contact Person',
            'kontak_p.min' => 'Contact Person minimal 3 karakter',
            'kontak_p.max' => 'Contact Person maksimal 50 karakter',
            'jab_kontak_p.required' => 'Mohon isi Jabatan Contact Person',
            'jab_kontak_p.min' => 'Jabatan Contact Person minimal 3 karakter',
            'jab_kontak_p.max' => 'Jabatan Contact Person maksimal 50 karakter',
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
            'nama_rek.max' => 'Nama pada Rekening maksimal 50 karakter',
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
                "telp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            ],[
                'telp.required' => 'Mohon isi Nomor Telepon Instansi',
                'telp.numeric' => 'Mohon hanya isi dengan angka',
                'telp.digits_between' => 'Mohon isi Nomor Telepon dengan formar yang valid',
            ]);
        }

        if($request->email_pimp != $instansi->email_pimp ) {
            $request->validate([
                "email_pimp" => "required|email|unique:badan_usaha",
            ],[
                'email_pimp.required' => 'Mohon isi Email Pimpinan',
                'email_pimp.email' => 'Mohon isi dengan format Email yang valid',
                'email_pimp.unique' => 'Email sudah terdaftar',
            ]);
        }

        if($request->hp_pimp != $instansi->hp_pimp ) {
            $request->validate([
                "hp_pimp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            ],[
                'hp_pimp.required' => 'Mohon isi Nomor Telepon Pimpinan',
                'hp_pimp.digits_between' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'hp_pimp.numeric' => 'Mohon isi Nomor Telepon dengan format yang valid',
                'hp_pimp.unique' => 'Nomor Telepon sudah terdaftar',
                'hp_pimp.gt' => 'Mohon isi Nomor Telepon dengan format yang valid',
            ]);
        }

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
                "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
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
        $data->nama_pimp        = $request->nama_pimp                   ;     
        $data->jab_pimp         = $request->jab_pimp                    ;      
        $data->email_pimp       = $request->email_pimp                  ;    
        $data->hp_pimp          = $request->hp_pimp                     ;       
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
            if($npwp_pdf_lama) {
                if (file_exists(public_path()."/".$data->npwp_pf) && file_exists(public_path()."/".$npwp_pdf_lama)) {
                    // mkdir($destinationPath, 777, true);
                    unlink(public_path()."/".$npwp_pdf_lama);
                }
            }
            
        }

        if ($files = $request->file('logo')) {
            $destinationPath = 'uploads/lampiran/badan_usaha/'.$dir_name; // upload path
            if (!file_exists($destinationPath)) {
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

            if($logo_lama) {
                if (file_exists(public_path()."/".$data->logo) && file_exists(public_path()."/".$logo_lama)) {
                    // mkdir($destinationPath, 777, true);
                    unlink(public_path()."/".$logo_lama);
                }
            }
            
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

}
