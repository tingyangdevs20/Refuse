<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ScrapingSourceList extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $guarded = [];

    protected $appends = ['formatted_price_range'];

    public function getFormattedPriceRangeAttribute()
    {
        // Split the price range into min and max values
        list($min, $max) = explode('-', $this->attributes['price_range']);

        // Convert min and max to "k" format
        $min = $this->formatNumber($min);
        $max = $this->formatNumber($max);

        return "$min-$max";
    }

    protected function formatNumber($number)
    {
        $number = number_format($number / 1000, 0);

        // Append "k" to the formatted number
        return $number . 'k';
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
