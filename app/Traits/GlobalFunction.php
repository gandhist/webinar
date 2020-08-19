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

}