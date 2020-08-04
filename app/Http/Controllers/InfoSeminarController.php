<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\SeminarModel;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use App\BankModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class InfoSeminarController extends Controller
{
    public function index()
    {
        $data = Seminar::where('status','=','published')->get();
        $user = Peserta::select('id')->where('user_id', Auth::id())->first();
        
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

        if(!Auth::user()){
            $login = '<a href="'.url("login").'">disini</a>';
            return redirect('registrasi')->with('pesan', 'Anda harus melakukan registrasi terlebih dahulu. Klik '.$login.' jika sudah mempunyai akun');
        } else{
            return view('infoseminar.daftar',['user' => $request->user()])->with(compact('data','bank','peserta'));
        }
    }

    public function store(Request $request, $id)
    {
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // dd($peserta);
        $status_peserta = PesertaSeminar::select('status')->where('id_peserta',$peserta['id'])->first();
        $tanggal = Seminar::select('tgl_awal')->where('id', '=',$id)->first();
        $is_free = Seminar::select('is_free')->where('id',$id)->first();
        // $statusbayar = PesertaSeminar::select('is_paid')->where('id_peserta',$peserta['id'])->first();
        $counter = SeminarModel::where('status','published')->get();
        // $jumlah = array();
        // if(count($counter) > 0) {
        //     foreach($counter as $key) {
        //         if(date('m', \strtotime($key->tgl_awal)) == date('m')){
        //             $jumlah[] = $key->no_urut;
        //         }
        //     }
        // }
        // if(count($jumlah) > 0){
        //     if(max($jumlah) > 0) {
        //         $urutan_seminar = max($jumlah) + 1;
        //     } else {
        //         $urutan_seminar = 1;
        //     }
        // } else {
        //     $urutan_seminar = 1;
        // }
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
            $inisiator = '88';
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

        // pengurangan kuota
        $kuota = DB::table('srtf_seminar')->update(['kuota' => DB::raw('GREATEST(kuota - 1, 0)')]);

        return redirect('infoseminar')->with('success', 'Pendaftaran Seminar berhasil');
    }
}
