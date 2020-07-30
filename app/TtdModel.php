<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TtdModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_ttd";
    protected $guarded = "id";

}
