<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAgreementSeller extends Model
{
    use SoftDeletes;
    protected $table   = "user_agreement_seller";
    public $timestamps = true;

    /**
     * get user agreement
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function userAgreement()
    {
        return $this->belongsTo(UserAgreement::class, 'user_agreement_id', 'id');
    }

    /**
     * get agreement user
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
