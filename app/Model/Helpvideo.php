<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Helpvideo extends Model
{
    protected $guard_name = 'help_video';
    public $table = 'help_video';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'links',
        ];

  
}
