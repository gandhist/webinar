<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\SeminarModel;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use App\BankModel;
use App\InstansiModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Crypt;
use Config;

class InfoSeminarController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->toDateTimeString();

        // $data = Seminar::where('status','=','published')->whereDate('tgl_akhir','>',$date)->get(); //live
        $data = Seminar::where('status','=','published')->orderBy('id','desc')->get();
        if(Auth::id() == null){
            $user = 'Error';
        } else{
            $user = Peserta::select('id')->where('user_id', Auth::id())->first();
        }

        return view('infoseminar.index')->with(compact('data','user'));
    }
    public function detail($id)
    {
        $data = Seminar::find($id);
        return view('infoseminar.detail')->with(compact('data'));
    }

    public function daftar(Request $request, $id)
    {
        $data = Seminar::find($id);
        $peserta = Peserta::all();
        $bank = BankModel::all();
        
        //Set Your server key
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');

        // Uncomment for production environment
        // \Midtrans\Config::$isProduction = true;

        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            )
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $clientKey = config('services.midtrans.clientKey');
        if(!Auth::user()){
            $login = '<a href="'.url("login").'">disini</a>';
            return redirect('registrasi')->with('pesan', 'Anda harus melakukan registrasi terlebih dahulu. Klik '.$login.' jika sudah mempunyai akun');
        } else{

           

            return view('infoseminar.daftar',['user' => $request->user()])->with(compact('data','bank','peserta','snapToken','clientKey'));
        }
    }

    public function store(Request $request, $id)
    {
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $detailseminar = PesertaSeminar::where('id_peserta','=',$peserta['id'])->get();
        $kode_inisiator = Seminar::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();
        $tanggal = Seminar::select('tgl_awal')->where('id', '=',$id)->first();
        $is_free = Seminar::select('is_free')->where('id',$id)->first();
        // $statusbayar = PesertaSeminar::select('is_paid')->where('id_peserta',$peserta['id'])->first();
        $counter = SeminarModel::where('status','published')->get();
        $data = new PesertaSeminar;
        if($is_free['is_free'] == '0'){
            $urutan_seminar = Seminar::select('no_urut')->where('id', '=',$id)->first();
            $urut = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for peserta
            if($urut == null) {
                $data->no_urut_peserta = '1';
            } else {
                $data->no_urut_peserta = $urut + 1;
            }
            $urutan = PesertaSeminar::select('no_urut_peserta')->where('id', '=',$id)->first();
            // generate no sertifikat
            $inisiator = $kode_instansi['kode_instansi'];
            $status = '1';
            $tahun = substr($tanggal['tgl_awal'],2,2);
            $bulan = substr($tanggal['tgl_awal'],5,2);

            $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($data->no_urut_peserta, 3, "0", STR_PAD_LEFT);
        }

        $data->id_seminar = $id;
        $data->id_peserta = $peserta['id'];
        if($is_free['is_free'] == '0'){
            $data->is_paid = '1';
            $data->no_srtf = $no_sert;

            // generate qr code
            $url = url("sertifikat/".Crypt::encrypt($no_sert));
            $nama = "QR_Sertifikat_".$no_sert.".png";
            $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

            $dir_name = "file_seminar";
            $data->qr_code = $dir_name."/".$nama;
        } else {
            $data->is_paid = '0';
            $data->no_srtf = '';
        }
        $data->status = '1';

        // handle upload bukti bayar
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $peserta['nama']);
        if ($files = $request->file('bukti_bayar')) {
            $destinationPath = 'uploads/bukti_bayar/'.$dir_name; // upload path
            $file = "lampiran_buktibayar_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->bukti_bayar = $destinationPath."/".$file;
        }

        $data = $data->save();

        if($is_free['is_free'] == '0'){
            // pengurangan kuota
            // $kuota = DB::table('srtf_seminar')->update(['kuota_temp' => DB::raw('GREATEST(kuota_temp - 1, 0)')]);
            $kuota = Seminar::find($id);
            $kuota->kuota_temp = $kuota->kuota_temp - 1;
            $kuota->update();

            // Hitung Total Nilai SKPK lalu save
            $total = 0;
            foreach($detailseminar as $key) {
                $total += $key->seminar_p->skpk_nilai;
            }
            $total_nilai = Peserta::find($peserta['id']);
            $total_nilai->skpk_total = $total;
            $total_nilai->update();
        }

        return redirect('infoseminar')->with('success', 'Pendaftaran Seminar berhasil');
    }
}
