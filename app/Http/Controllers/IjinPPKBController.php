<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\ProvinsiModel;
use App\KotaModel;
use App\JenisUsaha;
use App\BentukBuModel;
use App\BankModel;
use App\BuModel;
use App\BidangModel;
use App\SkpPjk3;
use App\TempSkpPjk3;
use Auth;
use Carbon\Carbon;

class IjinPPKBController extends Controller
{
    //

    public function index()
    {
        $idpjk3 =  SkpPjk3::select('kode_pjk3')->groupBy('kode_pjk3')->whereNotNull('kode_pjk3')->get()->toArray();
        $idprov = BuModel::select('id_prop')->groupBy('id_prop')->whereIn('id',$idpjk3)->get();
        $prov = ProvinsiModel::whereIn('id',$idprov)->get();
        // $id_bid = SkpPjk3::select('bid_sk')->groupBy('bid_sk')->get()->toArray();

        $idbidang =  SkpPjk3::select('bid_sk')->groupBy('bid_sk')->whereNotNull('bid_sk')->get()->toArray();
        $bidang = BidangModel::whereIn('id',$idbidang)->get();

        $idjenisusaha =  SkpPjk3::select('ms_bidang.id_jns_usaha')->join('ms_bidang','ms_bidang.id','=','skp_pjk3.bid_sk')->groupBy('ms_bidang.id_jns_usaha')->get()->toArray();
        $jenisusaha = JenisUsaha::whereIn('id',$idjenisusaha)->get();

        $instansi = BuModel::groupBy('instansi_reff')->whereNotNull('instansi_reff')->whereIn('id',$idpjk3)->get();
        $data = SkpPjk3::orderBy('id', 'asc')->whereNotNull('no_sk')->get();
        $hitungjenisusaha = SkpPjk3::orderBy('id', 'asc')->whereNotNull('no_sk')->groupBy('kode_pjk3')->get();
        // $jumlahbadanusaha = masterBadanUsaha::whereIn('jns_usaha',$hitungjenisusaha)->get();
        $pjk3 = SkpPjk3::groupBy('kode_pjk3')->get();
        return view('ijinppkb.index')->with(compact('data','prov','bidang','pjk3','jenisusaha','instansi','hitungjenisusaha'));
    }

