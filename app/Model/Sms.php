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
        $lead = $this->leadCategory()->first();
        
        // Check if lead exists
        if ($lead) {
            # code...
            return $lead->title;
        } 

        return null;
    }
}
