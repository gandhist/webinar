<?php


namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\InstansiModel;
use App\PesertaSeminar;
use App\Seminar;


trait GlobalFunction {

    // generate qr code untuk penanda tangan
    public function generateTtd($data){
         // save barcode permohonan sebagai validitas
         $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $data->nama);
         $url = url('qr_validity', Crypt::encrypt($data->id));
         $nama = "QR_validity_".$data->id.".png";
         $qrcode = \QrCode::margin(100)->format('png')
         ->errorCorrection('L')->size(150)->generate($url, base_path("seminar/qr/$dir_name/baru/$nama"));
    }

    // generate iso number
    public function generate_iso_number($id_iso, $id_kota){
        $code = 'ISO';
        $rn = DB::table('running_number')->where('code',$code)->first();
        $tahun = Carbon::now()->isoFormat('YY');
        if ($tahun == substr($rn->tahun,2,2)) {
            DB::table('running_number')->where('code',$code)->update(
                [
                "rn"=>$rn->rn+1,
                ]);
        }
        else {
            DB::table('running_number')->where('code',$code)->update(
                [
                    "rn"=>'1',
                    'tahun' =>  Carbon::now()->isoFormat('YYYY')
                ]
            );
            $rn = DB::table('running_number')->where('code','ISO')->first();
        }
        $rn = sprintf('%03d', $rn->rn);
        $no_iso = $id_iso.'.'.$id_kota.'.'.$rn.'.'.$tahun;
        return $no_iso;
    }

    // fungsi kirim wa
    public function kirimPesanWA($no_hp, $pesan){
        $userkey = env('USER_ZZ');
        $passkey = env('PASS_ZZ');
        $telepon = $no_hp;
        $message = $pesan;
        $url = env('URL_WA_ZZ');
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'nohp' => $telepon,
            'pesan' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;

    }

    // Midtrans
    public function generateSnap($details) {
        // Minimal details
        // [
        //     'order_id' => string,
        //     'gross_amount' => int,
        // ]

        //Set Your server key

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        \Midtrans\Config::$appendNotifUrl = url('trxi/callback');
        \Midtrans\Config::$overrideNotifUrl = url('trxi/callback');

        // $params = array(
        //     'transaction_details' => $details
        // );
        $snapToken = \Midtrans\Snap::getSnapToken($details);
        // $clientKey = config('services.midtrans.clientKey');

        return $snapToken;
    }
    // End Midtrans

    ////////////// BEGIN API QONTAK WHATSASPP /////////////////////////
    public function getToken(){
        $URL_TOKEN="https://auth.qontak.com/3a5f72a37b5568090a0e676205211e80/oauth/token";
        $URL_CHAN="https://chat-service.qontak.com/api/open/v1/integrations?target_channel=wa";
        $URL_TEMP="https://chat-service.qontak.com/api/open/v1/templates/whatsapp";
        $URL_MESS="https://chat-service.qontak.com/api/open/v1/broadcasts/whatsapp/direct";
        $USER_WA = "p3s@p3sm.or.id";
        $PASS_WA = "000646a5a9a8b1edbc7cf0c49e970bc4ac4bdd43";
        $CLIENT_ID_WA = "RRrn6uIxalR_QaHFlcKOqbjHMG63elEdPTair9B9YdY";
        $CLIENT_SECRET_WA = "Sa8IGIh_HpVK1ZLAF0iFf7jU760osaUNV659pBIZR00";

        $url = env('URL_TOKEN') ?? $URL_TOKEN;
        $username = env('USER_WA') ?? $USER_WA;
        $password = env('PASS_WA') ?? $PASS_WA;
        $client_id = env('CLIENT_ID_WA') ?? $CLIENT_ID_WA;
        $client_secret = env('CLIENT_SECRET_WA') ?? $CLIENT_SECRET_WA;
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'username' => $username,
            'password' => $password,
            'grant_type' => "password",
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }

    public function setupChannel($token){
        $url = env('URL_CHAN');
        $headers = array(
            'Authorization: Bearer '.$token
        );
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }

    public function setupTemplate($token){
        $url = env('URL_TEMP');
        $headers = array(
            'Authorization: Bearer '.$token
        );
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }

    public function sendMessage($token,$body){
        $url = "https://chat-service.qontak.com/api/open/v1/broadcasts/whatsapp/direct";
        $headers = array(
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        );
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($body));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return $results;
    }
    ////////////// END API QONTAK WHATSASPP /////////////////////////

    public function generateNoSert($id_seminar, $id_peserta_seminar) {
        // Nilai return fungsi ini berupa array
        // Value pertama berisi string "No. Sertifikat"
        // Value kedua berisi string "No. Urut Peserta"


        $kode_inisiator = Seminar::select('inisiator')->where('id',$id_seminar)->first();

        $detailseminar = Seminar::find($id_seminar);

        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

        $urutan_seminar = Seminar::select('no_urut')->where('id', '=',$id_seminar)->first();

        $urut = PesertaSeminar::where('id_seminar',$id_seminar)->max('no_urut_peserta'); //Counter nomor urut for peserta

        if($urut == null) {
            $no_urut_peserta = '1';
        } else {
            $no_urut_peserta = $urut + 1;
        }

        // $urutan = PesertaSeminar::select('no_urut_peserta')->where('id', '=',$id)->first();
        // generate no sertifikat
        $inisiator = $kode_instansi['kode_instansi'];
        $status = '1';
        $tahun = substr($detailseminar['tgl_awal'],2,2);
        $bulan = substr($detailseminar['tgl_awal'],5,2);

        $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($no_urut_peserta, 3, "0", STR_PAD_LEFT);

        $cek_no_srtf = PesertaSeminar::where('no_srtf', $no_sert)->first();

        while ($cek_no_srtf) {
            $no_urut_peserta = $no_urut_peserta + 1;
            $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($no_urut_peserta, 3, "0", STR_PAD_LEFT);
            // $cek_no_srtf = PesertaSeminar::where('no_srtf', $no_sert)->first();
        }

        return [$no_sert, $no_urut_peserta];
    }


    public function generateQrSertPeserta($no_sert) {
        // generate qr code
        $url = url("sertifikat/".Crypt::encrypt($no_sert));
        $nama = "QR_Sertifikat_".$no_sert.".png";
        $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

        $dir_name = "file_seminar";
        return $dir_name."/".$nama;
    }

    public function indonesianCode($number){
        $data = [
            'status' => false,
            'nomor' => ''
        ];
        $length = strlen($number);
        $valid_number = $number;
        if ($length > 6) {
            $left_5 = substr($number,0,5);
            $left_4 = substr($number,0,4);
            $left_3 = substr($number,0,3);
            $left_2 = substr($number,0,2);
            $left_1 = substr($number,0,1);
            // +6208
            // if($left_5 == '+6208'){
            //     $pattern = "/^\+6208/i";
            //     $valid_number = preg_replace($pattern, "08", $number);
            //     $data = [
            //         'status' => true,
            //         'nomor' => $valid_number
            //     ];
            // }
            // // 6208 || +628
            // if($left_4 == '6208' || $left_4 == '+628'){
            //     $pattern1 = "/^\+628|^6208/i";
            //     $valid_number = preg_replace($pattern1, "08", $number);
            //     $data = [
            //         'status' => true,
            //         'nomor' => $valid_number
            //     ];
            // }
            // // 628
            // if($left_3 == '628'){
            //     $pattern1 = "/^628/i";
            //     $valid_number = preg_replace($pattern1, "08", $number);
            //     $data = [
            //         'status' => true,
            //         'nomor' => $valid_number
            //     ];
            // }
            // 08
            if($left_2 == '08'){
                $pattern1 = "/^08/i";
                $valid_number = preg_replace($pattern1, "628", $number);
                $data = [
                    'status' => true,
                    'nomor' => $valid_number
                ];
            }
            // 8
            if($left_1 == '8'){
                $valid_number = "628".substr($number,1, $length - 1);
                $data = [
                    'status' => true,
                    'nomor' => $valid_number
                ];
            }
            // $pattern1 = "/^\+628|^6208|^\+6208|^628/i";
            // $match1 = preg_replace($pattern1, "08", $number);
        }
        return $valid_number;
    }
}
