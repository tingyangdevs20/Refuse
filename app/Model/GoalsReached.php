<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoalsReached extends Model
{
    protected $fillable=['user_id','goals'];
}
