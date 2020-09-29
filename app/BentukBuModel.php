<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BentukBuModel extends Model
{
    use SoftDeletes;
    //
    protected $table = 'ms_bentuk_usaha';
}

