<?php

namespace App\Exports;

// use App\Invoice;
use App\PesertaSeminar;
use App\AbsensiModel;
use App\FeedbackModel;
use App\FeedbackRatingModel;
use App\SeminarModel;
use App\SertInstansiModel;
use App\Peserta;
use App\BuModel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapOneExport implements FromView, WithTitle
{
    protected $seminar;

    public function __construct(int $id_seminar)
    {
        $this->seminar = SeminarModel::find($id_seminar);
    }

    public function view(): View
    {
        return view('exports.seminar',[
            'seminar' => $this->seminar
        ]);
    }

    public function title(): string
    {
        return strip_tags($this->seminar->tema);
    }
}
