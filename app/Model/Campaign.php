<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
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

    public static function getAllCampaigns()
    {
        $campaigns = self::all();

        if ($campaigns->isEmpty()) {

            return collect(); // Return an empty collection if data is not available
        }

        return $campaigns;
    }

    public static function scopegetCountForLastDays($query,$days=null){
        if($days){
            $days = $days - 1;
            $endDate = today();
            $startDate = $endDate->copy()->subDays($days);
            $query->where('created_at','>=',$startDate)->where('created_at','<=',$endDate);
        }
        return $query->count();
    }
    // Define any other relationships, accessors, mutators, or custom methods as needed
}
