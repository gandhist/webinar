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
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PesertaDaftar implements FromView, WithTitle
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $detail_seminar = SeminarModel::where('id',$this->id)->first();
        $peserta = PesertaSeminar::where('id_seminar',$this->id)->get();
        return view('exports.peserta-daftar',[
            // 'id' => $this->id,
            'id' => $this->id,
            'detail_seminar' => $detail_seminar ,
            'peserta' => $peserta,
        ]);
    }


    public function title(): string
    {
        return 'Peserta Daftar';
    }
}
