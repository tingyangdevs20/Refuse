<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded=[];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getCategoryName()
    {
        return $this->category->name;
    }
}
