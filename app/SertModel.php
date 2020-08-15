<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "sertifikat";
}
