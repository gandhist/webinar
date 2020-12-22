<?php

namespace App\Exports;

use App\SeminarModel;
use App\SertInstansiModel;
use App\BuModel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PenyelenggaraExport implements WithMultipleSheets
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        $penyelenggara = SertInstansiModel::where('id_seminar', $this->id)->where('status', 1)->pluck('id_instansi')->toArray();
        $ins_peny = BuModel::whereIn('id', $penyelenggara)->get()->toArray();

        // dd($ins_peny);
        $sheets = [];

        foreach ($ins_peny as $key) {
            // dd($key);
            $sheets[$key['singkat_bu']] = new PenyelenggaraSheets($this->id, $key['id']);
        }


        return $sheets;
    }

}

