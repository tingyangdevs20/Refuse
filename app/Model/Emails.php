<?php

namespace App\Model;

use App\EmailReply;
use App\Model\Contact;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    public function replies()
    {
        return $this->hasMany(EmailReply::class, 'email_id', 'id');
    }

    public function contact()
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }
}
