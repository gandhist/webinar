<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_ms_status";
    protected $guarded = ['id'];
}
