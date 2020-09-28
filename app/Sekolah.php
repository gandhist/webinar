<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    //
    use SoftDeletes;
    protected $table = "daf_sekolah";
}
