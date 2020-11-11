<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    //
    use SoftDeletes;
    protected $table = "daf_sekolah";


    public function personil()
    {
        return $this->belongsTo('App\Personal', 'id_personal', 'id');
    }

    public function jp()
    {
        return $this->belongsTo('App\JenjangPendidikan', 'id_jenjang', 'id_jenjang');
    }
    public function kota_s()
    {
        return $this->belongsTo('App\KotaModel', 'kota_sekolah', 'id');
    }
    public function prov_s()
    {
        return $this->belongsTo('App\ProvinsiModel', 'prop_sekolah', 'id');
    }
    public function negara_s()
    {
        return $this->belongsTo('App\NegaraModel', 'negara', 'id');
    }
}
