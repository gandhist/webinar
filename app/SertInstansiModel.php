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

}
