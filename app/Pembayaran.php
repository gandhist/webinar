<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\PesertaSeminar;

class Pembayaran extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_pembayaran";

    public function peserta_seminar_r()
    {
        return $this->hasOne('App\PesertaSeminar','id','id_peserta_seminar');
    }

    public function peserta_seminar_trashed()
    {
        return $this->hasOne('App\PesertaSeminar','id','id_peserta_seminar')->withTrashed();
    }


    // audit
    public function updated_by_r(){
        return $this->belongsTo('App\User','updated_by');
    }

    public function created_by_r(){
        return $this->belongsTo('App\User','created_by');
    }
}
