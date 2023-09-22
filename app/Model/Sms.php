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


    public static function scopegetCountForLastDays($query,$days=null){
        if($days){
            $days = $days - 1;
            $endDate = today();
            $startDate = $endDate->copy()->subDays($days);
            $query->where('created_at','>=',$startDate)->where('created_at','<=',$endDate);
        }
        return $query->where('is_received',1)->whereHas('replies',function($query){
            $query->where('type','SMS');
        })->withTrashed()->count();
    }

}
