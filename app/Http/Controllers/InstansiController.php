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
            "nama_pimp" => "required|min:3|max:50",
            "jab_pimp" => "required|min:3|max:50",
            "email_pimp" => "required|email|unique:badan_usaha",
            "hp_pimp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            "kontak_p" => "required|min:3|max:50",
            "jab_kontak_p" => "required|min:3|max:50",
            "email_kontak_p" => "required|email|unique:badan_usaha",
            "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            "no_rek" => "digits_between:5,20|unique:badan_usaha|gt:0",
            "id_bank" => "",
            "nama_rek" => "min:3|max:50",
            'npwpClean' => 'numeric|digits:15|gt:0',
            "npwp_pdf" => "mimes:pdf,jpeg,png,jpg,gif,svg|max:2048"
        ]);
        
        $data = new BuModel;
        $data->nama_bu          = $request->nama_bu        ;  
        $data->email            = $request->email          ; 
        $data->telp             = $request->telp           ; 
        $data->web              = $request->web            ;           
        $data->alamat           = $request->alamat         ;       
        $data->id_prop          = $request->id_prop        ;       
        $data->id_kota          = $request->id_kota        ;       
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
            "nama_pimp" => "required|min:3|max:50",
            "jab_pimp" => "required|min:3|max:50",
            "email_pimp" => "required|email",
            "hp_pimp" => "required|numeric|digits_between:6,20|gt:0",
            "kontak_p" => "required|min:3|max:50",
            "jab_kontak_p" => "required|min:3|max:50",
            "email_kontak_p" => "required|email",
            "no_kontak_p" => "required|numeric|digits_between:6,20|gt:0",
            "no_rek" => "digits_between:5,20|gt:0",
            "id_bank" => "",
            "nama_rek" => "min:3|max:50",
            'npwpClean' => 'numeric|digits:15|gt:0',
            "npwp_pdf" => "mimes:pdf,jpeg,png,jpg,gif,svg|max:2048"
        ]);

        if($request->email != $instansi->email ) {
            $request->validate([
                'email' => "required|email|unique:badan_usaha",
            ]);
        }

        if($request->telp != $instansi->telp ) {
            $request->validate([
                "telp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            ]);
        }

        if($request->email_pimp != $instansi->email_pimp ) {
            $request->validate([
                "email_pimp" => "required|email|unique:badan_usaha",
            ]);
        }

        if($request->hp_pimp != $instansi->hp_pimp ) {
            $request->validate([
                "hp_pimp" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            ]);
        }

        if($request->email_kontak_p != $instansi->email_kontak_p ) {
            $request->validate([
                "email_kontak_p" => "required|email|unique:badan_usaha",
            ]);
        }

        if($request->no_kontak_p != $instansi->no_kontak_p ) {
            $request->validate([
                "no_kontak_p" => "required|numeric|digits_between:6,20|unique:badan_usaha|gt:0",
            ]);
        }

        if($request->no_rek != $instansi->no_rek ) {
            $request->validate([
                "no_rek" => "digits_between:5,20|unique:badan_usaha|gt:0",
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
