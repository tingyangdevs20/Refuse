<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'group_tags', 'group_id', 'tag_id');
    }

    public function getContactsCount()
    {
        return $this->contacts()->count();
    }
    public function getMessageSentCount()
    {
        return $this->contacts()->where("msg_sent",1)->count();
    }
    public function getMessageNotSentCount()
    {
        return $this->contacts()->where("msg_sent",0)->count();
    }
    public function getMailSentCount()
    {
        return $this->contacts()->where("mail_sent",1)->count();
    }
    public function getVerifiedSentCount()
    {
        return $this->contacts()->where("contract_verified",1)->count();
    }
    public function getContactCountByEmailId($email,$email2,$number,$number2,$number3)
    {
        $query = Contact::where("email1",$email);
        if($email2!=null && $email2!=''){$query->orWhere("email2",$email2);}
        if($number!=null && $number!='' && strlen($number)>3){$query->orWhere('number', '=', $number);}
        if($number2!=null && $number2!='' && strlen($number2)>3){$query->orWhere('number2', '=', $number2);}
        if($number3!=null && $number3!='' && strlen($number3)>3){$query->orWhere('number3', '=', $number3);}
            return  $query->distinct('id')->count('id');
    }

    public function getContactTagsCount($contact_id)
    {
        $selected_tags_count = 0;
        $leadinfo = DB::table('lead_info')->where('contact_id', $contact_id)->first();
        if ($leadinfo) {
            $selected_tags_count = DB::table('lead_info_tags')->where('lead_info_id', $leadinfo->id)->pluck('tag_id')->count();
        }
        return $selected_tags_count;
    }
}
