<?php

namespace App\Http\Controllers\Iso;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\IsoModel;
use App\KotaModel;
use App\ProvinsiModel;
use App\NegaraModel;
use PDF;

class IsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = IsoModel::all();
        return view('iso.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $judul = "Input Data Sertifikat Iso";
        $save_method = "add";
        $inisiator = IsoModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $negara = NegaraModel::all();
        return view('iso.create')->with(compact('judul','inisiator','provinsi','kota','negara','save_method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_bu' => 'required',
            'id_kota' => 'required',
            'id_prov' => 'required',
            'id_negara' => 'required',
            'no_sert' => 'required',
            'scope' => 'required',
            'alamat' => 'required',
            'tgl_sert' => 'required',
            'tipe_iso' => 'required',
        ],[
            'nama_bu.required' => 'Nama Badan Usaha Harus Di Isi!',
            'id_kota.required' => 'Kota Harus Di Isi!',
            'id_prov.required' => 'Provinsi Harus Di Isi!',
            'id_negara.required' => 'Negara Harus Di Isi!',
            'no_sert.required' => 'No Sertifikat Harus Di Isi!',
            'scope.required' => 'Ruang Linkup/Scope Harus Di Isi!',
            'alamat.required' => 'Alamat Harus Di Isi!',
            'tgl_sert.required' => 'Tanggal Serifikat Harus Di Isi!',
            'tipe_iso.required' => 'Tipe Iso Harus Di Isi!',
        ]);
        $data = new IsoModel;
        $data->create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil di Simpan'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $judul = "Perbarui Data Sertifikat Iso";
        $save_method = "edit";
        $inisiator = IsoModel::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $negara = NegaraModel::all();
        $data = IsoModel::find($id);
        return view('iso.create')->with(compact('data','judul','inisiator','provinsi','kota','negara','save_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama_bu' => 'required',
            'id_kota' => 'required',
            'id_prov' => 'required',
            'id_negara' => 'required',
            'no_sert' => 'required',
            'scope' => 'required',
            'alamat' => 'required',
            'tgl_sert' => 'required',
            'tipe_iso' => 'required',
        ],[
            'nama_bu.required' => 'Nama Badan Usaha Harus Di Isi!',
            'id_kota.required' => 'Kota Harus Di Isi!',
            'id_prov.required' => 'Provinsi Harus Di Isi!',
            'id_negara.required' => 'Negara Harus Di Isi!',
            'no_sert.required' => 'No Sertifikat Harus Di Isi!',
            'scope.required' => 'Ruang Linkup/Scope Harus Di Isi!',
            'alamat.required' => 'Alamat Harus Di Isi!',
            'tgl_sert.required' => 'Tanggal Serifikat Harus Di Isi!',
            'tipe_iso.required' => 'Tipe Iso Harus Di Isi!',
        ]);
        $data = IsoModel::find($id);
        $data->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil di Simpan'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        IsoModel::whereIn('id', $idData)->update($user_data);
        return redirect('admin/iso')->with('success', 'Data terpilih berhasil dihapus');
    }

    public function print($id){
        // generate qr first
        $url4 = url("iso/print/$id");
        $nama4 = "QR_".$id.".png";
        $qrcode4 = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url4, base_path("public/qr/".$nama4));

        $data['data'] = IsoModel::find($id);
        $pdf = PDF::loadview('iso.iso_temp', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream("Sertifikat.pdf");
        return view('iso.iso_temp');
    }
}
