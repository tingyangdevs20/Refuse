<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
>>>>>>> fc47628412f3cfa6e39cd3693d49fe73f9f84771

class ScrapingSourceList extends Model
{
<<<<<<< HEAD
=======
    use HasMediaTrait, SoftDeletes;
>>>>>>> fc47628412f3cfa6e39cd3693d49fe73f9f84771
    protected $guarded = [];
}
