<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "feedback";

    // relasi many to many table peserta_seminar
    public function peserta_s(){
        return $this->belongsTo('App\PesertaSeminar','id_peserta_seminar');
    }
}
