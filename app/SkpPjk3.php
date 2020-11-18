<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SkpPjk3 extends Model
{
    //
    use SoftDeletes;
    protected $table = "skp_pjk3";
    protected $guarded = ["id"];

    // relasi ke master bidang
    public function bidang(){
        return $this->belongsTo('App\BidangModel','bid_sk');
    }

    // relasi ke master badan usaha
    public function badan_usaha(){
        return $this->belongsTo('App\BuModel','kode_pjk3','id');
    }

    // relasi ke personil
    public function bank_r(){
        return $this->belongsTo('App\BankModel','id_bank','id_bank');
    }

    // relasi ke username verify 1
    public function user_verify1(){
        return $this->belongsTo('App\User','verified_1_by');
    }

    // relasi ke username verify 1
    public function user_verify2(){
        return $this->belongsTo('App\User','verified_2_by');
    }

    // relasi ke username verify 1
    public function user_ok(){
        return $this->belongsTo('App\User','ok_by');
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
