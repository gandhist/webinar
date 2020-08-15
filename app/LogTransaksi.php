<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogTransaksi extends Model
{
    //
    use SoftDeletes;
    protected $table = "srtf_log_transaksi";
}
