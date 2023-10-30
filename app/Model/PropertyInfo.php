<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyInfo extends Model
{
    protected $table = 'property_infos';
    protected $guarded = [];


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
