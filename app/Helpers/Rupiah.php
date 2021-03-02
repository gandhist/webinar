<?php

namespace App\Helpers;


class Rupiah {

    public static function RupiahNoRp($angka){
        if(floor($angka) == $angka) {
            $hasil_rupiah = number_format($angka,0,"",".");
        } else {
            $hasil_rupiah = number_format($angka,2,",",".");
        }
        return $hasil_rupiah;
    }

    public static function RupiahRp($angka){
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    }
}
