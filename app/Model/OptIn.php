<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OptIn extends Model
{
    protected $table ='opt_in';


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
