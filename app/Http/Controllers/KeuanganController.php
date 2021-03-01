<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pembayaran;

class KeuanganController extends Controller
{
    //
    public function index(){
        $pembayaran = Pembayaran::whereIn('status', [1, 2])->whereHas('peserta_seminar_trashed', function ($query) {
            return $query->whereHas('seminar_trashed', function ($query) {
                return $query->where('id', '>=', 30);
            });
        })->get();
        return view('keuangan.index')->with(compact('pembayaran'));
    }
}
