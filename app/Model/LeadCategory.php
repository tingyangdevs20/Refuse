<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LeadCategory extends Model
{
    protected $guarded = [];

    public function smses()
    {
        return $this->hasMany(Sms::class);
    }
    public function getLeadCount()
    {
        return $this->smses()->count();
    }
}
