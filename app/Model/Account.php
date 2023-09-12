<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    public function numbers()
    {
        return $this->hasMany(Number::class);
    }
    public function getMarketName(){
        return $this->market->name;
    }
    public function getNumbersCount(){
        return $this->numbers->count();
    }
}
