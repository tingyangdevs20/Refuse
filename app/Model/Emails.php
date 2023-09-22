<?php

namespace App\Model;

use App\EmailReply;
use App\Model\Contact;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    public function replies()
    {
        return $this->hasMany(EmailReply::class, 'email_id', 'id');
    }

    public function contact()
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }

    public static function scopegetCountForLastDays($query,$days=null){
        if($days){
            $days = $days - 1;
            $endDate = today();
            $startDate = $endDate->copy()->subDays($days);
            $query->where('created_at','>=',$startDate)->where('created_at','<=',$endDate);
        }
        return $query->whereHas('replies')->where('is_received',1)->count();
    }
}
