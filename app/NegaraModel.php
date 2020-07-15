<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NegaraModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_negara";
}
