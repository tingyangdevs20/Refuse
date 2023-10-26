<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FollowupSequences extends Model
{

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function assigner() {
        return $this->belongsTo(User::class, 'assigner_id');
    }
}
