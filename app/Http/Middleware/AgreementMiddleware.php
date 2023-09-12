<?php

namespace App\Http\Middleware;

use App\Model\UserAgreement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AgreementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = auth()->user()->id;

        $userAgreement = UserAgreement::where("user_id", $userId)
            ->whereNull("sign")
            ->where("is_sign", "!=", "2")
            ->first();

        if (isset($userAgreement)) {
            $agreementKey = Crypt::encrypt($userAgreement->id);
            return redirect("$agreementKey/view");
        }

        return $next($request);
    }
}