    public function filter(Request $request)
    {
        $idpjk3 =  SkpPjk3::select('kode_pjk3')->groupBy('kode_pjk3')->whereNotNull('kode_pjk3')->get()->toArray();
        $idprov = BuModel::select('id_prop')->groupBy('id_prop')->whereIn('id',$idpjk3)->get();
        $prov = ProvinsiModel::whereIn('id',$idprov)->get();
        // $id_bid = SkpPjk3::select('bid_sk')->groupBy('bid_sk')->get()->toArray();

        $idbidang =  SkpPjk3::select('bid_sk')->groupBy('bid_sk')->whereNotNull('bid_sk')->get()->toArray();
        $bidang = BidangModel::whereIn('id',$idbidang)->get();

        $idjenisusaha =  SkpPjk3::select('ms_bidang.id_jns_usaha')->join('ms_bidang','ms_bidang.id','=','skp_pjk3.bid_sk')->groupBy('ms_bidang.id_jns_usaha')->get()->toArray();
        $jenisusaha = JenisUsaha::whereIn('id',$idjenisusaha)->get();

        $instansi = BuModel::groupBy('instansi_reff')->whereNotNull('instansi_reff')->whereIn('id',$idpjk3)->get();
        $data = SkpPjk3::orderBy('id', 'asc')->whereNotNull('no_sk');
        $hitungjenisusaha = SkpPjk3::orderBy('id', 'asc')->whereNotNull('no_sk')->groupBy('kode_pjk3')->get();
        // $jumlahbadanusaha = masterBadanUsaha::whereIn('jns_usaha',$hitungjenisusaha)->get();
        $pjk3 = SkpPjk3::groupBy('kode_pjk3')->get();



        if($request->f_awal_terbit != null && $request->f_akhir_terbit != null){
            $data->whereBetween('tgl_sk', [Carbon::createFromFormat('d/m/Y',$request->f_awal_terbit), Carbon::createFromFormat('d/m/Y',$request->f_akhir_terbit)]);
        }


        // tanggal akhir awal / akhir skp
        if($request->f_awal_akhir != null && $request->f_akhir_akhir != null){
            $data->whereBetween('tgl_akhir_sk', [Carbon::createFromFormat('d/m/Y',$request->f_awal_akhir), Carbon::createFromFormat('d/m/Y',$request->f_akhir_akhir)]);
        }


        if (!$request->f_bidang===NULL || !$request->f_bidang==""){
            $data->where('bid_sk', '=', $request->f_bidang);
        }


        if (!$request->f_pjk3===NULL || !$request->f_pjk3==""){
            $data->where('kode_pjk3', '=', $request->f_pjk3);
        }


        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $id_jns = $request->f_jenis_usaha;
            $bidangpjk3 = BidangModel::select('id')->where('id_jns_usaha',$id_jns)->get()->toArray();
            // dd($bidangpjk3);
            // $badanusaha = masterBadanUsaha::select('id')->where('jns_usaha',$id_jns)->get()->toArray();
            $data->whereIn('bid_sk',$bidangpjk3);
        }


        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $id_prop = $request->f_provinsi;
            $data->whereHas('badan_usaha', function ($query) use($id_prop) {
                $query->where('id_prop', '=', $id_prop);
            });
        }



        if (!$request->f_instansi===NULL || !$request->f_instansi==""){
            $instansi_id = $request->f_instansi;
            $data->whereHas('badan_usaha', function ($query) use($instansi_id) {
                $query->where('instansi_reff', '=', $instansi_id);
            });
        }


        $data->get();

        $x = $data;
        $data = $data->get();

        $x = $x->select('id')->get()->toArray();

        $hitungjenisusaha = SkpPjk3::whereIn('id',$x)->whereNotNull('no_sk')->groupBy('kode_pjk3')->get();


        return view('ijinppkb.index')->with(compact('data','prov','bidang','pjk3','jenisusaha','instansi','hitungjenisusaha'));
    }

    public function create()
    {
        // Hapus Data di temporary bu kontak p
        // TempSkpPjk3::where('id_user', '=', Auth::id())->delete();
        $personil = Personal::all();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::all();
        $jenisusaha = JenisUsaha::where('sektor','PPKB')->get();
        $bentukusaha = BentukBuModel::all();
        $bank = BankModel::all();
        $badanusaha = BuModel::all();
        $bidang = BidangModel::where('sektor','PPKB')->get();
        return view('ijinppkb.create')->with(compact('personil','badanusaha','prov','kota','jenisusaha','bentukusaha','bank','bidang'));
    }

    public function store(Request $request)
    {
        // dd($request->id_bentuk_bu);
        $request->validate([
            'id_kode_pjk3' => 'required',
            'id_nama_p' => 'required',
            'id_nama_kp' => 'required'
        ],
        ['id_kode_pjk3.required'=>'Nama PJK3 harus diisi',
        'id_nama_p.required'=>'Nama Pimpinan harus diisi',
        'id_nama_kp.required'=>'Nama Kontak Person harus diisi'
        ]
        );

        $nama_bu = BuModel::selectRaw('nama_bu,prop_naker')->where('id','=',$request->id_kode_pjk3)->first();
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $nama_bu->nama_bu);

        if (is_null($request->id_jumlah_detail) || $request->id_jumlah_detail=='' )
        {

        }else{
            $jumlah_detail = explode(',', $request->id_jumlah_detail);
            foreach($jumlah_detail as $jumlah_detail) {

                $dataDetail['nama_pimp'] = $request->id_nama_p;
                $dataDetail['jab_pimp'] = $request->id_jab_p;
                $dataDetail['email_pimp'] = $request->id_email_p;
                $dataDetail['no_pimp'] = $request->id_hp_p;

                $dataDetail['nama_kp'] = $request->id_nama_kp;
                $dataDetail['jab_kp'] = $request->id_jab_kp;
                $dataDetail['no_kp'] = $request->id_hp_kp;
                $dataDetail['email_kp'] = $request->id_email_kp;

                $dataDetail['no_rek'] = $request->id_norek_bank;
                $dataDetail['nama_rek'] = $request->id_namarek_bank;
                $dataDetail['id_bank'] = $request->id_nama_bank;

                $dataDetail['prop_naker'] = $nama_bu->prop_naker;
                $dataDetail['kode_pjk3'] = $request->id_kode_pjk3;

                $dataDetail['created_by'] = Auth::id();
                $dataDetail['created_at'] = Carbon::now()->toDateTimeString();

                $x = "bidang_detail_".$jumlah_detail;
                $bid_sk = $request->$x;
                $dataDetail['bid_sk'] = $request->$x;
                $x = "no_skp_".$jumlah_detail;
                $dataDetail['no_sk'] = $request->$x;
                $x = "tgl_terbit_".$jumlah_detail;
                if($request->$x==""){
                    $dataDetail['tgl_sk'] = null;
                }else{
                    $dataDetail['tgl_sk'] = Carbon::createFromFormat('d/m/Y',$request->$x);
                }

                $x = "tgl_akhir_".$jumlah_detail;
                if($request->$x==""){
                    $dataDetail['tgl_akhir_sk'] = null;
                }else{
                    $dataDetail['tgl_akhir_sk'] = Carbon::createFromFormat('d/m/Y',$request->$x);
                }

                $x = "pdf_skp_".$jumlah_detail;

                // handle upload skp
                if ($files = $request->file($x)) {
                    $destinationPath = 'uploads/'.$dir_name.'/skp_pjk3'; // upload path
                    $file = "SKP_Bidang_".$dataDetail['bid_sk'].'_'.Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail['pdf_skp_pjk3'] = $dir_name.'/skp_pjk3/'.$file;
                }
                // selectRaw('nama_bu,prop_naker')->where('id','=',$request->id_kode_pjk3)->first();
                $cek_bidang = SkpPjk3::selectRaw('count(id) as jumlah,id')->where('kode_pjk3','=',$request->id_kode_pjk3)->where('bid_sk','=',$bid_sk)->first();

                if($cek_bidang->jumlah>0){
                    SkpPjk3::where('id','=', $cek_bidang->id)->update($dataDetail);
                }else{
                    SkpPjk3::create($dataDetail);
                }
            }
        }

        // Insert Table Detail Kontak

        return redirect('ijinppkb')->with('message', 'Data berhasil ditambahkan');

    }

    public function destroy(Request $request)
    {
        $idData = explode(',', $request->idHapusData);
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        SkpPjk3::whereIn('id', $idData)->update($user_data);
        return redirect('ijinppkb')->with('message', 'Data berhasil dihapus');
    }

    public function searchPersonilByName(Request $request){
        $param = $request->input('query');
        $data = Personal::where('nama','LIKE',"%$param%")->get();
        return $data;
    }



    public function getPjk3($id)
    {
        $dataPjk3 = BuModel::where('id','=',$id)->first();
        if (!$dataPjk3->id_prop===NULL || !$dataPjk3->id_prop==""){
            $dataPjk3->id_prop = $dataPjk3->provinsibu->nama;
        }
        if (!$dataPjk3->id_kota===NULL || !$dataPjk3->id_kota==""){
            $dataPjk3->id_kota = $dataPjk3->kota->nama;
        }
        // if (!$dataPjk3->id_bank===NULL || !$dataPjk3->id_bank==""){
        //     $dataPjk3->id_bank = $dataPjk3->bank->Nama_Bank;
        // }
        if (!$dataPjk3->prop_naker===NULL || !$dataPjk3->prop_naker==""){
            $dataPjk3->prop_naker = $dataPjk3->provinsi->nama;
        }
         // bank
        // return $dataPjk3;
        $skpPjk3 = SkpPjk3::with('bidang.jenis_usaha')->with('bank_r')->where('kode_pjk3','=',$id)->get();
        $cekijin = $skpPjk3->count();
        if($cekijin<=0){
            $nama_pimp_cek = 0;
            $nama_kp_cek = 0;
        }else{
            $x = $skpPjk3->toArray();
            $nama_pimp_cek = Personal::where('nama',$x[0]['nama_pimp'])->count();
            $nama_kp_cek = Personal::where('nama',$x[0]['nama_kp'])->count();
        }
        // dd($cekijin);

        // if (!$skpPjk3->bid_sk===NULL || !$skpPjk3->bid_sk==""){
        //     $skpPjk3->bid_sk = $skpPjk3->bidang->nama_bidang;
        // }

        // $dataPjk3 = masterBadanUsaha::where('id','=',$id)->first();
        // return $dataPjk3->provinsi->nama;

        return response()->json(['dataPjk3' => $dataPjk3,'skpPjk3' => $skpPjk3,'cek_pimp'=>$nama_pimp_cek,'cek_kp'=>$nama_kp_cek]);
    }


    public function deleteskppjk3(Request $request){
        // Hapus Data di temporary bu kontak p
        TempSkpPjk3::where('id_user', '=', Auth::id())->where('id_jenis_usaha','=',$request->id_jenis_usaha)->where('id_bidang','=',$request->id_bidang)->delete();
        return "berhasil";
    }

    public function addskppjk3(Request $request){
        $data['id_jenis_usaha'] = $request->id_jenis_usaha;
        $data['id_bidang'] = $request->id_bidang;
        $id_user = Auth::id();
        $data['id_user'] = $id_user;

        TempSkpPjk3::create($data);

        return "Sukses";
    }

    public function selectskppjk3(Request $request){

        $id_user = Auth::id();

        $tmp_skp_pjk3 = TempSkpPjk3::select('id_bidang')->where('id_jenis_usaha','=',$request->id_jenis_usaha)->where('id_user','=',$id_user)->get();
        return $data = BidangModel::whereNotIn('id',$tmp_skp_pjk3)->where('id_jns_usaha','=',$request->id_jenis_usaha)
                ->get(['id','nama_bidang as text']);
    }

    public function deleteallskppjk3(Request $request){
        // Hapus Data di temporary bu kontak p
        TempSkpPjk3::where('id_user', '=', Auth::id())->delete();
        return "berhasil";
    }

}
