<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\SeminarModel;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use App\LogTransaksi;
use App\BankModel;
use App\InstansiModel;
use App\ReportBlasting;
use App\Traits\GlobalFunction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Crypt;
use Config;
use Vinkla\Hashids\Facades\Hashids;

class InfoSeminarController extends Controller
{
    use GlobalFunction;

    public function index()
    {
        $date = Carbon::now()->toDateTimeString();

        // $data = Seminar::where('status','=','published')->whereDate('tgl_akhir','>',$date)->get(); //live
        $data = Seminar::where('status','=','published')->orderBy('id','desc')->get();
        if(Auth::id() == null){
            $user = 'Error';
        } else{
            $user = Peserta::select('id')->where('user_id', Auth::id())->first();
            if($user == null){
                $user = 'Error';
            } else {
                $peserta = PesertaSeminar::where('id_peserta',$user->id )->get();
            }
        }
        // dd($peserta);
        // $peserta = NULL;
        if(isset($peserta)){
            return view('infoseminar.index')->with(compact('data','user','peserta'));
        } else {
            return view('infoseminar.index')->with(compact('data','user'));
        }
    }
    public function detail($id)
    {
        $data = Seminar::find($id);
        return view('infoseminar.detail')->with(compact('data'));
    }

    public function daftar(Request $request, $id)
    {
        $data = SeminarModel::where('id',$id)->first();
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $bank = BankModel::all();


        // dd($cek);

        // if(isset($peserta)){
        //     //Set Your server key

        //     \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');

        //     // Uncomment for production environment
        //     // \Midtrans\Config::$isProduction = true;

        //     \Midtrans\Config::$isSanitized = true;
        //     \Midtrans\Config::$is3ds = true;
        //     $params = array(
        //         'transaction_details' => array(
        //             'order_id' => $data->id.$peserta->id.$peserta->user_id.time(),
        //             'gross_amount' => 10000,
        //         )
        //     );
        //     $snapToken = \Midtrans\Snap::getSnapToken($params);
        //     $clientKey = config('services.midtrans.clientKey');
        // }
            $snapToken = "";
            $clientKey = "";

        if(!Auth::user()){
            $login = '<a href="'.url("login").'">disini</a>';
            return redirect('registrasi')->with('pesan', 'Anda harus melakukan registrasi terlebih dahulu. Klik '.$login.' jika sudah mempunyai akun');
        }
        elseif(!isset($peserta)) {
            return redirect('/')->with('success', 'Anda tidak terdaftar sebagai peserta');
        }
        else{
            return view('infoseminar.daftar',['user' => $request->user()])->with(compact('data','bank','peserta','snapToken','clientKey'));
        }
    }

