<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded=[];
    public function templates()
    {
        return $this->hasMany(Template::class);
    }
    public function templateCount()
    {
        return $this->templates()->count();
    }
    public function autoreply()
    {
        return $this->hasOne(Autoreply::class);
    }
}
