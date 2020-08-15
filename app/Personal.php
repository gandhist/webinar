<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    //
    use SoftDeletes;
    public $table = "personal";
    protected $guarded = ['id'];


}
