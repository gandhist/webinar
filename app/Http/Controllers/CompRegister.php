<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CompRegister extends Controller
{
    //
    public function chained_prov(Request $req){
        if ($req->prov) {
            return $data = DB::table('ms_kota')
                ->where('provinsi_id', '=', $req->prov)
                ->get(['id','nama as text']);
        }
        else {
            return $data = DB::table('ms_kota')
                ->where('id', '=', $req->kota)
                ->get(['provinsi_id']);
        }
    }
}
