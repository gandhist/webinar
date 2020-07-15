<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstansiModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "instansi";
    protected $guarded = "id";
}
