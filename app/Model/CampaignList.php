<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CampaignList extends Model
{
    protected $fillable = ['campaign_id', 'type', 'send_after_days', 'send_after_hours', 'schedule','body','subject','mediaUrl','template_id'];
    
    protected $casts = [
        'schedule' => 'datetime',
        //'group_id' => 'integer',
    ];
    public function campaignslist()
    {
        return $this->hasMany(CampaignList::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public static function getAllCampaigns()
    {
        $campaignslist = self::all();

        if ($campaignslist->isEmpty()) {

            return collect(); // Return an empty collection if data is not available
        }

        return $campaignslist;
    }

    // Define any other relationships, accessors, mutators, or custom methods as needed
}
