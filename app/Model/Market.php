<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $guarded = [];

    public function numbers()
    {
        return $this->hasMany(Number::class);
    }
    public function availableSends()
    {
        $numbers=$this->numbers()->get();
        $count=0;
        foreach ($numbers as $number) {
            $count=$count+$number->sms_count;
        }
        return $count;
    }
    public function totalSends()
    {
        $numbers=$this->numbers()->get();
        $count=0;
        foreach ($numbers as $number) {
            $count=$count+$number->sms_allowed;
        }
        return $count;
    }
}
