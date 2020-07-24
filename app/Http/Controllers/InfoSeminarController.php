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

        $data = new PesertaSeminar;
        $data->id_seminar = $id;
        $data->id_peserta = $peserta['id'];
        $data->is_paid = '1';
        $data->no_srtf = '';
        $data->status = '1';
        $data = $data->save();

        return redirect('infoseminar')->with('success', 'Pendaftaran Seminar berhasil');
    }
}
