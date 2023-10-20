<?php

namespace App\Model;

use App\Model\Tag;
use Illuminate\Database\Eloquent\Model;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadInfo extends Model
{
    protected $table = 'lead_info';
    protected $guarded = [];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lead_tag');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
