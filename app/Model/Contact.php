<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Contact extends Model implements HasMedia
{
    use HasMediaTrait;
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

    // In the Contact model
    public function leadInfo()
    {
        return $this->hasOne(LeadInfo::class);
    }

    // In the Contact model
    public function propertyInfo()
    {
        return $this->hasOne(PropertyInfo::class);
    }

}
