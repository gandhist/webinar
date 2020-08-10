<?php
/*
بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ (Bismillahirrahmanirrahim)
artinya : Dengan menyebut nama Allah yang Maha Pengasih lagi Maha Penyayang 
crafted by Gandhi Tabrani ¯\_(ツ)_/¯
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PesertaSeminar;
use PDF;
use Mail;
use App\Mail\EmailLinkSert;

class SertController extends Controller
{
    //

    public function dashboard(){
        $url1 = url('approved/iman');
        $nama1 = "QR_iman.png";
        $qrcode1 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url1, base_path("public/".$nama1));
        $url2 = url('approved/adji');
        $nama2 = "QR_adji.png";
        $qrcode2 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url2, base_path("public/".$nama2));
        $url3 = url('approved/budi_susetyo');
        $nama3 = "QR_budi_susetyo.png";
        $qrcode3 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url3, base_path("public/".$nama3));
        $url4 = url('approved/adji_n');
        $nama4 = "QR_adji_n.png";
        $qrcode4 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url4, base_path("public/".$nama4));

        $url5 = url('approved/viby');
        $nama5 = "viby.png";
        $qrcode5 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url5, base_path("public/".$nama5));

        $url6 = url('approved/irwin');
        $nama6 = "irwin.png";
        $qrcode6 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url6, base_path("public/".$nama6));

        $data = SertModel::all();
        return view('sert.dashboard')->with(compact('data'));
    }

    public function cari(Request $req){
         // filter jenis permohonan
         if ($req->has('no_sertifikat')) {
             $no_sert = $req->input('no_sertifikat');
             $email = $req->input('email');
             $data = SertModel::where('email',$email)->where('no_sertifikat',$no_sert)->get();
             if ($data->count() != 0) {
                 $dataa['data'] = $data;
                $pdf = PDF::loadview('sert.all',$dataa);
                $pdf->setPaper('A4','landscape');
                return $pdf->stream("Sertifikat.pdf");  
             }
             else {
                return redirect('sertifikat/cari')->with('status','No Sertifikat dan Email tidak ditemukan!');
             }
                    
        }

        return view('frontend.main');
        return view('sert.cari');
    }

    public function p3sm(){
        $url4 = "https://p3sm.or.id/";
        $nama4 = "p3sm.png";
        $qrcode4 = \QrCode::size(300)->style('round')->format('png')->merge(public_path('avatar2.png'), .3, true)->errorCorrection('H')->size(150)->generate($url4, base_path("public/".$nama4));
    }

    public function index(){
        $url1 = url('approved/iman');
        $nama1 = "QR_iman.png";
        $qrcode1 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url1, base_path("public/".$nama1));
        $url2 = url('approved/adji');
        $nama2 = "QR_adji.png";
        $qrcode2 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url2, base_path("public/".$nama2));
        $url3 = url('approved/budi_susetyo');
        $nama3 = "QR_budi_susetyo.png";
        $qrcode3 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url3, base_path("public/".$nama3));
        $url4 = url('approved/adji_n');
        $nama4 = "QR_adji_n.png";
        $qrcode4 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url4, base_path("public/".$nama4));
        

        $data['data'] = SertModel::take(10)->get();
        $pdf = PDF::loadview('sert.all',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat_.pdf");
    }

    public function by_sert($id, $email){
        $data['data'] = PesertaSeminar::where('no_srtf',$id)->first();
        // return $data['data'];
        $pdf = PDF::loadview('sert.all',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }

    public function sert_v1($id, $email){
        $data['data'] = SertModel::where('no_sertifikat',$id)->where('email', $email)->get();
        $pdf = PDF::loadview('sert.sert_v1',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }

    public function sert_v2($id, $email){
        $data['data'] = SertModel::where('no_sertifikat',$id)->where('email', $email)->get();
        $pdf = PDF::loadview('sert.sert_v2',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }


    public function sert_v3($id, $email){
        $url7 = url('approved/ludy18');
        $nama7 = "QR_ludy18.png";
        $qrcode7 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url7, base_path("public/".$nama7));
        $url8 = url('approved/irwin18');
        $nama8 = "QR_irwin18.png";
        $qrcode8 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url8, base_path("public/".$nama8));
        $data['data'] = SertModel::where('no_sertifikat',$id)->where('email', $email)->get();
        $pdf = PDF::loadview('sert.sert_v3',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }

    // ttd 1
    public function ttd1(){
        return view('sert.ttd1');

    }

    public function ttd2(){
        return view('sert.ttd2');
    }

    public function ttd3(){
        return view('sert.ttd3');
    }

    public function ttd4(){
        return view('sert.ttd4');
    }

    public function ttd_viby(){
        return view('sert.ttd_viby');
    }

    public function ttd_irwin(){
        return view('sert.ttd_irwin');
    }

    public function ttd_irwin18(){
        return view('sert.ttd_irwin18');
    }

    public function ttd_ludy18(){
        return view('sert.ttd_ludy18');
    }

    public function kirimEmail(){
        $emails = SertModel::where('is_email_sent','0')->get(['id']);
        // return $emails;
        foreach ($emails as $key) {
            $data = SertModel::find($key->id);
            \Mail::to($data->email)->queue(new \App\Mail\EmailLinkSert($data));
        }
        SertModel::where('is_email_sent','0')->update(['is_email_sent'=>'1']);
        return 'job berhasil di buat';
    }

    public function sendEmail($id){
        $emails = SertModel::find($id);
            // dispatch(new \App\Jobs\KirimEmailJob($key->email));
            // $data = SertModel::where('email', $key->email)->first();
            \Mail::to($emails->email)->send(new \App\Mail\EmailLinkSert($emails));
        return "Email berhasil Di Kirim ke $emails->email";
    }


}
