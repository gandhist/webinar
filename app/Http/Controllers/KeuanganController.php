<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Pembayaran;
use App\Seminar;

class KeuanganController extends Controller
{
    //
    public function index(Request $request){
        $pembayaran = Pembayaran::whereIn('status', [1, 2])->whereHas('peserta_seminar_trashed', function ($query) {
            return $query->whereHas('seminar_trashed', function ($query) {
                return $query->where('id', '>=', 30);
            });
        });


        // validasi if filter
        // awal kegiatan
        if($request->f_awal_terbit){
            if(empty($request->f_akhir_terbit)) {
                $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                    return $query->whereHas('seminar_trashed', function($query) use ($request) {
                        return $query->whereDate('tgl_awal', '>=',Carbon::createFromFormat('d/m/Y',$request->f_awal_terbit)->toDateString());
                    });
                });

                // as request pak koko tanggal 14 12 2020, jika hanya tanggal awal saja di isi maka data_jadwal yang tampil hanya yang tanggal awalnya match saja
            }
            else {
                // empty($request->f_akhir_terbit) ? $request->f_akhir_terbit = $request->f_awal_terbit : $request->f_akhir_terbit = $request->f_akhir_terbit;

                $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                    return $query->whereHas('seminar_trashed', function($query) use ($request) {
                        return $query->whereBetween('tgl_awal', [Carbon::createFromFormat('d/m/Y',$request->f_awal_terbit)->toDateString(), Carbon::createFromFormat('d/m/Y',$request->f_akhir_terbit)->toDateString()]);
                    });
                });

            }
        }

        // jika akhir terbit
        if($request->f_akhir_terbit){
            $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                return $query->whereHas('seminar_trashed', function($query) use ($request) {
                    return $query->whereDate('tgl_awal', '<=',Carbon::createFromFormat('d/m/Y',$request->f_akhir_terbit)->toDateString());
                });
            });

        }
        // akhir kegiatan tgl awal
        if($request->f_awal_akhir){
            if(empty($request->f_akhir_terbit)) {
                $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                    return $query->whereHas('seminar_trashed', function($query) use ($request) {
                        return $query->whereDate('tgl_akhir', '>=',Carbon::createFromFormat('d/m/Y',$request->f_awal_akhir)->toDateString());
                    });
                });

            }
            else {
                // empty($request->f_akhir_akhir) ? $request->f_akhir_akhir = $request->f_awal_akhir : $request->f_akhir_akhir = $request->f_akhir_akhir;
                $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                    return $query->whereHas('seminar_trashed', function($query) use ($request) {
                        return $query->whereBetween('tgl_akhir', [Carbon::createFromFormat('d/m/Y',$request->f_awal_akhir), Carbon::createFromFormat('d/m/Y',$request->f_akhir_akhir)]);
                    });
                });

            }
        }
        // akhir kegiatan tanggal akhir
        if($request->f_akhir_akhir){
            $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                return $query->whereHas('seminar_trashed', function($query) use ($request) {
                    return $query->whereDate('tgl_akhir', '<=',Carbon::createFromFormat('d/m/Y',$request->f_akhir_akhir)->toDateString());
                });
            });
        }

        if($request->f_kgt){
            $pembayaran->whereHas('peserta_seminar_trashed', function($query) use ($request) {
                return $query->whereHas('seminar_trashed', function($query) use ($request) {
                    return $query->where('id', '=', $request->f_kgt);
                });
            });
        }

        if($request->f_sts){
            $pembayaran->where('status', $request->f_sts);
        }

        $pembayaran = $pembayaran->get();

        $seminar = Seminar::where('id', '>=', 30)->orderBy('id', 'desc')->get();
        $status = [
            '1' => 'SUCCESS',
            '2' => 'PENDING'
        ];
        return view('keuangan.index')->with(compact('pembayaran', 'seminar', 'status'));
    }
}
