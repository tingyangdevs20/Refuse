<?php

namespace App;

use App\Model\Tag;
use Illuminate\Database\Eloquent\Model;

class LeadInfo extends Model
{
    protected $guarded = [];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lead_tag');
    }
}
