<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // anak dajjal lupa soft delete

class FeedbackRatingModel extends Model
{
    use SoftDeletes;
    //
    protected $table = "feedback_rating";
}
