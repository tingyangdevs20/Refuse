<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes;
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function leadCategory()
    {
        return $this->belongsTo(LeadCategory::class);
    }
    public function getLeadName()
    {
       return $this->leadCategory()->first()->title;
    }
}
