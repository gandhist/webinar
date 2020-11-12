<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Vinkla\Hashids\Facades\Hashids;

use App\TargetBlasting;
use App\LogBlasting;
use App\ReportBlasting;
use App\SeminarModel;
use App\User;
use App\Peserta;
use App\PesertaSeminar;

class BlastingController extends Controller
{
    //
    public function click($magic_link){
        $hashids = new Hashids();
        $link = Hashids::decode($magic_link);
        // dd($link);
        $jenis = count($link);
        $seminar = SeminarModel::where('id', $link[1])->first();

        if($jenis == 3){
            $report = ReportBlasting::where('id_target',$link[0])->where('id_seminar',$link[1])->first();
            if( !(isset($report->first_click)) ){
                $report->first_click = \Carbon\Carbon::now();
                $report->save();
            }
            $report->last_click = \Carbon\Carbon::now();
            $report->save();

            $user = User::where('id', $link[2])->first();
            Auth::login($user);

            // $seminar = SeminarModel::where('id', $link[1])->first();

            if(isset($seminar->slug)) {
                $blast_target_id = $link[0];
                $magic_link = $magic_link;
                $data = SeminarModel::find($link[1]);
                // dd($data);
                // return redirect('infoseminar/daftar/'.$seminar->slug)->with('blast_target_id',$link[0])->with('magic_link',$magic_link)->with('data', $seminar);
                // return redirect('infoseminar/daftar/'.$seminar->slug)->with(compact('blast_target_id','magic_link','data'));

                if($seminar->is_mulai == 2){
                    return view('infoseminar.daftar',['user' => $user])->with(compact('blast_target_id','magic_link','data'))->with('udahan',"Seminar telah selesai, silahkan mendaftar seminar lain");
                } else {
                    return view('infoseminar.daftar',['user' => $user])->with(compact('blast_target_id','magic_link','data'));
                }
                // return view('')->with(compact('blast_target_id','magic_link','data'));
            } else {
                $data = SeminarModel::find($link[1]);

                if($seminar->is_mulai == 2){

                    return redirect('infoseminar/daftar/'.$link[1])->with('blast_target_id',$link[0])->with('magic_link',$magic_link)->with('data', $data)->with('udahan',"Seminar telah selesai, silahkan mendaftar seminar lain");
                } else {
                    return redirect('infoseminar/daftar/'.$link[1])->with('blast_target_id',$link[0])->with('magic_link',$magic_link)->with('data', $data);
                }
            }


        } else if ($jenis == 2){
            $report = ReportBlasting::where('id_target',$link[0])->where('id_seminar',$link[1])->first();
            if( !(isset($report->first_click)) ){
                $report->first_click = \Carbon\Carbon::now();
                $report->save();
            }
            $report->last_click = \Carbon\Carbon::now();
            $report->save();

            // $seminar = SeminarModel::where('id', $link[1])->first();
            if(isset($seminar->slug)){
                if($seminar->is_mulai == 2){
                    return redirect('registrasi/daftar/'.$seminar->slug)->with('blast_target_id',$link[0])->with('magic_link',$magic_link)->with('udahan',"Seminar telah selesai, silahkan mendaftar seminar lain");
                } else {
                    return redirect('registrasi/daftar/'.$seminar->slug)->with('blast_target_id',$link[0])->with('magic_link',$magic_link);
                }
            } else {
                if($seminar->is_mulai == 2) {
                    return redirect('registrasi/daftar/'.$link[1])->with('blast_target_id',$link[0])->with('magic_link',$magic_link)->with('udahan',"Seminar telah selesai, silahkan mendaftar seminar lain");
                } else {
                    return redirect('registrasi/daftar/'.$link[1])->with('blast_target_id',$link[0])->with('magic_link',$magic_link);
                }
            }

        } else {
            return abort(404);
        }
    }
}
