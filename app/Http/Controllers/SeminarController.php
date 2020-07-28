<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\SeminarModel;
use App\InstansiModel;
use App\ProvinsiModel;
use App\KotaModel;
use App\BuModel;
use App\Peserta;
use App\PesertaSeminar;
use App\NarasumberModel;
use App\ModeratorModel;
use DB;

class SeminarController extends Controller
{
    //
    public function index() {
        $seminar = SeminarModel::where('deleted_at', NULL)->get();
        return view('seminar.index')->with(compact('seminar'));
    }

    public function create() {
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $instansi = BuModel::all();
        $pendukung = BuModel::pluck('nama_bu','id');
        return view('seminar.create')->with(compact('inisiator','provinsi','kota','instansi','pendukung'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_seminar' => 'required|min:3|max:50',
            'klasifikasi' => 'required',
            'sub_klasifikasi' => 'required',
            'tema' => 'required|min:5|max:200',
            'kuota' => 'required|numeric|min:5',
            'skpk_nilai' => 'required|numeric|min:0|max:25',
            'is_free' => 'required',
            'biaya' => 'required_if:is_free,==,1',
            'inisiator' => 'required',
            'instansi_penyelenggara' => 'required',
            'instansi_pendukung' => 'required',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            // 'ttd_pemangku' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:50',
            'narasumber' => 'required|min:3|max:50',
            'moderator' => 'required|min:3|max:50'
        ]);


        $request->instansi_penyelenggara = implode(",", $request->instansi_penyelenggara);
        $request->instansi_pendukung     = implode(",", $request->instansi_pendukung    );
        // $request->klasifikasi            = implode(",", $request->klasifikasi           );
        // $request->sub_klasifikasi        = implode(",", $request->sub_klasifikasi       );
        $request->ttd_pemangku           = implode(",", $request->ttd_pemangku          );
                
        $data = new SeminarModel;
        $data->nama_seminar              =              $request->nama_seminar           ;
        // $data->klasifikasi               =              $request->klasifikasi            ;
        // $data->sub_klasifikasi           =              $request->sub_klasifikasi        ;
        $data->tema                      =              $request->tema                   ;
        $data->kuota                     =              $request->kuota                  ;
        $data->skpk_nilai                =              $request->skpk_nilai             ;
        $data->is_free                   =              $request->is_free                ;
        $data->biaya                     =              $request->biaya                  ;
        $data->inisiator                 =              $request->inisiator              ;
        $data->instansi_penyelenggara    =              $request->instansi_penyelenggara ;
        $data->instansi_pendukung        =              $request->instansi_pendukung     ;
        $data->tgl_awal                  =Carbon::parse($request->tgl_awal)              ;
        $data->tgl_akhir                 =Carbon::parse($request->tgl_akhir)             ;
        $data->jam_awal                  =              $request->jam_awal               ;
        $data->jam_akhir                 =              $request->jam_akhir              ;
        // $data->ttd_pemangku              =              $request->ttd_pemangku           ;
        $data->prov_penyelenggara        =              $request->prov_penyelenggara     ;
        $data->kota_penyelenggara        =              $request->kota_penyelenggara     ;
        $data->lokasi_penyelenggara      =              $request->lokasi_penyelenggara   ;
        
        $narasumber = new NarasumberModel;
        $narasumber->nama = $request->narasumber;
        $narasumber->save();

        $moderator = new ModeratorModel;
        $moderator->nama = $request->moderator;
        $moderator->save();
        $data->created_by = Auth::id();
        if($request->store == "draft") {
            $data->is_actived = "0";
            $seminar = $data->save();
        
            $narasumber_seminar = new PesertaSeminar;
            $narasumber_seminar->id_peserta = $narasumber->id;
            $narasumber_seminar->status = "2";
            $narasumber_seminar->id_seminar = $data->id;
            $narasumber_seminar->save();
    
            $moderator_seminar = new PesertaSeminar;
            $moderator_seminar->id_peserta = $moderator->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();
    
            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil disimpan sebagai draft");
        } else {
            $data->is_actived = "1";
            $seminar = $data->save();
        
            $narasumber_seminar = new PesertaSeminar;
            $narasumber_seminar->id_peserta = $narasumber->id;
            $narasumber_seminar->status = "2";
            $narasumber_seminar->id_seminar = $data->id;
            $narasumber_seminar->save();
    
            $moderator_seminar = new PesertaSeminar;
            $moderator_seminar->id_peserta = $moderator->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();
    
            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil ditambahkan");
        }

    }

    public function edit($id) {
        $seminar = SeminarModel::where('id',$id)->first();
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $instansi = BuModel::all();
        $pendukung = BuModel::pluck('nama_bu','id');
        return view('seminar.edit')->with(compact('seminar','inisiator','provinsi',
        'kota','instansi','pendukung','id'));
    }

