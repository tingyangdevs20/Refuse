<?php

namespace App\Model;

use App\goal_attribute;
use App\User;
use Illuminate\Database\Eloquent\Model;

class GoalsReached extends Model
{
    protected $fillable=['user_id','goals','attribute_id'];

    public function goal_attribute()
    {
        return $this->belongsTo(goal_attribute::class, 'attribute_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
