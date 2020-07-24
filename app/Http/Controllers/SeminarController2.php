<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeminarModel;
use App\InstansiModel;
use App\ProvinsiModel;
use App\KotaModel;


class SeminarController2 extends Controller
{
    //
    public function index(){
        $data = SeminarModel::all();
        return view('seminar.index2')->with(compact('data'));
    }

    // create seminar
    public function create(){
        $judul = "Buat Seminar";
        $inisiator = InstansiModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        return view('seminar.create2')->with(compact('judul','inisiator','provinsi','kota'));
    }

    //detail seminar
    public function detail($id){
        $data = SeminarModel::find($id);
        return view('seminar.detail2')->with(compact('data'));
    }

    public function store(Request $request) {
        dd($request);
    }

    public function cetak_sert($id, $email){
        $data['data'] = SertModel::where('no_sertifikat',$id)->where('email', $email)->get();
        $pdf = PDF::loadview('sert.sert_v1',$data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream("Sertifikat.pdf");
    }

    // hapus data seminar
    public function destroy(){
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        SeminarModel::whereIn('id', $idData)->update($user_data);
        return redirect('seminar')->with('success', 'Data terpilih berhasil dihapus');
    }
}
