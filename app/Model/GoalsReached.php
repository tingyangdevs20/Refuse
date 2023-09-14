<?php

namespace App\Model;
use App\goal_attribute;

use Illuminate\Database\Eloquent\Model;

class GoalsReached extends Model
{
    protected $fillable=['user_id','goals'];

    public function goal_attribute()
    {
        return $this->belongsTo(goal_attribute::class);
    }
}
