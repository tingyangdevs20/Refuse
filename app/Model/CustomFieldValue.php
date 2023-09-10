<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $fillable = ['section_id', 'section_id','field','label'];
    protected $guarded=[];

}
