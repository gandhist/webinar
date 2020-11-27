<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimProduksi extends Model
{
    //

    use SoftDeletes;
    protected $table = 'tim_prod';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // Link ke table level_kantor dari field jenis_usaha
    public function jenisusaha()
    {
            return $this->belongsTo('App\JenisUsaha', 'jenis_usaha');
    }

    // Link ke table ms_provinsi dari field prop_tim
    public function provinsi()
    {
        return $this->belongsTo('App\ProvinsiModel', 'prop_tim');
    }

    // Link ke table ms_kota dari field id_kota
    public function kota()
    {
        return $this->belongsTo('App\KotaModel', 'kota_tim');
    }

    // Link ke table bank dari field id_bank
    public function bank()
    {
        return $this->belongsTo('App\BankModel', 'id_bank','id_bank');
    }

    // Link ke table badan usaha dari field pjk3
    public function pjlpjk()
    {
        return $this->belongsTo('App\BuModel', 'pjk3');
    }

    // Link ke table badan usaha dari field pjk3
    public function bu_r()
    {
        return $this->belongsTo('App\BuModel', 'id_bu');
    }

    public function leveltim()
    {
        return $this->belongsTo('App\LevelTimProduksi', 'level_p');
    }

    public function leveltimatas()
    {
        return $this->belongsTo('App\TimProduksi', 'level_p_atas');
    }

    public function golharga_r()
    {
        return $this->belongsTo('App\GolHargaProd', 'gol_hrg_p','kode');
    }

    // Link ke table user dari field created_by
    public function created_r()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    // Link ke table user dari field updated_by
    public function updated_r()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

}
