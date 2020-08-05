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

}