<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use Illuminate\Http\Request;

class ApiController extends Controller
{



    //  05092023 sachin
    public function verifiedcontact(Request $request)
    {
        Contact::where("id",$request->user_id)->update(['contract_verified'=>1]);
        $response = [
            'success' => true,
            'message' => 'Contract Verified Successfully.!',
        ];
        return response()->json($response, 200);
    }


    public function contactmail(Request $request)
    {
        $userId = explode(',',$request->checked_id);
        //  dd(explode(',',$request->checked_id));
        $responseData=[];
        if(count($userId)>0){
            foreach($userId as $contactId){
                $mailcontact = Contact::where("id",$contactId)->first();
                $responseData[] = array(
                'user_id' => $mailcontact->id,
                'name' =>  $mailcontact->name,
                'email' => $mailcontact->email1,
                'ContentText' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                "link"=> asset('/contractpdf/dummypdf.pdf')
             );
             Contact::where("id",$mailcontact->id)->update(['mail_sent'=>1]);

            }
                $response = [
                    'success' => true,
                    'data' => $responseData,
                    'message' => 'mail list!',
                ];
                // dd(response()->json($response, 200));
                return response()->json($response, 200);
        }
    }


    //  05092023 sachin



}
