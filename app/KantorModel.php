<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KantorModel extends Model
{
    use SoftDeletes;
    protected $table = "kantor";
    protected $guarded = ['id'];
}
