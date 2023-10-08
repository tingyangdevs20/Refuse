<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskLists extends Model
{
    protected $guarded = [];
    protected $table = "tasklists";

  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
