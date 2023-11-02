<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ScrapingSourceList extends Model implements HasMedia
{
    use HasMediaTrait, SoftDeletes;
    protected $guarded = [];

    protected $appends = ['formatted_price_range'];

    public function getFormattedPriceRangeAttribute()
    {
        if ($this->attributes['price_range'] == '18000000-Any Price') {
            return $this->attributes['price_range'];
        }
        $parts = explode('-', $this->attributes['price_range']);
        $start = $parts[0];
        $end = $parts[1];

        if ($start >= 1000000) {
            $start = '$' . number_format($start / 1000000, 1) . 'M';
        } elseif ($start >= 1000) {
            $start = '$' . number_format($start / 1000, 1) . 'K';
        } else {
            $start = '$' . number_format($start);
        }

        if ($end >= 1000000) {
            $end = '$' . number_format($end / 1000000, 1) . 'M';
        } elseif ($end >= 1000) {
            $end = '$' . number_format($end / 1000, 1) . 'K';
        } else {
            $end = '$' . number_format($end);
        }

        return $start . '-'. $end;
    }


    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('scraping_requests')
            ->singleFile(); // To ensure only one file is stored in this collection

            $this->addMediaCollection('scraping_uploads')
            ->singleFile(); // To ensure only one file is stored in this collection
    }
}
