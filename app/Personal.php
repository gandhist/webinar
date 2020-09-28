<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    //
    use SoftDeletes;
    public $table = "personal";
    protected $guarded = ['id'];

    public function kota()
    {
        return $this->hasOne('App\KotaModel', 'id','kota_id');
    }
    public function bank()
    {
        return $this->belongsTo('App\BankModel', 'id_bank' ,'id_bank');
    }
    public function tempLahir()
    {
        return $this->belongsTo('App\KotaModel', 'temp_lahir' );
    }

}
