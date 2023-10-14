<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function getLeadCategory()
    {
        $sms = Sms::where('client_number', $this->number)->first();
        if ($sms == null) {
            $leadCategory = "Not Contacted Yet";
        } else {
            $leadCategory = $sms->getLeadName();
        }

        return $leadCategory;
    }
    
}
