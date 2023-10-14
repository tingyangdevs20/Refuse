<?php

namespace App;

use App\Model\Tag;
use Illuminate\Database\Eloquent\Model;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadInfo extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lead_tag');
    }
}
