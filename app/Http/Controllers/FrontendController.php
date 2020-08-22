<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SeminarModel;
use App\Mail\EmailLinkSert as MailSertifikat;

class FrontendController extends Controller
{
    function index()
    {
        $data = SeminarModel::where('status','=','published')->orderBy('id','desc')->get();
        if(Auth::check())
        if(Auth::user()->role_id == 2){
            return view('homeUI')->with(compact('data'));
        }
        else {
            return view('home');
        }
        return view('homeUI')->with(compact('data'));
    }
    public function reset()
    {
        return view('reset');
    }

    public function update()
    {
        $emails = PesertaSeminar::where('no_srtf',$id)->first();
        $email = Peserta::where('id',$emails['id_peserta'])->first();
        $emails->no_sertf = Crypt::encrypt($id);
        \Mail::to($email->email)->send(new MailSertifikat($emails));

        return redirect()->back()->with('alert',"Sertifikat Berhasil dikirim ke $email->email");

    }
}
