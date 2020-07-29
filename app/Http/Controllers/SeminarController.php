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
        $pimpinan = BuModel::pluck('nama_pimp','id');
        return view('seminar.create')->with(compact('inisiator','provinsi','kota','instansi','pendukung','pimpinan'));
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
        ],[
            'nama_seminar.required' => 'Mohon isi Nama Seminar',
            'nama_seminar.min' => 'Nama Seminar minimal 3 karakter',
            'nama_seminar.max' => 'Nama Seminar maksimal 50 karakter',
            'klasifikasi.required' => 'Mohon isi Klasifikasi',
            'sub_klasifikasi.required' => 'Mohon isi Sub-klasifikasi',
            'tema.required' => 'Mohon isi Tema Seminar',
            'tema.min' => 'Tema Seminar minimal 3 karakter',
            'tema.max' => 'Tema Seminar maksimal 200 karakter',
            'kuota.required' => 'Mohon isi jumlah Kuota Peserta Seminar',
            'kuota.numeric' => 'Mohon hanya mengisi dengan angka',
            'kuota.min' => 'Kuota jumlah peserta minimal 5 orang',
            'skpk_nilai.required' => 'Mohon isi Nilai SKPK',
            'skpk_nilai.numeric' => 'Mohon mengisi dengan angka',
            'skpk_nilai.min' => 'Nilai SKPK minimal 0',
            'skpk_nilai.max' => 'Nilai SKPK maksimal 25',
            'is_free' => 'Mohon pilih jenis seminar',
            'biaya.required_if' => 'Jika seminar berbayar, mohon isi harga',
            'inisiator.required' => 'Mohon isi Inisiator',
            'instansi_penyelenggara' => 'Mohon isi Instansi Penyelenggara',
            'instansi_pendukung' => 'Mohon isi Instansi Pendukung',
            'tgl_awal.required' => 'Mohon isi Tanggal Mulai Seminar',
            'tgl_awal.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.required' => 'Mohon isi Tanggal Berakhir Seminar',
            'tgl_akhir.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.after_or_equal' => 'Tanggal Berakhir harus sesudah Tanggal Mulai',
            'jam_awal.required' => 'Mohon isi Waktu Mulai Seminar',
            'jam_awal.date_format' => 'Mohon isi dengan format Waktu yang valid',
            'jam_akhir.required' => 'Mohon isi Jam Berakhir Seminar',
            'jam_akhir.date_format' => 'Mohon isi dengan format waktu yang valid',
            'jam_akhir.after' => 'Waktu Berakhir harus sesudah Waktu Mulai',
            //ttd pemangku
            'prov_penyelenggara.required' => 'Mohon isi Provinsi Lokasi Seminar',
            'kota_penyelenggara.required' => 'Mohon isi Kota Lokasi Seminar',
            'lokasi_penyelenggara.required' => 'Mohon isi Alamat Lokasi Seminar',
            'lokasi_penyelenggara.min' => 'Alamat Lokasi Seminar minimal 3 karakter',
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 50 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'narasumber.min' => 'Narasumber minimal 3 karakter',
            'narasumber.max' => 'Narasumber maksimal 50 karakter',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',
            
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
        $data->ttd_pemangku              =              $request->ttd_pemangku           ;
        
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
        $pimpinan = BuModel::pluck('nama_pimp','id');
        return view('seminar.edit')->with(compact('seminar','inisiator','provinsi',
        'kota','instansi','pendukung','id','pimpinan'));
    }

    public function update(Request $request, $id) {
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
        ],[
            'nama_seminar.required' => 'Mohon isi Nama Seminar',
            'nama_seminar.min' => 'Nama Seminar minimal 3 karakter',
            'nama_seminar.max' => 'Nama Seminar maksimal 50 karakter',
            'klasifikasi.required' => 'Mohon isi Klasifikasi',
            'sub_klasifikasi.required' => 'Mohon isi Sub-klasifikasi',
            'tema.required' => 'Mohon isi Tema Seminar',
            'tema.min' => 'Tema Seminar minimal 3 karakter',
            'tema.max' => 'Tema Seminar maksimal 200 karakter',
            'kuota.required' => 'Mohon isi jumlah Kuota Peserta Seminar',
            'kuota.numeric' => 'Mohon hanya mengisi dengan angka',
            'kuota.min' => 'Kuota jumlah peserta minimal 5 orang',
            'skpk_nilai.required' => 'Mohon isi Nilai SKPK',
            'skpk_nilai.numeric' => 'Mohon mengisi dengan angka',
            'skpk_nilai.min' => 'Nilai SKPK minimal 0',
            'skpk_nilai.max' => 'Nilai SKPK maksimal 25',
            'is_free' => 'Mohon pilih jenis seminar',
            'biaya.required_if' => 'Jika seminar berbayar, mohon isi harga',
            'inisiator.required' => 'Mohon isi Inisiator',
            'instansi_penyelenggara' => 'Mohon isi Instansi Penyelenggara',
            'instansi_pendukung' => 'Mohon isi Instansi Pendukung',
            'tgl_awal.required' => 'Mohon isi Tanggal Mulai Seminar',
            'tgl_awal.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.required' => 'Mohon isi Tanggal Berakhir Seminar',
            'tgl_akhir.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.after_or_equal' => 'Tanggal Berakhir harus sesudah Tanggal Mulai',
            'jam_awal.required' => 'Mohon isi Waktu Mulai Seminar',
            'jam_awal.date_format' => 'Mohon isi dengan format Waktu yang valid',
            'jam_akhir.required' => 'Mohon isi Jam Berakhir Seminar',
            'jam_akhir.date_format' => 'Mohon isi dengan format waktu yang valid',
            'jam_akhir.after' => 'Waktu Berakhir harus sesudah Waktu Mulai',
            //ttd pemangku
            'prov_penyelenggara.required' => 'Mohon isi Provinsi Lokasi Seminar',
            'kota_penyelenggara.required' => 'Mohon isi Kota Lokasi Seminar',
            'lokasi_penyelenggara.required' => 'Mohon isi Alamat Lokasi Seminar',
            'lokasi_penyelenggara.min' => 'Alamat Lokasi Seminar minimal 3 karakter',
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 50 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'narasumber.min' => 'Narasumber minimal 3 karakter',
            'narasumber.max' => 'Narasumber maksimal 50 karakter',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',
            
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
        $data->ttd_pemangku              =              $request->ttd_pemangku           ;
            
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
