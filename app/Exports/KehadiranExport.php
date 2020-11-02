<?php

namespace App\Exports;

// use App\Invoice;
use App\PesertaSeminar;
use App\AbsensiModel;
use App\FeedbackModel;
use App\FeedbackRatingModel;
use App\SeminarModel;
use App\Peserta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class KehadiranExport implements WithMultipleSheets
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    // public function view(): View
    // {
    //     return view('exports.kehadiran',[
    //         'id' => $this->id,
    //     ]);
    // }


    public function sheets(): array
    {
        $sheets = [
            "Peserta Daftar" => new PesertaDaftar($this->id),
            "Peserta Hadir" => new PesertaHadir($this->id),
            "Peserta Tidak Hadir" => new PesertaTidakHadir($this->id),
        ];

        return $sheets;
    }

}

