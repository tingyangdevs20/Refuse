<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingSpend extends Model
{
    protected $fillable = ['lead_source', 'user_id', 'daterange', 'amount'];
    // Belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
