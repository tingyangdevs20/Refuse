<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAgreement extends Model
{
    use SoftDeletes;
    protected $table   = "user_agreements";
    public $timestamps = true;

    /**
     * get agreement user
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function userAgreementSeller()
    {
        return $this->belongsTo(userAgreementSeller::class, 'user_agreement_id', 'id');
    }

    /**
     * get pdf path attribute
     *
     * @param string $value
     * @return void
     * @author Bhavesh Vyas
     */
    public function getPdfPathAttribute($value)
    {
        if (!empty($value) && $value != null) {
            return public_path("storage/agreement_pdf/" . $value);
        }
    }
}
