<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusBUModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_status_comp";
}
