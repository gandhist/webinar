<?php

namespace App\Exports;

use App\SeminarModel;
use App\SertInstansiModel;
use App\BuModel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PenyelenggaraAllExport implements WithMultipleSheets
{
    // protected $id;

    public function __construct()
    {
        // $this->id = $id;
    }

    public function sheets(): array
    {
        // $penyelenggara = SertInstansiModel::where('id_seminar', $this->id)->where('status', 1)->pluck('id_instansi')->toArray();
        $ins_peny = BuModel::all()->toArray();

        // dd($ins_peny);
        $sheets = [];

        foreach ($ins_peny as $key) {
            // dd($key);
            $sheets[$key['singkat_bu']] = new PenyelenggaraAllSheets($key['id']);
        }


        return $sheets;
    }

}

