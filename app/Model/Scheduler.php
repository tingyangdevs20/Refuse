<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
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
