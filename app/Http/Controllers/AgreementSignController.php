<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\UserAgreementSendMail;
use App\Model\UserAgreement;
use App\Model\UserAgreementSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AgreementSignController extends Controller
{
    public $viewPath;

    /**
     * Create a new controller instance.
     *
     * @author Bhavesh Vyas
     */
    public function __construct()
    {
        $this->viewPath = "agreement.";
    }

    /**
     * generate User Agreement
     *
     * @param Request $request
     * @return void
     * @author Bhavesh Vyas
     */
    public function sampleAgreement(Request $request)
    {
        $content = "This is same user agreement for all users.";
        $content .= "<p>Bhavesh Vyas</p>";
        $content .= "<p>{SIGNATURE_1}</p>";
        $content .= "<p>{signature_date}</p>";

        $userAgreement                             = new UserAgreement();
        $userAgreement->template_id                = "1";
        $userAgreement->agreement_date             = date("Y-m-d");
        $userAgreement->content                    = $content;
        $userAgreement->agreement_template_content = $content;
        $userAgreement->admin_id                   = "1";
        $userAgreement->created_at                 = date("Y-m-d H:i:s");
        $userAgreement->updated_at                 = date("Y-m-d H:i:s");
        $userAgreement->save();

        $userAgreementSeller                    = new UserAgreementSeller();
        $userAgreementSeller->user_agreement_id = $userAgreement->id;
        $userAgreementSeller->user_id           = "1";
        $userAgreementSeller->signature_key     = "{SIGNATURE_1}";
        $userAgreementSeller->is_send_mail      = "1";
        $userAgreementSeller->save();

        $userEmail     = "bhaveshvyas23@gmail.com";
        $userAgreement = UserAgreement::find(1);

        $url      = route("user.agreement.view", Crypt::encrypt($userAgreementSeller->id));
        $userName = ucfirst($userAgreement->user_name);

        return view('agreement.send', compact('url', 'userName'));
        Mail::to($userEmail)->send(new UserAgreementSendMail($userAgreement));
    }

    /**
     * View User Agreement
     *
     * @param Request $request
     * @param string $agreementKey
     * @return void
     * @author Bhavesh Vyas
     */
    public function view(Request $request, string $agreementKey)
    {
        $agreementId = Crypt::decrypt($agreementKey);

        $userAgreementSeller = UserAgreementSeller::find($agreementId);

        if (!$userAgreementSeller) {
            return redirect()->route('login');
        }

        $userAgreement = $userAgreementSeller->userAgreement;

        if ($userAgreementSeller->sign != "" && $userAgreement->pdf_path != "") {
            $headers = [
                'Content-Type: application/pdf',
            ];
            return response()->file($userAgreement->pdf_path, $headers);
        }

        $content = stripslashes($userAgreement->content);

        return view($this->viewPath . "view", compact('content', 'agreementKey', 'userAgreement'));
    }

    /**
     * User Agreement PDF Download
     *
     * @param Request $request
     * @param string $agreementKey
     * @return void
     * @author Bhavesh Vyas
     */
    public function pdf(Request $request, string $agreementKey)
    {
        View::share('mainBread', trans('message.contract'));

        $agreementId = Crypt::decrypt($agreementKey);

        $userAgreementSeller = UserAgreementSeller::find($agreementId);

        if (!$userAgreementSeller) {
            return redirect()->route('login');
        }

        $userAgreement = $userAgreementSeller->userAgreement;

        if ($userAgreement && $userAgreement->sign != "" && $userAgreementSeller->is_sign == "2" && $userAgreement->pdf_path != "") {
            $headers = [
                'Content-Type: application/pdf',
            ];
            return response()->file($userAgreement->pdf_path, $headers);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * User Agreement Sign Contract Save
     *
     * @param Request $request
     * @return void
     * @author Bhavesh Vyas
     */
    public function signAgreement(Request $request)
    {
        $rules = [
            'image' => ["required"],
            'key'   => ["required"],
        ];

        $messages = [
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ];
            return response()->json($response, 400);
        }

        $agreementId = Crypt::decrypt($request->key);

        $userAgreementSeller = UserAgreementSeller::find($agreementId);
        $signatureKey        = $userAgreementSeller->signature_key;

        $userAgreement = $userAgreementSeller->userAgreement;

        $replace = addslashes("<img src='" . $request->image . "' height='100px' width='100px'/>");

        $userAgreementContent   = str_replace("$signatureKey", $replace, $userAgreement->content);
        $userAgreement->content = $userAgreementContent;
        $userAgreement->save();

        $userAgreementSeller->sign                = $request->image;
        $userAgreementSeller->user_ip             = getIPAddress();
        $userAgreementSeller->agreement_sign_date = date("Y-m-d");
        $userAgreementSeller->is_sign             = "2";
        $userAgreementSeller->save();

        $userAgreementSeller          = UserAgreementSeller::where("user_agreement_id", $userAgreement->id)->count();
        $userAgreementSellerSignCount = UserAgreementSeller::where("user_agreement_id", $userAgreement->id)->where("is_sign", "2")->count();

        if ($userAgreementSeller == $userAgreementSellerSignCount) {
            $userAgreement->is_sign = "2";
            $userAgreement->save();
            runCURL(url("api/agreement/pdf"));
        }

        $response = [
            'success' => true,
            'message' => "Agreement Sign Successfully",
        ];

        return response()->json($response, 200);
    }
}
