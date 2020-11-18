<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelTimProduksi extends Model
{
    //
    protected $table = 'ms_level_tim_produksi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
