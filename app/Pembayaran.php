<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_pembayaran";

    public function peserta_seminar_r()
    {
        return $this->hasOne('App\PesertaSeminar','id','id_peserta_seminar');
    }
}
