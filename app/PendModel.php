<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_pendukung";
    protected $guarded = "id";

}
