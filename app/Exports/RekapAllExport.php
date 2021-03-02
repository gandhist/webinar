<?php

namespace App\Exports;

use App\SeminarModel;
use App\SertInstansiModel;
use App\BuModel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class RekapAllExport implements WithMultipleSheets
{
    // protected $id;

    public function __construct()
    {
        // $this->id = $id;
    }

    public function sheets(): array
    {
        // $penyelenggara = SertInstansiModel::where('id_seminar', $this->id)->where('status', 1)->pluck('id_instansi')->toArray();
        $seminar = SeminarModel::orderBy('id', 'desc')->get()->toArray();

        // dd($ins_peny);
        $sheets = [];

        foreach ($seminar as $key) {
            // dd($key);
            $sheets[$key['tema']] = new RekapOneExport($key['id']);
        }


        return $sheets;
    }

}

