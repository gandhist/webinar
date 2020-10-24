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

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}
