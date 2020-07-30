<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_penyelenggara";
    protected $guarded = "id";

}
