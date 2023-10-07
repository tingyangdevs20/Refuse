<?php

namespace App\Model;

use App\LeadInfo;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded=[];
 
    public function leadInfos()
    {
        return $this->belongsToMany(LeadInfo::class, 'lead_tag');   
    }
}
