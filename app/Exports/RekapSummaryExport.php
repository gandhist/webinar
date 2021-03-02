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

class RekapSummaryExport implements FromView, WithTitle
{
    public function __construct()
    {
        //
    }

    public function view(): View
    {
        $seminar = SeminarModel::all();
        return view('exports.seminar-summary',[
            'seminar' => $seminar,
        ]);
    }

    public function title(): string
    {
        return "Rekap Summary";
    }
}
