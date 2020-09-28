<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PTKPModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "master_ptkp";
}
