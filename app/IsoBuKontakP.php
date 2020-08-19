<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class IsoBuKontakP extends Model
{
    //
    use SoftDeletes;
    protected $table = "iso_bu_kontak_p";
}
