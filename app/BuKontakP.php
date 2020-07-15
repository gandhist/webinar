<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuKontakP extends Model
{
    //
    use SoftDeletes;
    protected $table = "bu_kontak_p";
}
