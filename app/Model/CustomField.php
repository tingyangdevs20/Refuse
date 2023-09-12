<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = ['feild_id', 'session_id','contact_id','feild_value'];
    protected $guarded=[];

}
