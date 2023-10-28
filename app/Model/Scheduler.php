<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Scheduler extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $table = 'scheduler'; // table name
    protected $guarded = [];
    // protected $fillable = [

    //     'name',
    //     'email',
    //     'mobile',
    //     'appt_date',
    //     'appt_time',
    //     'timezone',
    //     'description',
    //     'status',
    //     'created_on',
    //     'updated_on',
    // ];
}
