<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\TimeZones;
class ZoomMeeting extends Model
{
    protected $guarded = [];

    public function timezones(){
        return $this->belongsTo(TimeZones::class,"meeting_date_timezone","id");
    }
}

?>