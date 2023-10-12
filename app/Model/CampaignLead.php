<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CampaignLead extends Model
{
    protected $fillable = ['name', 'type', 'send_after_days', 'send_after_hours', 'schedule', 'group_id','template_id', 'active'];
    
    protected $casts = [
        'schedule' => 'datetime',
        'group_id' => 'integer',
    ];
    public function campaigns()
    {
        return $this->hasMany(CampaignList::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    


    public static function getAllLeadsCampaign()
    {
        $leadcampaigns = self::all();

        if ($leadcampaigns->isEmpty()) {

            return collect(); // Return an empty collection if data is not available
        }

        return $leadcampaigns;
    }

    // Define any other relationships, accessors, mutators, or custom methods as needed
}
