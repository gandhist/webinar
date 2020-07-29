<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use App\BankModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InfoSeminarController extends Controller
{
    public function index()
    {
        $data = Seminar::where('status','=','published')->get();
        return view('infoseminar.index')->with(compact('data'));
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

        if(!Auth::user()){
            return redirect('registrasi')->with('pesan', 'Anda harus melakukan registrasi atau login terlebih dahulu');
        } else{
            return view('infoseminar.daftar',['user' => $request->user()])->with(compact('data','bank','peserta'));
        }    
    }

    public function store($id)
    {
        $peserta = Peserta::select('id')->where('user_id',Auth::id())->first();
        $status_peserta = PesertaSeminar::select('status')->where('id_peserta',$peserta['id'])->first();
        $tanggal = Seminar::select('tgl_awal')->where('id', '=',$id)->first();
        $statusbayar = PesertaSeminar::select('is_paid')->where('id_peserta',$peserta['id'])->first();
        
        // generate no sertifikat
        $inisiator = '88';
        $status = $status_peserta['status']; // 1 peserta 2 narasumber 3 panitia 4 moderator
        $tahun = substr($tanggal['tgl_awal'],2,2);
        $bulan = substr($tanggal['tgl_awal'],5,2);

        $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan;
        // dd($no_sert)
        // end of generate

        $data = new PesertaSeminar;
        $data->id_seminar = $id;
        $data->id_peserta = $peserta['id'];
        if ($statusbayar['is_paid'] == '1'){
            $data->is_paid = $statusbayar['is_paid'];
            $data->no_srtf = $no_sert;
        } else {
            $data->is_paid = $statusbayar['is_paid'];
            $data->no_srtf = '';
        } 
        $data->status = '1';
        $data = $data->save();

        return redirect('infoseminar')->with('success', 'Pendaftaran Seminar berhasil');
    }
}
