<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RvmFile extends Model
{
    protected $fillable = ['name', 'mediaUrl'];
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
