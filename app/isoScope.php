<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class isoScope extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_scope";
}
