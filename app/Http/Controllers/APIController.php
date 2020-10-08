<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seminar;

class APIController extends Controller
{
    //
    public function getData() {

        $seminar_aktif = Seminar::select('id','nama_seminar')->where('is_mulai','!=','2')->get();

        $seminar_selesai = Seminar::select('id','nama_seminar','tema')
        ->where('is_mulai','2')->get();



        $data = [
            'seminar_aktif' => $seminar_aktif,
            'seminar_selesai' => $seminar_selesai
        ];

        return response()->json($data, 200);
    }

    public function fetchData(Request $request) {

    }


}
