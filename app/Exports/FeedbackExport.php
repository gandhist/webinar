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

class FeedbackExport implements FromView
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
        $daftar = PesertaSeminar::whereIn('id',$seminar)->distinct()->count();
        $absen = AbsensiModel::whereIn('id_peserta_seminar',$seminar)->whereNotNull('jam_cek_in')->count();
        $respons = AbsensiModel::whereIn('id_peserta_seminar',$seminar)->where('is_review','=', 1)->count();
        $narasumber = PesertaSeminar::where('id_seminar',$this->id)->where('status','2')->get();
        $moderator = PesertaSeminar::where('id_seminar',$this->id)->where('status','4')->get();
        $id_nara = PesertaSeminar::where('id_seminar',$this->id)->where('status','2')->pluck('id_peserta')->toArray();
        $id_mode = PesertaSeminar::where('id_seminar',$this->id)->where('status','4')->pluck('id_peserta')->toArray();
        $feedback = FeedbackModel::whereIn('id_peserta_seminar',$seminar)->get();
        $feedback_seminar_full = FeedbackRatingModel::whereIn('id_peserta_seminar',$seminar)->get();
        $feedback_seminar_raw = FeedbackRatingModel::whereIn('id_peserta_seminar',$seminar)->where('tipe','0')->get();
        $feedback_seminar = [   "1" => count($feedback_seminar_raw->where('nilai','1')),
                                "2" => count($feedback_seminar_raw->where('nilai','2')),
                                "3" => count($feedback_seminar_raw->where('nilai','3')),
                                "4" => count($feedback_seminar_raw->where('nilai','4')),
                                "5" => count($feedback_seminar_raw->where('nilai','5')),
                                "jumlah" => count($feedback_seminar_raw),
                                "total" => array_sum($feedback_seminar_raw->pluck('nilai')->toArray()),
                            ];
        if($feedback_seminar['jumlah'] > 0){
            $feedback_seminar["rata_rata"] = round($feedback_seminar['total']/$feedback_seminar['jumlah'],2);
            $feedback_seminar["persen_1"] = round((($feedback_seminar['1']/$feedback_seminar["jumlah"])*100),2);
            $feedback_seminar["persen_2"] = round((($feedback_seminar['2']/$feedback_seminar["jumlah"])*100),2);
            $feedback_seminar["persen_3"] = round((($feedback_seminar['3']/$feedback_seminar["jumlah"])*100),2);
            $feedback_seminar["persen_4"] = round((($feedback_seminar['4']/$feedback_seminar["jumlah"])*100),2);
            $feedback_seminar["persen_5"] = round((($feedback_seminar['5']/$feedback_seminar["jumlah"])*100),2);
        } else{
            $feedback_seminar["rata_rata"] = 0;
            $feedback_seminar["persen_1"] = 0;
            $feedback_seminar["persen_2"] = 0;
            $feedback_seminar["persen_3"] = 0;
            $feedback_seminar["persen_4"] = 0;
            $feedback_seminar["persen_5"] = 0;
        }

        // dd($feedback_seminar);

        $feedback_personal_raw = FeedbackRatingModel::whereIn('id_peserta_seminar',$seminar)->where('tipe','1')->get();
        foreach($narasumber as $n){
            $feedback_personal[$n->id_peserta] = [      "1" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)->where('nilai','1')),
                                                        "2" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)->where('nilai','2')),
                                                        "3" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)->where('nilai','3')),
                                                        "4" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)->where('nilai','4')),
                                                        "5" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)->where('nilai','5')),
                                                        "jumlah" => count($feedback_personal_raw->where('id_peserta',$n->id_peserta)),
                                                        "total" => array_sum($feedback_personal_raw->where('id_peserta',$n->id_peserta)->pluck('nilai')->toArray()),
                                                    ];
            if($feedback_personal[$n->id_peserta]['jumlah'] > 0) {
                $feedback_personal[$n->id_peserta]["rata_rata"] = round($feedback_personal[$n->id_peserta]['total']/$feedback_personal[$n->id_peserta]['jumlah'],2);
                $feedback_personal[$n->id_peserta]["persen_1"] = round((($feedback_personal[$n->id_peserta]['1']/$feedback_personal[$n->id_peserta]["jumlah"])*100),2);
                $feedback_personal[$n->id_peserta]["persen_2"] = round((($feedback_personal[$n->id_peserta]['2']/$feedback_personal[$n->id_peserta]["jumlah"])*100),2);
                $feedback_personal[$n->id_peserta]["persen_3"] = round((($feedback_personal[$n->id_peserta]['3']/$feedback_personal[$n->id_peserta]["jumlah"])*100),2);
                $feedback_personal[$n->id_peserta]["persen_4"] = round((($feedback_personal[$n->id_peserta]['4']/$feedback_personal[$n->id_peserta]["jumlah"])*100),2);
                $feedback_personal[$n->id_peserta]["persen_5"] = round((($feedback_personal[$n->id_peserta]['5']/$feedback_personal[$n->id_peserta]["jumlah"])*100),2);
            } else {
                $feedback_personal[$n->id_peserta]["rata_rata"] = 0;
                $feedback_personal[$n->id_peserta]["persen_1"] = 0;
                $feedback_personal[$n->id_peserta]["persen_2"] = 0;
                $feedback_personal[$n->id_peserta]["persen_3"] = 0;
                $feedback_personal[$n->id_peserta]["persen_4"] = 0;
                $feedback_personal[$n->id_peserta]["persen_5"] = 0;
            }
        }
        // foreach($moderator as $m){
        //     $feedback_personal[$m->id_peserta] = [      "1" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)->where('nilai','1')),
        //                                                 "2" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)->where('nilai','2')),
        //                                                 "3" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)->where('nilai','3')),
        //                                                 "4" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)->where('nilai','4')),
        //                                                 "5" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)->where('nilai','5')),
        //                                                 "jumlah" => count($feedback_personal_raw->where('id_peserta',$m->id_peserta)),
        //                                                 "total" => array_sum($feedback_personal_raw->where('id_peserta',$m->id_peserta)->pluck('nilai')->toArray()),
        //                                             ];
        //     if($feedback_personal[$m->id_peserta]['jumlah'] > 0){
        //         $feedback_personal[$m->id_peserta]["rata_rata"] = round($feedback_personal[$m->id_peserta]['total']/$feedback_personal[$m->id_peserta]['jumlah'],2);
        //         $feedback_personal[$m->id_peserta]["persen_1"] = round((($feedback_personal[$m->id_peserta]['1']/$feedback_personal[$m->id_peserta]["jumlah"])*100),2);
        //         $feedback_personal[$m->id_peserta]["persen_2"] = round((($feedback_personal[$m->id_peserta]['2']/$feedback_personal[$m->id_peserta]["jumlah"])*100),2);
        //         $feedback_personal[$m->id_peserta]["persen_3"] = round((($feedback_personal[$m->id_peserta]['3']/$feedback_personal[$m->id_peserta]["jumlah"])*100),2);
        //         $feedback_personal[$m->id_peserta]["persen_4"] = round((($feedback_personal[$m->id_peserta]['4']/$feedback_personal[$m->id_peserta]["jumlah"])*100),2);
        //         $feedback_personal[$m->id_peserta]["persen_5"] = round((($feedback_personal[$m->id_peserta]['5']/$feedback_personal[$m->id_peserta]["jumlah"])*100),2);
        //     } else {
        //         $feedback_personal[$m->id_peserta]["rata_rata"] = 0;
        //         $feedback_personal[$m->id_peserta]["persen_1"] = 0;
        //         $feedback_personal[$m->id_peserta]["persen_2"] = 0;
        //         $feedback_personal[$m->id_peserta]["persen_3"] = 0;
        //         $feedback_personal[$m->id_peserta]["persen_4"] = 0;
        //         $feedback_personal[$m->id_peserta]["persen_5"] = 0;
        //     }
        // }
        // dd($feedback_personal);

        return view('exports.feedback',[
            'id' => $this->id,
            'detail_seminar' => $detail_seminar,
            'daftar' => $daftar,
            'absen' => $absen,
            'respons' => $respons,
            'peserta' => $peserta,
            'narasumber' => $narasumber,
            'moderator' => $moderator,
            'id_nara' => $id_nara,
            'id_mode' => $id_mode,
            'feedback' => $feedback,
            'feedback_seminar_full' => $feedback_seminar_full,
            'feedback_seminar_raw' => $feedback_seminar_raw,
            'feedback_personal_raw' => $feedback_personal_raw,
            'feedback_seminar' => $feedback_seminar,
            'feedback_personal' => $feedback_personal,
        ]);
    }
}

