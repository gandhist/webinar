<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimMarketing extends Model
{
    //
    use SoftDeletes;
    protected $table = 'tim_markt';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function badan_usaha_r()
    {
            return $this->belongsTo('App\BuModel', 'id_bu');
    }

    // Link ke table level_kantor dari field level
    public function jenisusaha_r()
    {
            return $this->belongsTo('App\JenisUsaha', 'jenis_usaha');
    }

    // Link ke table ms_provinsi dari field prop_naker
    public function provinsi_r()
    {
        return $this->belongsTo('App\ProvinsiModel', 'prop');
    }

    // Link ke table ms_kota dari field id_kota
    public function kota_r()
    {
        return $this->belongsTo('App\KotaModel', 'kota');
    }

    // Link ke table bank dari field level
    public function bank_r()
    {
        return $this->belongsTo('App\BankModel', 'id_bank','id_bank');
    }

    public function tim_prod_r()
    {
        return $this->belongsTo('App\TimProduksi', 'id_tim_prod');
    }

    public function leveltim_r()
    {
        return $this->belongsTo('App\LevelTimMarketing', 'level_m');
    }

    public function leveltimatas_r()
    {
        return $this->belongsTo('App\TimMarketing', 'level_m_atas');
    }

    public function golharga_r()
    {
        return $this->belongsTo('App\GolHargaMkt', 'gol_hrg_m','kode');
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
