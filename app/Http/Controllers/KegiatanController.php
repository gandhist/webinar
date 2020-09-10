<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;
use Vinkla\Hashids\Facades\Hashids;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $seminar = Seminar::all();
        $detailseminar = PesertaSeminar::where('id_peserta','=',$peserta['id'])->orderBy('id','desc')->get();
        $hari = Carbon::now()->format('Y-m-d');
        // dd($hari);

        return view('kegiatan.index', ['user' => $request->user()])->with(compact('seminar','peserta','detailseminar','hari'));
    }

    public function detail($id)
    {
        $data = Seminar::find($id);
        return view('kegiatan.detail')->with(compact('data'));
    }
}
