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
use App\Personal;
use App\SertInstansiModel;
use App\TtdModel;
use PDF;
use Mail;
use App\NarasumberModel;
use App\ModeratorModel;
use DB;
use App\Mail\EmailLinkSert;

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
        $personal = Personal::all();
        return view('seminar.create')->with(compact('inisiator','provinsi','kota',
        'personal','instansi','pendukung','pimpinan'));
    }

    public function store(Request $request) {
        // dd($request);
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
            'tgl_awal' => 'required|date|after:today',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            'ttd_pemangku' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:50',
            'narasumber' => 'required',
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
            'tgl_awal.after' => 'Mohon isi tanggal sesudah hari ini',
            'tgl_akhir.required' => 'Mohon isi Tanggal Berakhir Seminar',
            'tgl_akhir.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.after_or_equal' => 'Tanggal Berakhir harus sesudah Tanggal Mulai',
            'jam_awal.required' => 'Mohon isi Waktu Mulai Seminar',
            'jam_awal.date_format' => 'Mohon isi dengan format Waktu yang valid',
            'jam_akhir.required' => 'Mohon isi Jam Berakhir Seminar',
            'jam_akhir.date_format' => 'Mohon isi dengan format waktu yang valid',
            'jam_akhir.after' => 'Waktu Berakhir harus sesudah Waktu Mulai',
            'ttd_pemangku.required' => 'Mohon isi Penandatangan',
            'prov_penyelenggara.required' => 'Mohon isi Provinsi Lokasi Seminar',
            'kota_penyelenggara.required' => 'Mohon isi Kota Lokasi Seminar',
            'lokasi_penyelenggara.required' => 'Mohon isi Alamat Lokasi Seminar',
            'lokasi_penyelenggara.min' => 'Alamat Lokasi Seminar minimal 3 karakter',
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 50 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',

        ]);

        // Just In Case aja, kalo masuknya string
        is_array($request->instansi_penyelenggara) ? '' : explode(',',$request->instansi_penyelenggara);
        is_array($request->instansi_pendukung) ? '' : explode(',',$request->instansi_pendukung);
        is_array($request->narasumber) ? '' : explode(',',$request->narasumber);
        is_array($request->ttd_pemangku) ? '' : explode(',',$request->ttd_pemangku);
        // Done

        $data = new SeminarModel;
        $data->nama_seminar              =              $request->nama_seminar           ;
        $data->tema                      =              $request->tema                   ;
        $data->kuota                     =              $request->kuota                  ;
        $data->skpk_nilai                =              $request->skpk_nilai             ;
        $data->is_free                   =              $request->is_free                ;
        $data->biaya                     =              $request->biaya                  ;
        $data->inisiator                 =              $request->inisiator              ;
        $data->tgl_awal                  =Carbon::parse($request->tgl_awal)              ;
        $data->tgl_akhir                 =Carbon::parse($request->tgl_akhir)             ;
        $data->jam_awal                  =              $request->jam_awal               ;
        $data->jam_akhir                 =              $request->jam_akhir              ;
        $data->prov_penyelenggara        =              $request->prov_penyelenggara     ;
        $data->kota_penyelenggara        =              $request->kota_penyelenggara     ;
        $data->lokasi_penyelenggara      =              $request->lokasi_penyelenggara   ;
        //$data->ttd_pemangku              =              $request->ttd_pemangku           ;

        $data->created_by = Auth::id();

        if($request->store == "draft") {
            $data->is_actived = "0";
            $data->status = "draft";

            $seminar = $data->save();

            // $data->instansi_penyelenggara    =   $request->instansi_penyelenggara ;
            foreach($request->instansi_penyelenggara as $key){
                $peny = new SertInstansiModel;
                $peny->id_seminar = $data->id;
                $peny->id_instansi = $key;
                $peny->created_by = Auth::id();
                $peny->status = '1';
                $peny->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->instansi_pendukung as $key){
                $pend = new SertInstansiModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->status = '2';
                $pend->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->ttd_pemangku as $key){
                $pend = new TtdModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->save();
            }

            // $data->narasumber        =   $request->narasumber     ;
            foreach($request->narasumber as $key){
                $nara = new NarasumberModel;
                $nara->id_seminar = $data->id;
                $nara->id_personal = $key;
                $nara->created_by = Auth::id();
                $nara->save();

                $narasumber_seminar = new PesertaSeminar;
                // $c_narasumber = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                // if($c_narasumber == null) {
                //     $narasumber_seminar->no_urut_peserta = '1';
                // } else {
                //     $narasumber_seminar->no_urut_peserta = $c_narasumber + 1;
                // }
                // // generate no sertifikat
                // $inisiator = '88';
                $status = '2';
                // $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
                // $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
                // $urutan_seminar = $data->no_urut;


                // $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);
                $narasumber_seminar->id_peserta = $nara->id;
                $narasumber_seminar->status = "2";
                // $narasumber_seminar->no_srtf = $no_sert_nara;
                $narasumber_seminar->id_seminar = $data->id;
                $narasumber_seminar->save();
            }

            $mode = new ModeratorModel;
            $mode->id_seminar = $data->id;
            $mode->nama = $request->moderator;
            $mode->created_by = Auth::id();
            $mode->save();

            $moderator_seminar = new PesertaSeminar;
            // $c_moderator = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
            //     if($c_moderator == null) {
            //         $moderator_seminar->no_urut_peserta = '1';
            //     } else {
            //         $moderator_seminar->no_urut_peserta = $c_moderator + 1;
            //     }

            // // generate no sertifikat
            // $inisiator = '88';
            $status = '4';
            // $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
            // $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
            // $urutan_seminar = $data->no_urut;
            // $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.(str_pad($moderator_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT));

            $moderator_seminar->id_peserta = $mode->id;
            $moderator_seminar->status = "4";
            // $moderator_seminar->no_srtf = $no_sert_mode;
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();

            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil ditambahkan sebagai draft");

        } else {

            $data->status = "published";
            $data->is_actived = "1";

            $counter = SeminarModel::all();
            $jumlah = array();
            if(count($counter) > 0) {
                foreach($counter as $key) {
                    if(date('m', \strtotime($key->tgl_awal)) == date('m', \strtotime($request->tgl_awal))){
                        $jumlah[] = $key->no_urut;
                    }
                }
            }
            if(count($jumlah) > 0){
                if(max($jumlah) > 0) {
                    $data->no_urut = max($jumlah) + 1;
                } else {
                    $data->no_urut = 1;
                }
            } else {
                $data->no_urut = 1;
            }

            $seminar = $data->save();

            // $data->instansi_penyelenggara    =   $request->instansi_penyelenggara ;
            foreach($request->instansi_penyelenggara as $key){
                $peny = new SertInstansiModel;
                $peny->id_seminar = $data->id;
                $peny->id_instansi = $key;
                $peny->created_by = Auth::id();
                $peny->status = '1';
                $peny->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->instansi_pendukung as $key){
                $pend = new SertInstansiModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->status = '2';
                $pend->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->ttd_pemangku as $key){
                $pend = new TtdModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->save();
            }

            // $data->narasumber        =   $request->narasumber     ;
            foreach($request->narasumber as $key){
                $nara = new NarasumberModel;
                $nara->id_seminar = $data->id;
                $nara->id_personal = $key;
                $nara->created_by = Auth::id();
                $nara->save();

                $narasumber_seminar = new PesertaSeminar;
                $c_narasumber = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_narasumber == null) {
                    $narasumber_seminar->no_urut_peserta = '1';
                } else {
                    $narasumber_seminar->no_urut_peserta = $c_narasumber + 1;
                }
                // generate no sertifikat
                $inisiator = '88';
                $status = '2';
                $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $data->no_urut;


                $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);
                $narasumber_seminar->id_peserta = $nara->id;
                $narasumber_seminar->status = "2";
                $narasumber_seminar->no_srtf = $no_sert_nara;
                $narasumber_seminar->id_seminar = $data->id;
                $narasumber_seminar->save();
            }

            $mode = new ModeratorModel;
            $mode->id_seminar = $data->id;
            $mode->nama = $request->moderator;
            $mode->created_by = Auth::id();
            $mode->save();

            $moderator_seminar = new PesertaSeminar;
            $c_moderator = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_moderator == null) {
                    $moderator_seminar->no_urut_peserta = '1';
                } else {
                    $moderator_seminar->no_urut_peserta = $c_moderator + 1;
                }

            // generate no sertifikat
            $inisiator = '88';
            $status = '4';
            $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $data->no_urut;
            $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.(str_pad($moderator_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT));

            $moderator_seminar->id_peserta = $mode->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->no_srtf = $no_sert_mode;
            $moderator_seminar->id_seminar = $data->id;
            $moderator_seminar->save();

            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil ditambahkan");

        }
    }

    // public function edit($id) {
    //     $seminar = SeminarModel::where('id',$id)->first();
    //     $inisiator = InstansiModel::all();
    //     $provinsi = ProvinsiModel::all();
    //     $kota = KotaModel::all();
    //     $instansi = BuModel::all();
    //     $pendukung = BuModel::pluck('nama_bu','id');
    //     $pimpinan = BuModel::pluck('nama_pimp','id');
    //     $narasumber = NarasumberModel::where('id',$seminar->narasumber)->first();
    //     $moderator = ModeratorModel::where('id',$seminar->moderator)->first();
    //     return view('seminar.edit')->with(compact('seminar','inisiator','provinsi',
    //     'kota','instansi','pendukung','id','pimpinan','moderator','narasumber'));
    // }


    public function edit($id) {
        $seminar = SeminarModel::where('id',$id)->first();
        if($seminar->status == 'published'){
            $instansi = BuModel::all();
            $personal = Personal::all();
            $inisiator = InstansiModel::all();
            $pendukungArr = BuModel::pluck('nama_bu','id');
            $pimpinanArr = BuModel::pluck('nama_pimp','id');
    
            //
            $penyelenggara = SertInstansiModel::where('id_seminar',$id)->where('status','1')->get();
            $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->get();
            $ttd = TtdModel::where('id_seminar',$id)->get();
            $provinsi = ProvinsiModel::all();
            $kota = KotaModel::all();
            $narasumber = NarasumberModel::where('id_seminar',$id)->get();
            $moderator = ModeratorModel::where('id_seminar',$id)->first();
            return view('seminar.edit')->with(compact('id','seminar','instansi','personal','inisiator','pendukungArr','pimpinanArr',
                'penyelenggara','pendukung','ttd','provinsi','kota','narasumber','moderator'));
        } else {

        $instansi = BuModel::all();
        $personal = Personal::all();
        $inisiator = InstansiModel::all();
        $pendukungArr = BuModel::pluck('nama_bu','id');
        $pimpinanArr = BuModel::pluck('nama_pimp','id');

        //
        $penyelenggara = SertInstansiModel::where('id_seminar',$id)->where('status','1')->get();
        $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->get();
        $ttd = TtdModel::where('id_seminar',$id)->get();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $narasumber = NarasumberModel::where('id_seminar',$id)->get();
        $moderator = ModeratorModel::where('id_seminar',$id)->first();
        return view('seminar.edit-draft')->with(compact('id','seminar','instansi','personal','inisiator','pendukungArr','pimpinanArr',
            'penyelenggara','pendukung','ttd','provinsi','kota','narasumber','moderator'));
        }
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
            'tgl_awal' => 'required|date',//|after:today',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            'ttd_pemangku' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:50',
            'narasumber' => 'required',
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
            // 'tgl_awal.after' => 'Mohon isi tanggal sesudah hari ini',
            'tgl_akhir.required' => 'Mohon isi Tanggal Berakhir Seminar',
            'tgl_akhir.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.after_or_equal' => 'Tanggal Berakhir harus sesudah Tanggal Mulai',
            'jam_awal.required' => 'Mohon isi Waktu Mulai Seminar',
            'jam_awal.date_format' => 'Mohon isi dengan format Waktu yang valid',
            'jam_akhir.required' => 'Mohon isi Jam Berakhir Seminar',
            'jam_akhir.date_format' => 'Mohon isi dengan format waktu yang valid',
            'jam_akhir.after' => 'Waktu Berakhir harus sesudah Waktu Mulai',
            'ttd_pemangku.required' => 'Mohon isi Penandatangan',
            'prov_penyelenggara.required' => 'Mohon isi Provinsi Lokasi Seminar',
            'kota_penyelenggara.required' => 'Mohon isi Kota Lokasi Seminar',
            'lokasi_penyelenggara.required' => 'Mohon isi Alamat Lokasi Seminar',
            'lokasi_penyelenggara.min' => 'Alamat Lokasi Seminar minimal 3 karakter',
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 50 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',

        ]);

        $dataAwal = SeminarModel::where('id',$id)->first();

        // dd($dataAwal);
        $naraAwal = NarasumberModel::where('id_seminar',$id)->get();

        // Dari sini, tambah ke tabel srtf_narasumber dan srtf_peserta_seminar
        // Kalo ada narasumber baru, sekaligus bikin sertifikat
        foreach($request->narasumber as $key) {
            if(!$naraAwal->contains('id_personal',$key)){
                $nara = new NarasumberModel;
                $nara->id_seminar = $id;
                $nara->id_personal = $key;
                $nara->created_by = Auth::id();
                $nara->save();

                $narasumber_seminar = new PesertaSeminar;
                $c_narasumber = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_narasumber == null) {
                    $narasumber_seminar->no_urut_peserta = '1';
                } else {
                    $narasumber_seminar->no_urut_peserta = $c_narasumber + 1;
                }
                // generate no sertifikat
                $inisiator = '88';
                $status = '2';
                $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $dataAwal->no_urut;

                $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);
                $narasumber_seminar->id_peserta = $nara->id;
                $narasumber_seminar->status = "2";
                $narasumber_seminar->no_srtf = $no_sert_nara;
                $narasumber_seminar->id_seminar = $dataAwal->id;
                $narasumber_seminar->save();
            }
        }

        // Dari sini hapus record (cuma softdelete) dari tabel narasumber dan peserta seminar
        // Kalo ada narasumber yang dikurangi
        foreach($naraAwal as $key) {
            if(!in_array($key->id_personal,$request->narasumber)){
                $naraHapus = NarasumberModel::where('id_personal',$key->id_personal)->first();
                $naraHapus->deleted_by = Auth::id();
                $naraHapus->deleted_at = Carbon::now()->toDateTimeString();
                $naraHapus->save();

                $naraHapus_peserta = PesertaSeminar::where('id_seminar',$id)
                                        ->where('id_peserta',$key->id)->first();
                $naraHapus_peserta->deleted_by = Auth::id();
                $naraHapus_peserta->deleted_at = Carbon::now()->toDateTimeString();
                $naraHapus_peserta->save();
            }
        }

        // Dari sini cek perubahan di instansi penyelenggara
        $penyAwal = SertInstansiModel::where('id_seminar',$id)
                    ->where('status','1')->get();
        foreach($request->instansi_penyelenggara as $key) {
            if(!$penyAwal->contains('id_instansi',$key)){
                $penyBaru = new SertInstansiModel;
                $penyBaru->id_seminar = $id;
                $penyBaru->id_instansi = $key;
                $penyBaru->status = '1';
                $penyBaru->created_by = Auth::id();
                $penyBaru->save();
            }
        }

        // Soft delete kalo ada Penyelenggara yang berkurang
        foreach($penyAwal as $key) {
            if(!in_array($key->id_instansi,$request->instansi_penyelenggara)){
                $penyHapus = SertInstansiModel::where('id_seminar',$id)
                ->where('id_instansi',$key->id_instansi)->first();
                $penyHapus->deleted_by = Auth::id();
                $penyHapus->deleted_at = Carbon::now()->toDateTimeString();
                $penyHapus->save();
            }
        }

        // Dari sini cek perubahan di instansi pendukung
        $pendAwal = SertInstansiModel::where('id_seminar',$id)
                    ->where('status','2')->get();
        foreach($request->instansi_pendukung as $key) {
            if(!$pendAwal->contains('id_instansi',$key)){
                $pendBaru = new SertInstansiModel;
                $pendBaru->id_seminar = $id;
                $pendBaru->id_instansi = $key;
                $pendBaru->status = '2';
                $pendBaru->created_by = Auth::id();
                $pendBaru->save();
            }
        }

        // Soft delete kalo ada Penyelenggara yang berkurang
        foreach($pendAwal as $key) {
            if(!in_array($key->id_instansi,$request->instansi_pendukung)){
                $pendHapus = SertInstansiModel::where('id_seminar',$id)
                ->where('id_instansi',$key->id_instansi)->first();
                $pendHapus->deleted_by = Auth::id();
                $pendHapus->deleted_at = Carbon::now()->toDateTimeString();
                $pendHapus->save();
            }
        }

        // Cek apakah penandatangan ada yang tambah
        $ttdAwal = TtdModel::where('id_seminar',$id)->get();
        foreach($request->ttd_pemangku as $key) {
            if(!$ttdAwal->contains('id_instansi',$key)){
                $ttdBaru = new TtdModel;
                $ttdBaru->id_seminar = $id;
                $ttdBaru->id_instansi = $key;
                $ttdBaru->created_by = Auth::id();
                $ttdBaru->save();
            }
        }
        // softdelete kalo penandatangan ada yang berkurang
        foreach($ttdAwal as $key) {
            if(!in_array($key->id_instansi,$request->ttd_pemangku)){
                $ttdHapus = TtdModel::where('id_seminar',$id)
                ->where('id_instansi',$key->id_instansi)->first();
                $ttdHapus->deleted_by = Auth::id();
                $ttdHapus->deleted_at = Carbon::now()->toDateTimeString();
                $ttdHapus->save();
            }
        }
        // Dari sini pakai logika IF apakah nama moderator berubah

        $modeAwal = ModeratorModel::where('id_seminar',$id)->first();
        if($request->moderator != $modeAwal->nama){
            $modeAwal->deleted_by = Auth::id();
            $modeAwal->deleted_at = Carbon::now()->toDateTimeString();
            $modeAwal->save();
            
            $modeHapus_peserta = PesertaSeminar::where('id_seminar',$id)
                                    ->where('id_peserta',$modeAwal->id)->first();
            // dd($modeHapus_peserta);
            $modeHapus_peserta->deleted_by = Auth::id();
            $modeHapus_peserta->deleted_at = Carbon::now()->toDateTimeString();
            $modeHapus_peserta->save();

            $modeBaru = new ModeratorModel;
            $modeBaru->nama = $request->moderator;
            $modeBaru->id_seminar = $id;
            $modeBaru->created_by = Auth::id();
            $modeBaru->save();


            $moderator_seminar = new PesertaSeminar;
            $c_moderator = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_moderator == null) {
                    $moderator_seminar->no_urut_peserta = '1';
                } else {
                    $moderator_seminar->no_urut_peserta = $c_moderator + 1;
                }

            // generate no sertifikat
            $inisiator = '88';
            $status = '4';
            $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $dataAwal->no_urut;
            $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.(str_pad($moderator_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT));

            $moderator_seminar->id_peserta = $modeBaru->id;
            $moderator_seminar->status = "4";
            $moderator_seminar->no_srtf = $no_sert_mode;
            $moderator_seminar->id_seminar = $id;
            $moderator_seminar->save();
        }

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

        return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
        "\" berhasil diubah");

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
        $bu = BuModel::all()->pluck('nama_bu','id');
        $instansi = SertInstansiModel::where('id_seminar',$id)->where('status','1')->get();
        $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->get();
        $detailseminar = PesertaSeminar::where('id_seminar','=',$id)->get();
        $narasumber = NarasumberModel::where('id_seminar',$id)->get();
        $moderator = ModeratorModel::where('id_seminar',$id)->first();
        $personal = Personal::all()->pluck('nama','id');
        // dd($instansi);
        // dd($detailseminar);
        return view('seminar.detail')->with(compact('seminar','bu','personal',
        'instansi','pendukung','detailseminar','narasumber','moderator'));
    }


    public function cetakSertifikat($id){

        $data = PesertaSeminar::where('no_srtf',$id)->first();
        $instansi = SertInstansiModel::where('id_seminar', '=' ,$data->id_seminar)->get();
        $ttd = TtdModel::where('id_seminar', '=' ,$data->id_seminar)->get();

        $pdf = PDF::loadview('seminar.sertifikat',compact('data','instansi','ttd'));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream("Sertifikat.pdf");
        // return view('seminar.sertifikat')->with(compact('data','instansi','ttd'));
    }

    public function getKota($id) {
        $cities = KotaModel::where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }

    public function kirimEmail(){
        $emails = PesertaSeminar::where('is_email_sent','0')->get(['id']);
        foreach ($emails as $key) {
            $data = SertModel::find($key->id);
            \Mail::to($data->email)->queue(new \App\Mail\EmailLinkSert($data));
        }
        PesertaSeminar::where('is_email_sent','0')->update(['is_email_sent'=>'1']);
        return 'job berhasil di buat';
    }

    public function sendEmail($id){
        $emails = PesertaSeminar::find($id);
            // dispatch(new \App\Jobs\KirimEmailJob($key->email));
            // $data = SertModel::where('email', $key->email)->first();
            \Mail::to($emails->email)->send(new \App\Mail\EmailLinkSert($emails));
        return "Email berhasil Di Kirim ke $emails->email";
    }
    public function publish($id) {
        $data = SeminarModel::where('id',$id)->first();
        $data->is_actived = "1";
        $data->status = "published";
        $counter = SeminarModel::all();
        $jumlah = array();
        if(count($counter) > 0) {
            foreach($counter as $key) {
                if(date('m', \strtotime($key->tgl_awal)) == date('m', \strtotime($data->tgl_awal))){
                    $jumlah[] = $key->no_urut;
                }
            }
        }
        if(count($jumlah) > 0){
            if(max($jumlah) > 0) {
                $data->no_urut = max($jumlah) + 1;
            } else {
                $data->no_urut = 1;
            }
        } else {
            $data->no_urut = 1;
        }
        $seminar = $data->update();
        $nara = NarasumberModel::where('id_seminar',$id)->get();
        // dd($nara);
        foreach($nara as $key) {
            // dd($key->id);
            $narasumber = PesertaSeminar::where('id_peserta',$key->id)->first();
            // dd($narasumber);
            $c_narasumber = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_narasumber == null) {
                    $narasumber->no_urut_peserta = '1';
                } else {
                    $narasumber->no_urut_peserta = $c_narasumber + 1;
                }
            // generate no sertifikat
            $inisiator = '88';
            $status = '2';
            $tahun = date("y",strtotime($data->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($data->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $data->no_urut;

            $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber->no_urut_peserta, 3, "0", STR_PAD_LEFT);
            $narasumber->no_srtf = $no_sert_nara;
            $narasumber->update();
        }
        $mode = ModeratorModel::where('id_seminar',$id)->get();
        // dd($mode);
        foreach($mode as $key) {
            $moderator = PesertaSeminar::where('id_peserta',$key->id)->first();
            // dd($narasumber);
            $c_moderator = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber

            // dd($c_moderator);
            if($c_moderator == null) {
                    $moderator->no_urut_peserta = '1';
                } else {
                    $moderator->no_urut_peserta = $c_moderator + 1;
                }
            // dd($moderator->no_urut_peserta);
            // generate no sertifikat
            $inisiator = '88';
            $status = '4';
            $tahun = date("y",strtotime($data->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($data->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $data->no_urut;

            $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($moderator->no_urut_peserta, 3, "0", STR_PAD_LEFT);
            $moderator->no_srtf = $no_sert_mode;
            $moderator->update();
        }
        return redirect('/seminar')
        ->with('pesan',"Berhasil mempublikasi ".$data->nama_seminar);
    }

}
