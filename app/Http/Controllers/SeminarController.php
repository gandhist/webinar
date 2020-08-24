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
use App\KlasifikasiModel;
use App\TUKModel;
use App\SubKlasifikasiModel;
use PDF;
use Mail;
use App\NarasumberModel;
use App\ModeratorModel;
use DB;
use File;
use App\Mail\EmailLinkSert;
use App\Traits\GlobalFunction;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\EmailLinkSert as MailSertifikat;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EmailLink as MailLink;

class SeminarController extends Controller
{

    use GlobalFunction;
    //
    public function index() {
        $seminar = SeminarModel::all();
        return view('seminar.index')->with(compact('seminar'));
    }

    public function create() {
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $instansi = BuModel::where('is_actived','1')->get();
        $pendukung = BuModel::where('is_actived','1')->pluck('nama_bu','id');
        $personal = Personal::where('is_activated','1')->get();
        $pers = Personal::where('is_activated','1')->pluck('nama','id');
        $klasifikasi = KlasifikasiModel::all();
        $sub_klasifikasi = SubKlasifikasiModel::where('aktif','1')->get();
        $tuk = TUKModel::all();

        return view('seminar.create')->with(compact('inisiator','provinsi','kota',
        'personal','instansi','pendukung','pers','klasifikasi','sub_klasifikasi','tuk'));
    }

    public function store(Request $request) {
        // $request->validate([
        //     'nama_seminar' => 'required|max:2']);
        // dd($request);
        $request->validate([
            'nama_seminar' => 'required|min:3|max:200',
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
            'ttd1' => 'required',
            'ttd2' => 'required',
            'jab_ttd1' => 'required|min:3|max:100',
            'jab_ttd2' => 'required|min:3|max:100',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:100',
            'narasumber' => 'required',
            'moderator' => 'required',//|min:3|max:50'

            'logo' => 'required',
            'is_online' => 'required',
            'link' => 'required_if:is_online,==,1',
            'tuk' => 'required',
        ],[
            'nama_seminar.required' => 'Mohon isi Nama Seminar',
            'nama_seminar.min' => 'Nama Seminar minimal 3 karakter',
            'nama_seminar.max' => 'Nama Seminar maksimal 200 karakter',
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
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 100 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'moderator.required' => 'Mohon isi Moderator',
            'ttd1.required' => 'Mohon isi Penandatangan',
            'ttd2.required' => 'Mohon isi Penandatangan',
            // 'moderator.min' => 'Moderator minimal 3 karakter',
            // 'moderator.max' => 'Moderator maksimal 50 karakter',
            'logo.required' => 'Mohon pilih logo yang akan ditampilkan pada sertifikat',
            'is_online.required' => 'Mohon pilih jenis acara',
            'link.required_if' => 'Untuk seminar online (webinar), mohon isi link seminar',
            'tuk' => 'Mohon isi Tempat Uji Komptensi'
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
        $data->kuota_temp                =              $request->kuota                  ;
        $data->kuota                     =              $request->kuota                  ;
        $data->skpk_nilai                =              $request->skpk_nilai             ;
        $data->is_free                   =              $request->is_free                ;
        $data->biaya                     =              $request->biaya                  ;
        $data->klasifikasi               =              $request->klasifikasi            ;
        $data->sub_klasifikasi           =              $request->sub_klasifikasi        ;
        $data->inisiator                 =              $request->inisiator              ;
        $data->tgl_awal                  =Carbon::parse($request->tgl_awal)              ;
        $data->tgl_akhir                 =Carbon::parse($request->tgl_akhir)             ;
        $data->jam_awal                  =              $request->jam_awal               ;
        $data->jam_akhir                 =              $request->jam_akhir              ;
        $data->prov_penyelenggara        =              $request->prov_penyelenggara     ;
        $data->kota_penyelenggara        =              $request->kota_penyelenggara     ;
        $data->lokasi_penyelenggara      =              $request->lokasi_penyelenggara   ;
        //$data->ttd_pemangku              =              $request->ttd_pemangku           ;


        $data->is_online                 =              $request->is_online              ;
        $data->url                      =              $request->link                   ;
        $data->tuk                       =              $request->tuk                    ;

        $data->save();

        // handle upload Foto
        if ($files = $request->file('foto')) {
            $destinationPath = 'file_seminar/'.$data->id; // upload path
            $file = "brosur_".$request->nama_seminar."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->link = $destinationPath."/".$file;
        }

        $data->created_by = Auth::id();

        // get kode_instansi inisiator
        $kode_inisiator = SeminarModel::select('inisiator')->where('id',$data->id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

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
                if(collect($request->logo)->contains($key)){
                    $peny->is_tampil = '1';
                } else {
                    $peny->is_tampil = '0';
                }
                $peny->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->instansi_pendukung as $key){
                $pend = new SertInstansiModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->status = '2';
                if(collect($request->logo)->contains($key)){
                    $pend->is_tampil = '1';
                } else {
                    $pend->is_tampil = '0';
                }
                $pend->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            $ttd1 = new TtdModel;
            $ttd1->id_personal = $request->ttd1;
            $ttd1->jabatan = $request->jab_ttd1;
            $ttd1->id_seminar = $data->id;
            $ttd1->created_by = Auth::id();

            // generate qr code ttd 1
            $url = url("approved/".$request->ttd1."/".$data->id);

            $nama = "QR_Validity_".$request->ttd1.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            }
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $ttd1->qr_code = $dir_name."/".$nama;
            $ttd1->save();

            $ttd2 = new TtdModel;
            $ttd2->id_personal = $request->ttd2;
            $ttd2->jabatan = $request->jab_ttd2;
            $ttd2->id_seminar = $data->id;
            $ttd2->created_by = Auth::id();

            // generate qr code ttd 2
            $url = url("approved/".$request->ttd2."/".$data->id);

            $nama = "QR_Validity_".$request->ttd2.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            }
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $ttd2->qr_code = $dir_name."/".$nama;
            $ttd2->save();

            // $data->narasumber        =   $request->narasumber     ;
            foreach($request->narasumber as $key){
                $narasumber = Peserta::where('id_personal',$key)->first();
                $narasumber_seminar = new PesertaSeminar;
                $status = '2';
                $narasumber_seminar->id_peserta = $narasumber->id;
                $narasumber_seminar->status = "2";
                // $narasumber_seminar->is_paid = "1";
                $narasumber_seminar->id_seminar = $data->id;
                // $narasumber_seminar->created_by = Auth::id();
                $narasumber_seminar->save();
            }

            foreach($request->moderator as $key){
                $moderator = Peserta::where('id_personal',$key)->first();

                $moderator_seminar = new PesertaSeminar;
                $status = '4';
                $moderator_seminar->id_peserta = $moderator->id;
                $moderator_seminar->status = "4";
                // $moderator_seminar->is_paid = "1";
                $moderator_seminar->id_seminar = $data->id;
                // $moderator_seminar->created_by = Auth::id();
                $moderator_seminar->save();
                // dd($moderator_seminar);
            }

            // //generate qr code seminar
            // $inisiator = InstansiModel::find($data->inisiator);
            // $logo = "/public/".$inisiator->logo;

            // $qr = SeminarModel::find($data->id);
            // $url = url("infoseminar/detail/".$data->id);
            // $nama = "QR_Seminar_".$data->id.".png";

            // $qrcode = \QrCode::merge($logo)->format('png')->errorCorrection('H')->size(200)->generate($url, base_path("public/file_seminar/".$nama));

            // $dir_name = "file_seminar";
            // $qr->qr_code = $dir_name."/".$nama;
            // $qr->save();

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
                if(collect($request->logo)->contains($key)){
                    $peny->is_tampil = '1';
                } else {
                    $peny->is_tampil = '0';
                }
                $peny->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            foreach($request->instansi_pendukung as $key){
                $pend = new SertInstansiModel;
                $pend->id_seminar = $data->id;
                $pend->id_instansi = $key;
                $pend->created_by = Auth::id();
                $pend->status = '2';
                if(collect($request->logo)->contains($key)){
                    $pend->is_tampil = '1';
                } else {
                    $pend->is_tampil = '0';
                }
                $pend->save();
            }

            // $data->instansi_pendukung        =   $request->instansi_pendukung     ;
            $ttd1 = new TtdModel;
            $ttd1->id_personal = $request->ttd1;
            $ttd1->jabatan = $request->jab_ttd1;
            $ttd1->id_seminar = $data->id;
            $ttd1->created_by = Auth::id();

            // generate qr code ttd 1
            $url = url("approved/".$request->ttd1."/".$data->id);

            $nama = "QR_Validity_".$request->ttd1.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            }
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $ttd1->qr_code = $dir_name."/".$nama;
            $ttd1->save();

            $ttd2 = new TtdModel;
            $ttd2->id_personal = $request->ttd2;
            $ttd2->jabatan = $request->jab_ttd2;
            $ttd2->id_seminar = $data->id;
            $ttd2->created_by = Auth::id();

            // generate qr code ttd 2
            $url = url("approved/".$request->ttd2."/".$data->id);

            $nama = "QR_Validity_".$request->ttd2.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            }
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $ttd2->qr_code = $dir_name."/".$nama;
            $ttd2->save();

