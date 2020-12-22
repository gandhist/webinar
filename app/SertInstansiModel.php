<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertInstansiModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_instansi";
    protected $guarded = "id";

    public function bu_instansi(){
        return $this->belongsTo('App\BuModel', 'id_instansi');
    }

    public function seminar()
    {
        return $this->belongsTo('App\Seminar', 'id_seminar', 'id');
    }

    public function seminar_ho()
    {
        return $this->hasOne('App\Seminar', 'id', 'id_seminar');
    }
}
