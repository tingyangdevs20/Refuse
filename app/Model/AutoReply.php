<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AutoReply extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
