<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NarasumberModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_narasumber";
}
