<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KantorModel extends Model
{
    use SoftDeletes;
    protected $table = "kantor";
    protected $guarded = ['id'];

    // Link level atas
    public function level_atas_r()
    {
        return $this->belongsTo('App\KantorModel', 'level_atas');
    }
    // Link ke table ms_provinsi dari field prop_naker
    public function provinsi()
    {
        return $this->belongsTo('App\ProvinsiModel', 'prop');
    }

    // Link ke table ms_kota dari field id_kota
    public function kotakantor()
    {
        return $this->belongsTo('App\KotaModel', 'kota');
    }
    // Link ke table level_kantor dari field level
    public function levelkantor()
    {
        return $this->belongsTo('App\LevelModel', 'level','id');
    }
}