            foreach($request->narasumber as $key){
                $narasumber = Peserta::where('id_personal',$key)->first();

                $narasumber_seminar = new PesertaSeminar;
                $c_narasumber = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_narasumber == null) {
                    $narasumber_seminar->no_urut_peserta = '1';
                } else {
                    $narasumber_seminar->no_urut_peserta = $c_narasumber + 1;
                }
                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '2';
                $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $data->no_urut;


                $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert_nara));
                $nama = "QR_Sertifikat_".$no_sert_nara.".png";
                if (!is_dir(base_path("public/file_seminar/"))) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
                }
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $narasumber_seminar->qr_code = $dir_name."/".$nama;

                $narasumber_seminar->id_peserta = $narasumber->id;
                $narasumber_seminar->status = "2";
                $narasumber_seminar->is_paid = "1";
                $narasumber_seminar->no_srtf = $no_sert_nara;
                $narasumber_seminar->id_seminar = $data->id;
                $narasumber_seminar->save();
            }

            foreach($request->moderator as $key){
                $moderator = Peserta::where('id_personal',$key)->first();


                $moderator_seminar = new PesertaSeminar;
                $c_moderator = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                    if($c_moderator == null) {
                        $moderator_seminar->no_urut_peserta = '1';
                    } else {
                        $moderator_seminar->no_urut_peserta = $c_moderator + 1;
                    }

                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '4';
                $tahun = date("y",strtotime($request->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($request->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $data->no_urut;
                $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.(str_pad($moderator_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT));

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert_mode));
                $nama = "QR_Sertifikat_".$no_sert_mode.".png";
                if (!is_dir(base_path("public/file_seminar/"))) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
                };
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $moderator_seminar->qr_code = $dir_name."/".$nama;

                $moderator_seminar->id_peserta = $moderator->id;
                $moderator_seminar->status = "4";
                $moderator_seminar->is_paid = "1";
                $moderator_seminar->no_srtf = $no_sert_mode;
                $moderator_seminar->id_seminar = $data->id;
                $moderator_seminar->save();
            }

            //generate qr code seminar
            $inisiator = InstansiModel::find($data->inisiator);
            $logo = "/public/".$inisiator->logo;

            $qr = SeminarModel::find($data->id);
            $url = url("infoseminar/detail/".$data->id);
            $nama = "QR_Seminar_".$data->id.".png";

            $qrcode = \QrCode::merge($logo)->format('png')->errorCorrection('H')->size(200)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $qr->qr_code = $dir_name."/".$nama;
            $qr->save();

            return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
            "\" berhasil ditambahkan");

        }
    }

    public function edit($id) {
        $seminar = SeminarModel::where('id',$id)->first();
        if($seminar->status == 'published'){
            $instansi = BuModel::where('is_actived','1')->get();
            $ins = BuModel::where('is_actived','1')->pluck('nama_bu','id');
            $personal = Personal::where('is_activated','1')->get();
            // $pers = Personal::pluck('nama','id');
            $pers = Personal::where('is_activated','1')->pluck('nama','id');
            $inisiator = InstansiModel::all();
            $pendukungArr = BuModel::pluck('nama_bu','id');
            $pimpinanArr = BuModel::pluck('nama_pimp','id');

            //BuModel::where('is_actived','1')->pluck('nama_bu','id');
            $penyelenggara = SertInstansiModel::where('id_seminar',$id)->where('status','1')->get();
            $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->get();
            $logo = SertInstansiModel::where('id_seminar',$id)->get();
            $ttd = TtdModel::where('id_seminar',$id)->get();
            $provinsi = ProvinsiModel::all();
            $kota = KotaModel::all();
            $nara = PesertaSeminar::where('id_seminar',$id)->where('status','2')->pluck('id_peserta');
            $mode = PesertaSeminar::where('id_seminar',$id)->where('status','4')->pluck('id_peserta');

            $narasumber = Peserta::whereIn('id',$nara)->where('deleted_at',null)->get();
            $moderator = Peserta::whereIn('id',$mode)->where('deleted_at',null)->get();
            // dd($narasumber);

            $tuk = TUKModel::all();

            $klasifikasi = KlasifikasiModel::all();
            $sub_klasifikasi = SubKlasifikasiModel::where('aktif','1')->get();
            // dd($logo);
            return view('seminar.edit')->with(compact('id','seminar','instansi','pers','personal', 'ins',
                'inisiator','pendukungArr','pimpinanArr','penyelenggara','pendukung', 'logo', 'tuk',
                'ttd','provinsi','kota','narasumber','moderator','klasifikasi','sub_klasifikasi'));
        } else {

            $instansi = BuModel::where('is_actived','1')->get();
            $ins = BuModel::where('is_actived','1')->pluck('nama_bu','id');
            $personal = Personal::where('is_activated','1')->get();
            // $pers = Personal::pluck('nama','id');
            $pers = Personal::where('is_activated','1')->pluck('nama','id');
            $inisiator = InstansiModel::all();
            $pendukungArr = BuModel::pluck('nama_bu','id');
            $pimpinanArr = BuModel::pluck('nama_pimp','id');

            //
            $logo = SertInstansiModel::where('id_seminar',$id)->get();
            $penyelenggara = SertInstansiModel::where('id_seminar',$id)->where('status','1')->get();
            $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->get();
            $ttd = TtdModel::where('id_seminar',$id)->get();
            $provinsi = ProvinsiModel::all();
            $kota = KotaModel::all();

            $nara = PesertaSeminar::where('id_seminar',$id)->where('status','2')->pluck('id_peserta');
            $mode = PesertaSeminar::where('id_seminar',$id)->where('status','4')->pluck('id_peserta');

            $narasumber = Peserta::whereIn('id',$nara)->where('deleted_at',NULL)->get();
            $moderator = Peserta::whereIn('id',$mode)->where('deleted_at',NULL)->get();

            $tuk = TUKModel::all();

            $klasifikasi = KlasifikasiModel::all();
            $sub_klasifikasi = SubKlasifikasiModel::where('aktif','1')->get();

        return view('seminar.edit-draft')->with(compact('id','seminar','instansi','pers','personal',
        'inisiator','pendukungArr','pimpinanArr','klasifikasi','sub_klasifikasi', 'tuk', 'logo', 'ins',
        'penyelenggara','pendukung','ttd','provinsi','kota','narasumber','moderator'));
        }
    }

    public function update(Request $request, $id) {
        // foreach($request->narasumber as $key) {
        //     print($key);
        //     print('<br>');

        //     $narasumber = Peserta::where('id_personal',$key)->first();
        //     print('<br>');
        //     print($narasumbers);
        //     print('<br>');
        // }
        // dd('done');

        // $naraAwalAsPeserta = PesertaSeminar::where('id_seminar',$id)->where('status','2')->pluck('id_peserta');
        // $modeAwalAsPeserta = PesertaSeminar::where('id_seminar',$id)->where('status','4')->pluck('id_peserta');

        // // dump($naraAwalAsPeserta);
        // // dd($modeAwalAsPeserta);

        // $naraAwal = Peserta::Wherein('id',$naraAwalAsPeserta)->get();
        // $modeAwal = Peserta::Wherein('id',$modeAwalAsPeserta)->get();


        // dump($naraAwal);
        // dd($modeAwal);

        $request->validate([
            'nama_seminar' => 'required|min:3|max:200',
            'klasifikasi' => 'required',
            'sub_klasifikasi' => 'required',
            'tema' => 'required|min:5|max:200',
            'biaya' => 'required_if:is_free,==,1',
            'inisiator' => 'required',
            'instansi_penyelenggara' => 'required',
            'instansi_pendukung' => 'required',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'jam_awal' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_awal',
            'ttd1' => 'required',
            'ttd2' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:100',
            'narasumber' => 'required',
            'moderator' => 'required',
            'logo' => 'required',
            'tuk' => 'required',
            'link' => 'nullable|url'
        ],[
            'nama_seminar.required' => 'Mohon isi Nama Seminar',
            'nama_seminar.min' => 'Nama Seminar minimal 3 karakter',
            'nama_seminar.max' => 'Nama Seminar maksimal 200 karakter',
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
            'tgl_akhir.required' => 'Mohon isi Tanggal Berakhir Seminar',
            'tgl_akhir.date' => 'Mohon isi tanggal yang valid',
            'tgl_akhir.after_or_equal' => 'Tanggal Berakhir harus sesudah Tanggal Mulai',
            'jam_awal.required' => 'Mohon isi Waktu Mulai Seminar',
            'jam_awal.date_format' => 'Mohon isi dengan format Waktu yang valid',
            'jam_akhir.required' => 'Mohon isi Jam Berakhir Seminar',
            'jam_akhir.date_format' => 'Mohon isi dengan format waktu yang valid',
            'jam_akhir.after' => 'Waktu Berakhir harus sesudah Waktu Mulai',
            'ttd1.required' => 'Mohon isi Penandatangan',
            'ttd2.required' => 'Mohon isi Penandatangan',
            'prov_penyelenggara.required' => 'Mohon isi Provinsi Lokasi Seminar',
            'kota_penyelenggara.required' => 'Mohon isi Kota Lokasi Seminar',
            'lokasi_penyelenggara.required' => 'Mohon isi Alamat Lokasi Seminar',
            'lokasi_penyelenggara.min' => 'Alamat Lokasi Seminar minimal 3 karakter',
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 100 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',
            'logo.required' => 'Mohon pilih logo yang akan ditampilkan pada sertifikat',
            'tuk.required' => 'Mohon isi Tempat Uji Komptensi',
            'link.url' => 'Mohon isi URL dengan format yang valid (diawali http:// atau https://)'

        ]);
        // dd($request);
        $dataAwal = SeminarModel::where('id',$id)->first();
        $naraAwalAsPeserta = PesertaSeminar::where('id_seminar',$id)->where('status','2')->pluck('id_peserta');
        $modeAwalAsPeserta = PesertaSeminar::where('id_seminar',$id)->where('status','4')->pluck('id_peserta');
        $naraAwal = Peserta::Wherein('id',$naraAwalAsPeserta)->get();
        $modeAwal = Peserta::Wherein('id',$modeAwalAsPeserta)->get();

        // dd($dataAwal);
        // get kode_instansi inisiator
        $kode_inisiator = SeminarModel::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

        // Dari sini, tambah ke tabel srtf_narasumber dan srtf_peserta_seminar
        // Kalo ada narasumber baru, sekaligus bikin sertifikat
        foreach($request->narasumber as $key) {
            if(!$naraAwal->contains('id_personal',$key)){
                $narasumber = Peserta::where('id_personal',$key)->first();

                $narasumber_seminar = new PesertaSeminar;
                $c_narasumber = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_narasumber == null) {
                    $narasumber_seminar->no_urut_peserta = '1';
                } else {
                    $narasumber_seminar->no_urut_peserta = $c_narasumber + 1;
                }
                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '2';
                $tahun = date("y",strtotime($dataAwal->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($dataAwal->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $dataAwal->no_urut;

                $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($narasumber_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert_nara));
                $nama = "QR_Sertifikat_".$no_sert_nara.".png";
                if (!is_dir(base_path("public/file_seminar/"))) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
                };
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $narasumber_seminar->qr_code = $dir_name."/".$nama;

                $narasumber_seminar->id_peserta = $narasumber->id;
                $narasumber_seminar->status = "2";
                $narasumber_seminar->is_paid = "1";
                $narasumber_seminar->no_srtf = $no_sert_nara;
                $narasumber_seminar->id_seminar = $dataAwal->id;
                $narasumber_seminar->save();
            }
        }

        // Dari sini hapus record (cuma softdelete) dari tabel narasumber dan peserta seminar
        // Kalo ada narasumber yang dikurangi
        foreach($naraAwal as $key) {
            if(!in_array($key->id_personal,$request->narasumber)){
                $naraHapus = PesertaSeminar::where('id',$key->id)->first();
                $naraHapus->deleted_by = Auth::id();
                $naraHapus->deleted_at = Carbon::now()->toDateTimeString();
                $naraHapus->save();
            }
        }

        // moderator
        foreach($request->moderator as $key) {
            if(!$modeAwal->contains('id_personal',$key)){
                $moderator = Peserta::where('id_personal',$key)->first();

                $moderator_seminar = new PesertaSeminar;
                $c_moderator = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
                if($c_moderator == null) {
                    $moderator_seminar->no_urut_peserta = '1';
                } else {
                    $moderator_seminar->no_urut_peserta = $c_moderator + 1;
                }
                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '4';
                $tahun = date("y",strtotime($dataAwal->tgl_awal)); //substr($request->tgl_awal,2,2);
                $bulan = date("m",strtotime($dataAwal->tgl_awal)); //substr($request->tgl_awal,5,2);
                $urutan_seminar = $dataAwal->no_urut;

                $no_sert_mode = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($moderator_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
                // dd($no_sert);

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert_mode));
                $nama = "QR_Sertifikat_".$no_sert_mode.".png";
                if (!is_dir(base_path("public/file_seminar/"))) {
                    // mkdir($destinationPath, 777, true);
                    File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
                };
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $moderator_seminar->qr_code = $dir_name."/".$nama;

                $moderator_seminar->id_peserta = $moderator->id;
                $moderator_seminar->status = "4";
                $moderator_seminar->is_paid = "1";
                $moderator_seminar->no_srtf = $no_sert_mode;
                $moderator_seminar->id_seminar = $dataAwal->id;
                $moderator_seminar->save();
            }
        }

        foreach($modeAwal as $key) {
            if(!in_array($key->id_personal,$request->moderator)){
                $modeHapus = PesertaSeminar::where('id',$key->id)->first();
                $modeHapus->deleted_by = Auth::id();
                $modeHapus->deleted_at = Carbon::now()->toDateTimeString();
                $modeHapus->save();
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

                if(collect($request->logo)->contains($key)){
                    $penyBaru->is_tampil = '1';
                } else {
                    $penyBaru->is_tampil = '0';
                }
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

                if(collect($request->logo)->contains($key)){
                    $pendBaru->is_tampil = '1';
                } else {
                    $pendBaru->is_tampil = '0';
                }
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
        $ttd1 = TtdModel::where('id',$ttdAwal[0]['id'])->first();
        $ttd2 = TtdModel::where('id',$ttdAwal[1]['id'])->first();

        if($ttd1->id_personal != $request->ttd1){
            $ttd1->id_personal = $request->ttd1;
            $ttd1->updated_by = Auth::id();
            $ttd1->updated_at = Carbon::now()->toDateTimeString();
        }
        if($ttd2->id_personal != $request->ttd2){
            $ttd2->id_personal = $request->ttd2;
            $ttd2->updated_by = Auth::id();
            $ttd2->updated_at = Carbon::now()->toDateTimeString();
        }


        if($ttd1->jabatan != $request->jab_ttd1){
            $ttd1->jabatan = $request->jab_ttd1;
            $ttd1->updated_by = Auth::id();
            $ttd1->updated_at = Carbon::now()->toDateTimeString();
        }
        if($ttd2->jabatan != $request->jab_ttd2){
            $ttd2->jabatan = $request->jab_ttd2;
            $ttd2->updated_by = Auth::id();
            $ttd2->updated_at = Carbon::now()->toDateTimeString();
        }

        $ttd1->save();
        $ttd2->save();

        // Cek Is tampil
        $ins =  SertInstansiModel::where('id_seminar',$id)->get();
        foreach($ins as $key){
            if(collect($request->logo)->contains($key->id)){
                $tampil = SertInstansiModel::find($key->id);
                $tampil->is_tampil = '1';
                $tampil->save();
            } else {
                $notTampil = SertInstansiModel::find($key->id);
                $notTampil->is_tampil = '0';
                $notTampil->save();
            }
        }
        // end is tampil

        $data = SeminarModel::find($id);
        $data->nama_seminar              =              $request->nama_seminar           ;
        $data->klasifikasi               =              $request->klasifikasi            ;
        $data->sub_klasifikasi           =              $request->sub_klasifikasi        ;
        $data->tema                      =              $request->tema                   ;
        $data->url                       =              $request->link                   ;
        $data->tuk                       =              $request->tuk                    ;
        // $data->kuota_temp                =              $request->kuota                  ;
        // $data->kuota                     =              $request->kuota                  ;
        // $data->skpk_nilai                =              $request->skpk_nilai             ;
        //$data->is_free                   =              $request->is_free                ;
        //$data->biaya                     =              $request->biaya                  ;
        $data->inisiator                 =              $request->inisiator              ;
        // $data->tgl_awal                  =Carbon::parse($request->tgl_awal)              ;
        $data->tgl_akhir                 =Carbon::parse($request->tgl_akhir)             ;
        $data->jam_awal                  =              $request->jam_awal               ;
        $data->jam_akhir                 =              $request->jam_akhir              ;
        // $data->ttd_pemangku              =              $request->ttd_pemangku           ;
        $data->prov_penyelenggara        =              $request->prov_penyelenggara     ;
        $data->kota_penyelenggara        =              $request->kota_penyelenggara     ;
        $data->lokasi_penyelenggara      =              $request->lokasi_penyelenggara   ;
        // $data->ttd_pemangku              =              $request->ttd_pemangku           ;



        $data->updated_by = Auth::id();
        $data->updated_at = Carbon::now()->toDateTimeString();

        if ($files = $request->file('foto')) {
            $lampiran_foto_lama = $data->link;

            $destinationPath = 'file_seminar/'.$data->id; // upload path
            $file = "brosur_".$request->nama_seminar."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->link = $destinationPath."/".$file;


            // if (file_exists(public_path()."/".$data->lampiran_foto) && file_exists(public_path()."/".$lampiran_foto_lama)) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_foto_lama);
            // }
        }


        $data->save();

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
        $instansi = SertInstansiModel::where('id_seminar',$id)->where('status','1')->where('deleted_at',NULL)->get();
        $pendukung = SertInstansiModel::where('id_seminar',$id)->where('status','2')->where('deleted_at',NULL)->get();
        $detailseminar = PesertaSeminar::where('id_seminar','=',$id)->orderBy('id','asc')->get();

        $nara = PesertaSeminar::where('id_seminar',$id)->where('status','2')->pluck('id_peserta');
        $mode = PesertaSeminar::where('id_seminar',$id)->where('status','4')->pluck('id_peserta');

        $narasumber = Peserta::whereIn('id',$nara)->where('deleted_at',NULL)->get();
        $moderator = Peserta::whereIn('id',$mode)->where('deleted_at',NULL)->get();

        $personal = Personal::all()->pluck('nama','id');
        // dd($detailseminar);
        return view('seminar.detail')->with(compact('seminar','bu','personal',
        'instansi','pendukung','detailseminar','narasumber','moderator'));
    }

    public function getKota($id) {
        $cities = KotaModel::where("provinsi_id",$id)
                    ->pluck("nama","id")
                    ->all();
        return json_encode($cities);
    }
    public function updateDraft(Request $request) {
        // dd($request);
        $id = $request->id;
        $request->validate([
            'nama_seminar' => 'required|min:3|max:200',
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
            'ttd1' => 'required',
            'ttd2' => 'required',
            'prov_penyelenggara' => 'required',
            'kota_penyelenggara' => 'required',
            'lokasi_penyelenggara' => 'required|min:3|max:100',
            'narasumber' => 'required',
            'moderator' => 'required',//|min:3|max:50'
            'is_online' => 'required',
            'logo' => 'required',
            'tuk' => 'required',
            'link' => 'nullable|url'
        ],[
            'ttd1.required' => 'Mohon isi Penandatangan',
            'ttd2.required' => 'Mohon isi Penandatangan',
            'nama_seminar.required' => 'Mohon isi Nama Seminar',
            'nama_seminar.min' => 'Nama Seminar minimal 3 karakter',
            'nama_seminar.max' => 'Nama Seminar maksimal 200 karakter',
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
            'lokasi_penyelenggara.max' => 'Alamat Lokasi Seminar maksimal 100 karakter',
            'narasumber.required' => 'Mohon isi Narasumber',
            'moderator.required' => 'Mohon isi Moderator',
            'moderator.min' => 'Moderator minimal 3 karakter',
            'moderator.max' => 'Moderator maksimal 50 karakter',
            'logo.required' => 'Mohon pilih logo yang akan ditampilkan pada sertifikat',
            'is_online.required' => 'Mohon pilih jenis acara',
            'link.required_if' => 'Untuk seminar online (webinar), mohon isi link seminar',
            'tuk' => 'Mohon isi Tempat Uji Komptensi'

        ]);

        $dataAwal = SeminarModel::where('id',$id)->first();
        $naraAwal = PesertaSeminar::where('id_seminar',$id)->where('status','2')->where('deleted_at',NULL)->get();
        $modeAwal = PesertaSeminar::where('id_seminar',$id)->where('status','4')->where('deleted_at',NULL)->get();
        // dd($naraAwal);

        // Dari sini, tambah ke tabel srtf_narasumber dan srtf_peserta_seminar
        // Kalo ada narasumber baru, sekaligus bikin sertifikat
        foreach($request->narasumber as $key) {
            if(!$naraAwal->contains('id_personal',$key)){
                $narasumber = Peserta::where('id_personal',$key)->first();

                $narasumber_seminar = new PesertaSeminar;
                $narasumber_seminar->id_peserta = $narasumber->id;
                $narasumber_seminar->status = "2";
                $narasumber_seminar->id_seminar = $dataAwal->id;
                $narasumber_seminar->save();
            }
        }

        // Dari sini hapus record (cuma softdelete) dari tabel narasumber dan peserta seminar
        // Kalo ada narasumber yang dikurangi
        foreach($naraAwal as $key) {
            if(!in_array($key->id_personal,$request->narasumber)){
                $naraHapus = PesertaSeminar::where('id',$key->id)->first();
                $naraHapus->deleted_by = Auth::id();
                $naraHapus->deleted_at = Carbon::now()->toDateTimeString();
                $naraHapus->save();
            }
        }

        // moderator
        foreach($request->moderator as $key) {
            if(!$modeAwal->contains('id_personal',$key)){
                $moderator = Peserta::where('id_personal',$key)->first();


                $moderator_seminar = new PesertaSeminar;
                $moderator_seminar->id_peserta = $moderator->id;
                $moderator_seminar->status = "4";
                $moderator_seminar->id_seminar = $dataAwal->id;
                $moderator_seminar->save();
            }
        }

        foreach($modeAwal as $key) {
            if(!in_array($key->id_personal,$request->moderator)){
                $modeHapus = PesertaSeminar::where('id',$key->id)->first();
                $modeHapus->deleted_by = Auth::id();
                $modeHapus->deleted_at = Carbon::now()->toDateTimeString();
                $modeHapus->save();
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

                if(collect($request->logo)->contains($key)){
                    $penyBaru->is_tampil = '1';
                } else {
                    $penyBaru->is_tampil = '0';
                }
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

                if(collect($request->logo)->contains($key)){
                    $pendBaru->is_tampil = '1';
                } else {
                    $pendBaru->is_tampil = '0';
                }
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
        $ttd1 = TtdModel::where('id',$ttdAwal[0]['id'])->first();
        $ttd2 = TtdModel::where('id',$ttdAwal[1]['id'])->first();

        if($ttd1->id_personal != $request->ttd1){
            $ttd1->id_personal = $request->ttd1;
            $ttd1->updated_by = Auth::id();
            $ttd1->updated_at = Carbon::now()->toDateTimeString();
        }
        if($ttd2->id_personal != $request->ttd2){
            $ttd2->id_personal = $request->ttd2;
            $ttd2->updated_by = Auth::id();
            $ttd2->updated_at = Carbon::now()->toDateTimeString();
        }


        if($ttd1->jabatan != $request->jab_ttd1){
            $ttd1->jabatan = $request->jab_ttd1;
            $ttd1->updated_by = Auth::id();
            $ttd1->updated_at = Carbon::now()->toDateTimeString();
        }
        if($ttd2->jabatan != $request->jab_ttd2){
            $ttd2->jabatan = $request->jab_ttd2;
            $ttd2->updated_by = Auth::id();
            $ttd2->updated_at = Carbon::now()->toDateTimeString();
        }

        $ttd1->save();
        $ttd2->save();


        // Cek Is tampil
        $ins =  SertInstansiModel::where('id_seminar',$id)->get();
        foreach($ins as $key){
            if(collect($request->logo)->contains($key->id)){
                $tampil = SertInstansiModel::find($key->id);
                $tampil->is_tampil = '1';
                $tampil->save();
            } else {
                $notTampil = SertInstansiModel::find($key->id);
                $notTampil->is_tampil = '0';
                $notTampil->save();
            }
        }
        // end is tampil


        $data = SeminarModel::find($id);
        $data->nama_seminar              =              $request->nama_seminar           ;
        $data->klasifikasi               =              $request->klasifikasi            ;
        $data->sub_klasifikasi           =              $request->sub_klasifikasi        ;
        $data->tema                      =              $request->tema                   ;
        $data->kuota_temp                =              $request->kuota                  ;
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
        // $data->ttd_pemangku              =              $request->ttd_pemangku           ;

        $data->is_online                 =              $request->is_online              ;
        $data->url                       =              $request->url                    ;
        $data->tuk                       =              $request->tuk                    ;




        $data->updated_by = Auth::id();
        $data->updated_at = Carbon::now()->toDateTimeString();

        if ($files = $request->file('foto')) {
            $lampiran_foto_lama = $data->link;

            $destinationPath = 'file_seminar/'.$data->id; // upload path
            $file = "brosur_".$request->nama_seminar."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->link = $destinationPath."/".$file;


            // if (file_exists(public_path()."/".$data->lampiran_foto) && file_exists(public_path()."/".$lampiran_foto_lama) && $lampiran_foto_lama != null ) {
            //     // mkdir($destinationPath, 777, true);
            //     unlink(public_path()."/".$lampiran_foto_lama);
            // }
        }

        $data->save();

        return redirect('/seminar')->with('pesan',"Seminar \"".$request->nama_seminar.
        "\" berhasil diubah");
    }


    //cetak sertifikat peserta yg dipilih
    public function cetakSertifikat($id){
        $data = PesertaSeminar::where('no_srtf',$id)->first();

        //generate qr code data lama
        $qr = PesertaSeminar::find($data['id']);
        $url = url("sertifikat/".Crypt::encrypt($id));
        $nama = "QR_Sertifikat_".$id.".png";

        $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

        $dir_name = "file_seminar";
        $qr->qr_code = $dir_name."/".$nama;
        $qr->save();
        ///////

        $instansi = SertInstansiModel::where('id_seminar', '=' ,$data->id_seminar)->get();
        $ttd = TtdModel::where('id_seminar', '=' ,$data->id_seminar)->get();

        $pdf = PDF::loadview('seminar.sertifikat',compact('data','instansi','ttd','qr'));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream("Sertifikat_$data->no_srtf.pdf");
        // return view('seminar.sertifikat')->with(compact('data','instansi','ttd'));
    }

    // kirim email ke semua peserta
    public function kirimEmail($id){
        $emails = PesertaSeminar::where('id_seminar',$id)->where('is_email_sent','0')->where('is_paid','=','1')->get();
        foreach ($emails as $key) {
            $data = Peserta::find($key->id_peserta);
            \Mail::to($data->email)->send(new MailSertifikat($key));
        }
        PesertaSeminar::where('is_email_sent','0')->update(['is_email_sent'=>'1']);
        return redirect()->back()->with('alert',"Sertifikat Berhasil dikirim ke semua peserta");
    }

    // kirim wa
    public function kirimWA(){
        $nohp = '081240353913';
        $pesan = "youre awesome";
        return $this->kirimPesanWA($nohp,$pesan);

    }

    // kirim email ke peserta yg dipilih
    public function sendEmail($id){
        $emails = PesertaSeminar::where('no_srtf',$id)->first();
        $email = Peserta::where('id',$emails['id_peserta'])->first();
        $emails->no_sertf = Crypt::encrypt($id);
        \Mail::to($email->email)->send(new MailSertifikat($emails));

        return redirect()->back()->with('alert',"Sertifikat Berhasil dikirim ke $email->email");
    }

    public function publish($id) {
        $data = SeminarModel::where('id',$id)->first();
        $data->is_actived = "1";
        $data->status = "published";


        //generate qr code seminar
        $inisiator = InstansiModel::find($data->inisiator);
        $logo = "/public/".$inisiator->logo;

        $qr = SeminarModel::find($data->id);
        $url = url("infoseminar/detail/".$data->id);
        $nama = "QR_Seminar_".$data->id.".png";

        $qrcode = \QrCode::merge($logo)->format('png')->errorCorrection('H')->size(200)->generate($url, base_path("public/file_seminar/".$nama));

        $dir_name = "file_seminar";
        $qr->qr_code = $dir_name."/".$nama;
        $qr->save();
        //end qr

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
        $seminar = $data->save();
        $nara = PesertaSeminar::where('id_seminar',$id)->where('status','2')->get();
        // dump($nara);

        // get kode_instansi inisiator
        $kode_inisiator = SeminarModel::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();
        foreach($nara as $key) {
            // dump($key);
            // $narasumber = PesertaSeminar::where('id_peserta',$key->id_peserta)
            //                     ->where('status','2')->first();
            $c_narasumber = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
            if($c_narasumber == null) {
                    $key->no_urut_peserta = '1';
                } else {
                    $key->no_urut_peserta = $c_narasumber + 1;
                }
            // generate no sertifikat
            $inisiator = $kode_instansi['kode_instansi'];
            $status = '2';
            $tahun = date("y",strtotime($data->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($data->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $data->no_urut;

            $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($key->no_urut_peserta, 3, "0", STR_PAD_LEFT);

            // generate qr code
            $url = url("sertifikat/".Crypt::encrypt($no_sert_nara));
            $nama = "QR_Sertifikat_".$no_sert_nara.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                // mkdir($destinationPath, 777, true);
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            };
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $key->qr_code = $dir_name."/".$nama;
            $key->is_paid = '1';
            $key->no_srtf = $no_sert_nara;
            $key->save();
        }
        $mode = PesertaSeminar::where('id_seminar',$id)->where('status','4')->get();
        // dd($nara);
        foreach($mode as $key) {
            // dd($key->id);
            // $moderator = PesertaSeminar::where('id_peserta',$key->id_peserta)
            //                     ->where('status','4')->first();
            $c_moderator = PesertaSeminar::where('id_seminar',$data->id)->max('no_urut_peserta'); //Counter nomor urut for narasumber
            if($c_moderator == null) {
                    $key->no_urut_peserta = '1';
                } else {
                    // dd($moderator);
                    $key->no_urut_peserta = $c_moderator + 1;
                }
            // generate no sertifikat
            $inisiator = $kode_instansi['kode_instansi'];
            $status = '4';
            $tahun = date("y",strtotime($data->tgl_awal)); //substr($request->tgl_awal,2,2);
            $bulan = date("m",strtotime($data->tgl_awal)); //substr($request->tgl_awal,5,2);
            $urutan_seminar = $data->no_urut;

            $no_sert_nara = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar.str_pad($key->no_urut_peserta, 3, "0", STR_PAD_LEFT);

            // generate qr code
            $url = url("sertifikat/".Crypt::encrypt($no_sert_nara));
            $nama = "QR_Sertifikat_".$no_sert_nara.".png";
            if (!is_dir(base_path("public/file_seminar/"))) {
                // mkdir($destinationPath, 777, true);
                File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
            };
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $key->qr_code = $dir_name."/".$nama;
            $key->is_paid = '1';
            $key->no_srtf = $no_sert_nara;
            $key->save();
        }
        return redirect('/seminar')
        ->with('pesan',"Berhasil mempublikasi ".$data->nama_seminar);
    }

    public function approve($id){
        $seminar = PesertaSeminar::where('id',$id)->first();
        $nama_peserta = Peserta::where('id', '=',$seminar['id_peserta'])->first();
        $urutan_seminar = SeminarModel::select('no_urut')->where('id', '=',$seminar->id_seminar)->first();
        $tanggal = SeminarModel::select('tgl_awal')->where('id', '=',$seminar->id_seminar)->first();
        $kode_inisiator = SeminarModel::select('inisiator')->where('id',$seminar->id_seminar)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

        $data = PesertaSeminar::find($id);
        $urut = PesertaSeminar::where('id_seminar',$seminar->id_seminar)->max('no_urut_peserta'); //Counter nomor urut for peserta
        if($urut == null) {
            $data->no_urut_peserta = '1';
        } else {
            $data->no_urut_peserta = $urut + 1;
        }

        // generate no sertifikat
        $inisiator = $kode_instansi['kode_instansi'];
        $status = '1';
        $tahun = substr($tanggal['tgl_awal'],2,2);
        $bulan = substr($tanggal['tgl_awal'],5,2);

        $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($data->no_urut_peserta, 3, "0", STR_PAD_LEFT);

        $data->is_paid = '1';
        $data->no_srtf = $no_sert;
        $data->approved_by = Auth::id();
        $data->approved_at = Carbon::now()->toDateTimeString();

        // generate qr code
        $url = url("sertifikat/".Crypt::encrypt($no_sert));
        $nama = "QR_Sertifikat_".$no_sert.".png";
        if (!is_dir(base_path("public/file_seminar/"))) {
            // mkdir($destinationPath, 777, true);
            File::makeDirectory(base_path("public/file_seminar/"), $mode = 0777, true, true);
        };
        $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

        $dir_name = "file_seminar";
        $data->qr_code = $dir_name."/".$nama;

        $data = $data->save();

        return redirect()->back()->with('alert',"Peserta \"".$nama_peserta['nama']."\" berhasil di approve");
    }

    public function scanTTD($id_personal, $id_seminar){
        $seminar = SeminarModel::where('id',$id_seminar)->first();
        $nama = Personal::where('id',$id_personal)->first();
        $ttd = TtdModel::where('id_personal',$id_personal)->where('id_seminar',$id_seminar)->first();

        return view('seminar.ttd')->with(compact('seminar','nama','ttd'));

    }

    public function scanSertifikat($id){
        $no_sert = Crypt::decrypt($id);
        $data = PesertaSeminar::where('no_srtf',$no_sert)->first();
        $instansi = SertInstansiModel::where('id_seminar', '=' ,$data->id_seminar)->get();
        $ttd = TtdModel::where('id_seminar', '=' ,$data->id_seminar)->get();

        $pdf = PDF::loadview('seminar.sertifikat',compact('data','instansi','ttd'));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream("Sertifikat_$no_sert.pdf");

    }

    public function kirimLink(Request $request, $id){
        // dd($request->link);
        // kirim email
        $emails = PesertaSeminar::where('id_seminar',$id)->get();
        // dd($emails);
        foreach ($emails as $key) {
            $data = Peserta::find($key->id_peserta);
            \Mail::to($data->email)->send(new MailLink([$key,$request->link]));
        }
        
        return redirect()->back()->with('alert',"Link Berhasil dikirim ke semua peserta");
    }

}