    public function update(Request $request, $id) {
        dd($request);
        $request->validate([
            'nama_seminar' => 'required|min:3|max:50',
            'klasifikasi' => 'required',
            'sub_klasifikasi' => 'required',
            'tema' => 'required|min:5|max:200',
            'kuota' => 'required|numeric|min:5',
            'skpk_nilai' => 'required|numeric|min:0|max:25',
            'is_free' => 'required',
            'biaya' => 'required_if:is_free,==,1',
            'inisiator' => 'required',
            'instansi_penyelenggara' => 'required',
            'instansi_pendukung' => 'required',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            // 'ttd_pemangku' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:50',
        ]);


        $request->instansi_penyelenggara = implode(",", $request->instansi_penyelenggara);
        $request->instansi_pendukung     = implode(",", $request->instansi_pendukung    );
        // $request->klasifikasi            = implode(",", $request->klasifikasi           );
        // $request->sub_klasifikasi        = implode(",", $request->sub_klasifikasi       );
        $request->ttd_pemangku           = implode(",", $request->ttd_pemangku          );
                
        $data = SeminarModel::find($id);
        $data->nama_seminar              =              $request->nama_seminar           ;
        // $data->klasifikasi               =              $request->klasifikasi            ;
        // $data->sub_klasifikasi           =              $request->sub_klasifikasi        ;
        $data->tema                      =              $request->tema                   ;
        $data->kuota                     =              $request->kuota                  ;
        $data->skpk_nilai                =              $request->skpk_nilai             ;
        $data->is_free                   =              $request->is_free                ;
        $data->biaya                     =              $request->biaya                  ;
        $data->inisiator                 =              $request->inisiator              ;
        $data->instansi_penyelenggara    =              $request->instansi_penyelenggara ;
        $data->instansi_pendukung        =              $request->instansi_pendukung     ;
        $data->tgl_awal                  =Carbon::parse($request->tgl_awal)              ;
        $data->tgl_akhir                 =Carbon::parse($request->tgl_akhir)             ;
        $data->jam_awal                  =              $request->jam_awal               ;
        $data->jam_akhir                 =              $request->jam_akhir              ;
        // $data->ttd_pemangku              =              $request->ttd_pemangku           ;
        $data->prov_penyelenggara        =              $request->prov_penyelenggara     ;
        $data->kota_penyelenggara        =              $request->kota_penyelenggara     ;
        $data->lokasi_penyelenggara      =              $request->lokasi_penyelenggara   ;
            
        $data->updated_by = Auth::id();
        $data->updated_at = Carbon::now()->toDateTimeString();

        if($request->store == "draft") {
            $data->is_actived = "0";
            $seminar = $data->save();
        
            $narasumber_seminar = new PesertaSeminar;
            $narasumber_seminar->id_peserta = $narasumber->id;
            $narasumber_seminar->status = "2";
            $narasumber_seminar->id_seminar = $data->id;
            $narasumber_seminar->save();
    
            $moderator_seminar = new PesertaSeminar;
            $moderator_seminar->id_peserta = $moderator->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();
    
            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil diubah sebagai draft");
        } else {
            $data->is_actived = "1";
            $seminar = $data->save();
        
            $narasumber_seminar = new PesertaSeminar;
            $narasumber_seminar->id_peserta = $narasumber->id;
            $narasumber_seminar->status = "2";
            $narasumber_seminar->id_seminar = $data->id;
            $narasumber_seminar->save();
    
            $moderator_seminar = new PesertaSeminar;
            $moderator_seminar->id_peserta = $moderator->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();
    
            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil diubah");
        }

    }

    public function destroy(Request $request) {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        SeminarModel::whereIn('id', $idData)->update($user_data);
        return redirect('/seminar')
        ->with('pesan',"Berhasil menghapus personal");
    }

    //detail seminar
    public function detail($id){
        $seminar = SeminarModel::where('id',$id)->first();
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $instansi = BuModel::all();
        $pendukung = BuModel::pluck('nama_bu','id');
        $detailseminar = PesertaSeminar::where('id_seminar','=',$id)->get();
        // dd($detailseminar);
        return view('seminar.detail')->with(compact('seminar','inisiator','provinsi','kota','instansi','pendukung','detailseminar'));
    }


    public function cetak_sert($id, $email){
        $data['data'] = SertModel::where('no_sertifikat',$id)->where('email', $email)->get();
        $pdf = PDF::loadview('sert.sert_v1',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }

    public function getKota($id) {
        $cities = DB::table("ms_kota")
                    ->where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }

    public function publish($id) {
        $data = SeminarModel::where('id',$id)->first();
        $data->is_actived = "1";
        $data->save();
        return redirect('/seminar')
        ->with('pesan',"Berhasil mempublikasi ".$data->nama_seminar);
    }

}
