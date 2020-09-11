<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PesertaSeminar;
use App\SeminarModel;
use App\Peserta;
use Carbon\Carbon;

class StatistikSeminarController extends Controller
{
    // statistik seminar
    public function index($id){
        $seminar = SeminarModel::where('id',$id)->first();
        $id_peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->pluck('id_peserta');
        // $id_peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )>pluck('id');


        $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->get();
        $peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )->get();
        // $peserta = Peserta::whereIn('id', $id_peserta_seminar_baru)->get();
        // dd($pesertabaru);

        $data_peserta_seminar = [0];
        $data_user_baru = [0];

        for($i = 0 ; $i < 24 ; $i++){
            $from = Carbon::today()->addHours($i);
            $to = Carbon::today()->addHours($i+1);
            $jumlah_pesertaseminar_jam_ini = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->count();
            $jumlah_pesertabaru_jam_ini = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$from, $to])->count();

            array_push($data_peserta_seminar, $jumlah_pesertaseminar_jam_ini);
            array_push($data_user_baru, $jumlah_pesertabaru_jam_ini);
        }

        return view('seminar.statistik')->with(compact('seminar','peserta_seminar_baru','peserta_baru','data_peserta_seminar','data_user_baru'));
    }

    public function filter($id) {
        //
    }
}
