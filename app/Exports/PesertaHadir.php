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

class PesertaHadir implements FromView, WithTitle
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $detail_seminar = SeminarModel::where('id',$this->id)->first();
        $seminar = PesertaSeminar::select('id')->where('id_seminar','=',$this->id);
        $peserta = PesertaSeminar::where('id_seminar',$this->id)->get();
        $hadir = AbsensiModel::whereIn('id_peserta_seminar',$seminar)->get();
        // dd($hadir->first());
        return view('exports.peserta-hadir',[
            // 'id' => $this->id,
            'id' => $this->id,
            'detail_seminar' => $detail_seminar ,
            'peserta' => $peserta,
            'hadir' => $hadir
        ]);
    }

    public function title(): string
    {
        return 'Peserta Hadir';
    }
}
