<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TUKModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_tuk";
}
