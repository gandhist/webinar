<?php 


namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

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
    
    ////////////// BEGIN API QONTAK WHATSASPP /////////////////////////
    public function getToken(){   
        $url = env('URL_TOKEN');
        $username = env('USER_WA');
        $password = env('PASS_WA');
        $client_id = env('CLIENT_ID_WA');
        $client_secret = env('CLIENT_SECRET_WA');
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
        $url = env('URL_MESS');
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
    
    public function discChannel($token,$channel){
        $curl = curl_init();
        $headers = array(
            'Authorization: Bearer '.$token
        );
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://service.qontak.com/api/open/v1/integrations/".$channel,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function connChannel($token){
        $username = env('USER_WA');
        $password = env('PASS_WA');
        $headers = array(
            'Authorization: Bearer '.$token
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://service.qontak.com/api/open/v1/integrations/qontak",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array(
            'username' => $username,
            'password' => $password
        ),
        CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }
    ////////////// END API QONTAK WHATSASPP /////////////////////////


}