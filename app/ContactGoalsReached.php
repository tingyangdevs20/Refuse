<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactGoalsReached extends Model
{
    protected $table = 'contact_goals_reacheds';

    protected $fillable = ['user_id', 'goals', 'attribute_id', 'lead_type', 'contact_id', 'recorded_at'];

    public function goal_attribute()
    {
        return $this->belongsTo(GoalAttribute::class, 'attribute_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