    public function store(Request $request, $id)
    {
        // dd($request);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $detailseminar = Seminar::where('id',$id)->first();
        if($detailseminar->is_mulai == 2){
            return redirect()->back()->with('udahan',"Seminar telah selesai, silahkan mendaftar seminar lain");
        }
        $kode_inisiator = Seminar::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();
        $tanggal = Seminar::select('tgl_awal')->where('id', '=',$id)->first();
        $is_free = Seminar::select('is_free')->where('id',$id)->first();
        $counter = SeminarModel::where('status','published')->get();
        $cek = PesertaSeminar::where('id_peserta',$peserta['id'])->where('id_seminar', $id)->count();

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
        // $data->skpk_nilai = $detailseminar['skpk_nilai'];
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

        $data->created_by = Auth::id();
        $data->created_at = Carbon::now()->toDateTimeString();

        if($request->magic_link){
            $data->is_blasting = 1;

            $blast = ReportBlasting::where('magic_link',$request->magic_link)->first();
            $blast->is_daftar = 1;
            $blast->daftar = \Carbon\Carbon::now();

            $data->id_blasting = $blast->id;
        }

        // validasi jika sudah pernah terdaftar
        if($cek > 0){
            return redirect('infoseminar')->with('warning', 'Anda Sudah Mendaftar Seminar ini');
        } else{
            $data = $data->save();

            if($request->magic_link){
                $blast->save();
            }
            if($is_free['is_free'] == '0') {

                $data->skpk_nilai = $detailseminar['skpk_nilai'];
                $data->save();

                // pengurangan kuota
                // $kuota = DB::table('srtf_seminar')->update(['kuota_temp' => DB::raw('GREATEST(kuota_temp - 1, 0)')]);
                $kuota = Seminar::find($id);
                $kuota->kuota_temp = $kuota->kuota_temp - 1;
                $kuota->update();

                // get nilai_skpk dari lalu di total
                $total_nilai = Peserta::find($peserta['id']);
                $total_nilai->skpk_total = $total_nilai->skpk_total + $detailseminar['skpk_nilai'];
                $total_nilai->update();

            } else if ($is_free['is_free'] == '1') {

                $data->skpk_nilai = 0;
                $data->save();

                $no_trans = "P3SM/SRTF-".$detailseminar->id."/".$data->id."/".Carbon::now()->timestamp;

                $start_pay_date = Carbon::now();
                $end_pay_date = Carbon::createFromFormat('Y-m-d H:i', $detailseminar->tgl_awal.' '.$detailseminar->jam_awal);
                // in minutes
                $exp_date = $start_pay_date->diffInMinutes($end_pay_date);

                $detail_snap = [
                    "transaction_details" => [
                        "order_id" => $no_trans,
                        "gross_amount" => (int)$detailseminar->biaya ?? 0
                    ],
                    "item_details" => [
                        [
                            "id" => $detailseminar->id,
                            "price" => (int)$detailseminar->biaya ?? 0,
                            "quantity" => 1,
                            "name" => "Fee Pendaftaran ".strip_tags($detailseminar->tema),
                            "brand" => "P3SM",
                            "merchant_name" => "P3SM"
                        ]
                    ],
                    "customer_details" => [
                        "first_name" => $request->name,
                        "last_name" => '',
                        "email" => $request->email,
                        "phone" => $request->no_hp
                    ],
                    "expiry" => [
                        "start_time"=> $start_pay_date->format('Y-m-d H:i:s').' +0700',
                        "unit"=> "minutes",
                        "duration"=> $exp_date
                    ]
                    // , "enabled_payments" => []
                ];
                // dd($detail_snap);
                try {
                    $token = $this->generateSnap($detail_snap);

                    $pembayaran = new Pembayaran;
                    $pembayaran->no_transaksi = $no_trans;
                    $pembayaran->id_peserta_seminar = $data->id;
                    $pembayaran->token = $token;
                    $pembayaran->jenis = '1';
                    $pembayaran->status = 0;
                    $pembayaran->created_by = Auth::id();
                    $pembayaran->created_at = Carbon::now()->toDateTimeString();
                    $pembayaran->save();

                    $log_data = [
                        'no_transaksi' => $no_trans,
                        'keterangan' => $detail_snap,
                        'subjek' => 'berhasil membuat transaksi',
                        'status' => 'WAITING',
                        'created_by' => Auth::id(),
                        'created_at' => Carbon::now()->toDateTimeString()
                    ];

                    LogTransaksi::create($log_data);

                } catch (Exception $e) {

                    $log_data = [
                        'no_transaksi' => $no_trans,
                        'keterangan' => $e,
                        'subjek' => 'gagal membuat transaksi',
                        'status' => 'FAIL',
                        'created_by' => Auth::id(),
                        'created_at' => Carbon::now()->toDateTimeString()
                    ];

                    LogTransaksi::create($log_data);
                }

            }
            // $detail = ['nama' => $peserta->nama,
            // 'tema' => $detailseminar->tema,
            // 'email' => $peserta->email, 'nope' => $peserta->nomor_handphone];

            $tema = strip_tags(html_entity_decode($detailseminar->tema));
            $tanggal = \Carbon\Carbon::parse($detailseminar->tgl_awal)->translatedFormat('d F Y');
            $jam = $detailseminar->jam_awal;

            $magic_link = Hashids::encode($peserta->user_r->id);

            $detail = [
                'username' => $peserta->user_r->username,
                // 'password' => 'PASSWORD',
                'magic_link' => $magic_link,
                'email' => $peserta->email,
                'nama' => $peserta->nama,
                'nope' => $peserta->no_hp,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'tema' => $tema,
            ];

            dispatch(new \App\Jobs\DaftarSeminarSudahLogin($detail));


            if($is_free['is_free'] == '0') {
                return redirect('infoseminar')->with('success', 'Pendaftaran Seminar berhasil');
            } else if($is_free['is_free'] == '0') {
                return redirect('pembayaran')
                ->with('success', 'Pendaftaran Seminar berhasil')
                ->with('warning', 'Selesaikan transaksi untuk mengikuti Seminar');
            }
        }
    }
}
