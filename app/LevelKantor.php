<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelKantor extends Model
{
    //
    protected $table = 'ms_level_kantor';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
