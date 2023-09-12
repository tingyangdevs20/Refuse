<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $guarded=[];
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function market()
    {
        return $this->belongsTo(Market::class);
    }
    public function accountInfo()
    {
        return $this->account()->first();
    }
    public function accountid()
    {
        return $this->account()->first()->account_id;
    }
    public function accountToken()
    {
        return $this->account()->first()->account_token;
    }
}
