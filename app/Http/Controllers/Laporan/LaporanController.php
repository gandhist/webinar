<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\isoScope;
use App\isoStandard;
use App\Laporan;
use App\IsoBuModel;
use App\IsoBuKontakP;
use App\isoLapScope;
use App\isoDoc;
use App\isoLapObs;
use App\isoObservasi;
use Carbon\Carbon;
use App\IsoModel;
use App\KotaModel;
use App\ProvinsiModel;
use App\NegaraModel;
use App\StatusModel;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Traits\GlobalFunction;


class LaporanController extends Controller
{
    use GlobalFunction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Laporan::all();
        return view('laporan.index')->with(compact('data'));
    }

    public function chained_scope($iso){
        $doc = isoDoc::where('id_iso',$iso)->get();
        $obs = isoObservasi::where('id_iso',$iso)->get();
        $data = [
            'doc' => $doc, 
            'obs' => $obs
        ];
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $scope = isoScope::all();
        $standard = isoStandard::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $negara = NegaraModel::all();
        $status = StatusModel::all();
        return view('laporan.create')->with(compact('scope','standard','provinsi','kota','negara','status'));
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
        // return $request->all();
        $request->validate(
            [
                "nama_bu" => "required",
                "alamat" => "required",
                // "id_number" => "required",
                "visit_number" => "required",
                "tanggal" => "required",
                "visit_type" => "required",
                "comp_rep" => "required",
                "site_audited" => "required",
                "lead_auditor" => "required",
                "additional_members" => "required",
                "scope" => "required",
            ],
            [
                "nama_bu.required" => "Organizatation Harus di isi!",
                "alamat.required" => "Alamat Harus di isi!",
            ]
        );
        $bu = new IsoBuModel;
        $bu->id_negara = $request->id_negara;
        $bu->id_prop = $request->id_prov;
        $bu->id_kota = $request->id_kota;
        $bu->nama_bu = $request->nama_bu;
        $bu->alamat = $request->alamat;
        $simpan_bu = $bu->save();

        $cp = new IsoBuKontakP;
        $cp->id_bu = $bu->id;
        $cp->nama_pimp = $request->comp_rep;
        $cp->jab_pimp = $request->jab_pimp;
        $cp->save();

        $lp = new Laporan;
        $lp->id_bu = $bu->id;
        $lp->status = $request->status;
        // $lp->id_number = $request->id_number;
        $lp->iso_standard = $request->standard;
        $lp->visit_number = $request->visit_number;
        $lp->audit_date = $request->tanggal;
        $lp->visit_type = $request->visit_type;
        $lp->site_audited = $request->site_audited;
        $lp->lead_auditor = $request->lead_auditor;
        $lp->additional_member = $request->additional_members;
        $lp->scope_multi_situs = $request->multi_situs;
        $lp->audit_sebelumnya = $request->audit_sebelumnya;
        $lp->tas_1 = $request->tas_1;
        $lp->tas_2 = $request->tas_2;
        $lp->tas_3 = $request->tas_3;
        $lp->ta_1 = $request->ta_1;
        $lp->ta_2 = $request->ta_2;
        $lp->ta_3 = $request->ta_3;
        $lp->ta_4 = $request->ta_4;
        $lp->ta_5 = $request->ta_5;
        $lp->ta_6 = $request->ta_6;
        $lp->tikor = $request->tikor;
        $lp->car = $request->car;
        $lp->date_audit = $request->date_audit;
        $lp->or1 = $request->or1;
        $lp->dept = $request->dept;
        $lp->doc_ref = $request->doc_ref;
        $lp->standard_ref = $request->std_ref;
        $lp->car_no = $request->car_no;
        $lp->car_date = $request->car_date;
        $lp->doc = $request->doc;
        $lp->or2 = $request->or2;
        $lp->auditor1 = $request->auditor1;
        $lp->pencegahan = $request->pencegahan;
        $lp->or3 = $request->or3;
        $lp->date_or = $request->date_or;
        $lp->penerimaan = $request->penerimaan;
        $lp->auditor2 = $request->auditor2;
        $lp->auditor_date = $request->auditor_date;
        $lp_save = $lp->save();
        $px_nama = "satf_";
        $px_val = "satf_val_";
        for ($i=0; $i < 100 ; $i++) { 
            if ($request->has($px_nama.$i)) {
                // add new data
                // echo $request->input($px_val.$i);
                $obs = new isoLapObs;
                $obs->id_laporan = $lp->id;
                $obs->id_obs = $request->input($px_nama.$i);
                $obs->nilai = $request->input($px_val.$i);
                $obs->created_by = Auth::id();
                $obs->created_at = Carbon::now()->toDateTimeString();
                $obs->save();
                
            }
        }
        foreach($request->scope as $key => $val){
            $scope = new isoLapScope;
            $scope->id_laporan = $lp->id;
            $scope->id_scope = $val;
            $scope->save();
        }
        $iso = new IsoModel;
        $iso->id_laporan = $lp->id;
        $iso->no_sert = $request->id_number;
        $iso->nama_bu = $request->nama_bu;
        $iso->alamat = $request->alamat;
        $iso->tipe_iso = $request->standard;
        $iso->no_sert = $request->standard;
        $iso->tgl_sert = $request->tanggal;
        $iso->valid_date = Carbon::parse($request->tanggal)->addYear(3)->isoFormat("YYYY-MM-DD"); 
        $iso->first_surv = Carbon::parse($request->tanggal)->addYear(1)->isoFormat("YYYY-MM-DD"); 
        $iso->second_surv = Carbon::parse($request->tanggal)->addYear(2)->isoFormat("YYYY-MM-DD"); 
        $iso->recertification = Carbon::parse($request->tanggal)->addYear(3)->isoFormat("YYYY-MM-DD"); 
        $iso->save();
        return response()->json([
            'status' => true,
            'message' => "Laporan berhasil tersimpan!"
        ],200);

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
        $data = Laporan::find($id);
        $scope = isoScope::all();
        $standard = isoStandard::all();
        $provinsi = ProvinsiModel::all();
        $kota = KotaModel::all();
        $negara = NegaraModel::all();
        $status = StatusModel::all();
        $doc = IsoDoc::where('id_iso',$data->iso_standard)->get();
        return view('laporan.edit')->with(compact('data','scope','standard','id','doc', 'provinsi','kota','negara','status'));
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
        $lp = Laporan::find($id);
        $request->validate(
            [
                "nama_bu" => "required",
                "alamat" => "required",
                "id_number" => "required",
                "visit_number" => "required",
                "tanggal" => "required",
                "visit_type" => "required",
                "comp_rep" => "required",
                "site_audited" => "required",
                "lead_auditor" => "required",
                "additional_members" => "required",
                "scope" => "required",
            ],
            [
                "nama_bu.required" => "Organizatation Harus di isi!",
                "alamat.required" => "Alamat Harus di isi!",
            ]
        );
        $bu = IsoBuModel::find($lp->id_bu);
        $bu->id_negara = $request->id_negara;
        $bu->id_prop = $request->id_prov;
        $bu->id_kota = $request->id_kota;
        $bu->nama_bu = $request->nama_bu;
        $bu->alamat = $request->alamat;
        $simpan_bu = $bu->save();

        $cp = IsoBuKontakP::where('id_bu',$lp->id_bu)->first();
        $cp->id_bu = $bu->id;
        $cp->nama_pimp = $request->comp_rep;
        $cp->jab_pimp = $request->jab_pimp;
        $cp->save();

        // $lp = new Laporan;
        // $lp->id_bu = $bu->id;
        $lp->id_number = $request->id_number;
        
        // $lp->iso_standard = $request->standard;
        $lp->status = $request->status;
        $lp->visit_number = $request->visit_number;
        $lp->audit_date = $request->tanggal;
        $lp->visit_type = $request->visit_type;
        $lp->site_audited = $request->site_audited;
        $lp->lead_auditor = $request->lead_auditor;
        $lp->additional_member = $request->additional_members;
        $lp->scope_multi_situs = $request->multi_situs;
        $lp->audit_sebelumnya = $request->audit_sebelumnya;
        $lp->tas_1 = $request->tas_1;
        $lp->tas_2 = $request->tas_2;
        $lp->tas_3 = $request->tas_3;
        $lp->ta_1 = $request->ta_1;
        $lp->ta_2 = $request->ta_2;
        $lp->ta_3 = $request->ta_3;
        $lp->ta_4 = $request->ta_4;
        $lp->ta_5 = $request->ta_5;
        $lp->ta_6 = $request->ta_6;
        $lp->tikor = $request->tikor;
        $lp->car = $request->car;
        $lp->date_audit = $request->date_audit;
        $lp->or1 = $request->or1;
        $lp->dept = $request->dept;
        $lp->doc_ref = $request->doc_ref;
        $lp->standard_ref = $request->std_ref;
        $lp->car_no = $request->car_no;
        $lp->car_date = $request->car_date;
        $lp->doc = $request->doc;
        $lp->or2 = $request->or2;
        $lp->auditor1 = $request->auditor1;
        $lp->pencegahan = $request->pencegahan;
        $lp->or3 = $request->or3;
        $lp->date_or = $request->date_or;
        $lp->penerimaan = $request->penerimaan;
        $lp->auditor2 = $request->auditor2;
        $lp->auditor_date = $request->auditor_date;
        $lp_save = $lp->save();
        $px_nama = "satf_";
        $px_val = "satf_val_";
        $id_obs_delete = [];
        for ($i=0; $i < 100 ; $i++) { 
            if ($request->has($px_nama.$i)) {
                // add new data
                if($request->input('id_satf_'.$i) == 'new_data' ){
                    $obs = new isoLapObs;
                    $obs->id_laporan = $lp->id;
                    $obs->id_obs = $request->input($px_nama.$i);
                    $obs->nilai = $request->input($px_val.$i);
                    $obs->created_by = Auth::id();
                    $obs->created_at = Carbon::now()->toDateTimeString();
                    $obs->save();
                    $id_obs_delete[] = $obs->id;
                }
                // update
                else {
                    // echo $request->input('id_satf_'.$i);
                    $obs = isoLapObs::find($request->input('id_satf_'.$i));
                    // $obs->id_laporan = $lp->id;
                    $obs->id_obs = $request->input($px_nama.$i);
                    $obs->nilai = $request->input($px_val.$i);
                    $obs->updated_by = Auth::id();
                    $obs->updated_at = Carbon::now()->toDateTimeString();
                    $obs->save();
                    $id_obs_delete[] = $obs->id;
                }
                
            }
        }
        // $obs_del = isoLapObs::whereNotIn('id',$id_obs_delete)->update(
        //     [
        //         'deleted_by' => Auth::id(),
        //         'deleted_at' => Carbon::now()->toDateTimeString(),
        //     ]
        // );
        // di delete dengan ajax
        $del = isoLapScope::where('id_laporan',$lp->id)->update(
            [
                'deleted_by' => Auth::id(),
                'deleted_at' => Carbon::now()->toDateTimeString(),
            ]
        );
        foreach($request->scope as $key => $val){
            
            $scope = new isoLapScope;
            $scope->id_laporan = $lp->id;
            $scope->id_scope = $val;
            $scope->save();
        }
        $iso = IsoModel::where('id_laporan',$lp->id)->first();
        $iso->status = $request->status;
        $iso->id_laporan = $lp->id;
        $iso->no_sert = $request->id_number;
        $iso->nama_bu = $request->nama_bu;
        $iso->alamat = $request->alamat;
        $iso->tipe_iso = $lp->iso_standard;
        $iso->no_sert = $request->id_number;
        $iso->tgl_sert = $request->tanggal;
        $iso->valid_date = Carbon::parse($request->tanggal)->addYear(3)->isoFormat("YYYY-MM-DD"); 
        $iso->first_surv = Carbon::parse($request->tanggal)->addYear(1)->isoFormat("YYYY-MM-DD"); 
        $iso->second_surv = Carbon::parse($request->tanggal)->addYear(2)->isoFormat("YYYY-MM-DD"); 
        $iso->recertification = Carbon::parse($request->tanggal)->addYear(3)->isoFormat("YYYY-MM-DD"); 
        $iso->updated_by = Auth::id();
        $iso->updated_at =  Carbon::now()->toDateTimeString();
        $iso->save();
        return response()->json([
            'status' => true,
            'message' => "Laporan berhasil di Perbarui!"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = explode(',',$request->idHapusData);
        $data = Laporan::whereIn('id',$id);
        $data->update([
            'deleted_at' => Carbon::now()->toDateTimeString(),
            'deleted_by' => Auth::id(),
        ]);
        
        $iso = IsoModel::whereIn('id_laporan', $id);
        $iso->update([
            'deleted_at' => Carbon::now()->toDateTimeString(),
            'deleted_by' => Auth::id(),
        ]);
        return redirect('laporan')->with('success','Data Berhasil dihapus');
    }

    public function print($id){

        $data['data'] = Laporan::find($id);
        $pdf = PDF::loadview('laporan.temp', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream("laporan.pdf");
    }

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

    // ajax hapus observasi
    public function  hapusObs(Request $request){
        $data = isoLapObs::find($request->id);
        $save = $data->update([
            'deleted_at' => Carbon::now()->toDateTimeString(),
            'deleted_by' => Auth::id(),
        ]);
        if($save){
            return response()->json([
                'status' => true,
                'message' => "Item Observasi berhasil di hapus!"
            ],200);
        }
        else{
            return response()->json([
            'status' => false,
            'message' => "gagal dalam menghapus item observasi!"
        ],200);
        }
    }
}
