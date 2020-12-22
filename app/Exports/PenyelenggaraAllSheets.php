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

class PenyelenggaraAllSheets implements FromView, WithTitle
{
    protected $id_ins;
    protected $ins;

    public function __construct(int $id_ins)
    {
        $this->id_ins = $id_ins;
        $this->ins = BuModel::find($id_ins);
    }

    public function view(): View
    {
        $id_seminar = SertInstansiModel::where('id_instansi', $this->id_ins)->whereNull('deleted_at')->whereNull('deleted_by')->pluck('id')->toArray();
        $seminar = SeminarModel::whereIn('id', $id_seminar)->where('status', '!=', 'draft')->get();


        return view('exports.penyelenggara',[
            // 'id' => $this->id,
            'ins' => $this->ins ,
            'seminar' => $seminar
        ]);
    }

    public function title(): string
    {
        return $this->ins->singkat_bu;
    }
}
