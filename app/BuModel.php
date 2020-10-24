<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "badan_usaha";

    // relasi ke status model
    public function status_model_r(){
        return $this->belongsTo('App\StatusBUModel','status_kantor');
    }
    // relasi belongs to badan usaha
    public function bu_p_r(){
        return $this->belongsTo('App\BuKontakP','id','id_bu');
    }

    // Link ke table ms_bentuk_usaha dari field id_bentuk_usaha
    public function bentukusaha()
    {
        return $this->hasOne('App\BentukBuModel', 'id' ,'id_bentuk_usaha');
    }
    // relasi ke status model
    public function status(){
        return $this->hasOne('App\StatusBUModel', 'id' ,'status_kantor');
        // return $this->belongsTo('App\StatusBUModel','status_kantor');
    }


    // Link ke table ms_provinsi dari field prop_naker
    public function provinsi()
    {
        // return $this->hasOne('App\ProvinsiModel', 'id' ,'prop_naker');

        return $this->hasOne('App\ProvinsiModel', 'id' ,'id_prop');
    }

    // Link ke table ms_provinsi dari field id_prop
    public function provinsibu()
    {
        return $this->hasOne('App\ProvinsiModel', 'id' ,'id_prop');
    }

    // Link ke table ms_kota dari field id_kota
    public function kota()
    {
        return $this->hasOne('App\KotaModel', 'id' ,'id_kota');
    }

    // Link ke table ms_daf_bank dari field id_bank
    public function bank()
    {
        return $this->hasOne('App\BankModel', 'id_bank' ,'id_bank');
    }

    public function user_create()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
    public function user_update()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
