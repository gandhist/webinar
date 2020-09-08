<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Hashids\Hashids;

use App\TargetBlasting;
use App\LogBlasting;
use App\ReportBlasting;
use App\User;
use App\Peserta;
use App\PesertaSeminar;

class BlastingController extends Controller
{
    //
    public function click($magic_link){
        $hashids = new Hashids();
        $link = $hashids->decode($magic_link);
        // dd($link);
        $jenis = count($link);

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
            return redirect('infoseminar/daftar/'.$link[1])->with('magic_link',$magic_link);

        } else if ($jenis == 2){
            $report = ReportBlasting::where('id_target',$link[0])->where('id_seminar',$link[1])->first();
            if( !(isset($report->first_click)) ){
                $report->first_click = \Carbon\Carbon::now();
                $report->save();
            }
            $report->last_click = \Carbon\Carbon::now();
            $report->save();
            return redirect('registrasi/daftar/'.$link[1])->with('magic_link',$magic_link);
        } else {
            return abort(404);
        }
    }
}
