<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Model\Contact;
use RealRashid\SweetAlert\Facades\Alert;

class SendGridEmailController extends Controller
{
    public function sendMail()
    {
         $data = ['message' => 'This is a test!','subject' => 'This is a subject!', 'name' =>'umer!'];
       // $data = ['message' => 'This is a test!'];
        
        Mail::to('jagjit.mcs@gmail.com')->send(new TestEmail($data));
    }
    
    public function unsubMail($email = '')
    {
        $contacts = Contact::where('email1' , $email)->first();
        if($contacts){
            Contact::where('email1' , $email)->update(['is_email' => 0]);
        }else{
            $contacts2 = Contact::where('email2' , $email)->first();
            if($contacts2){
                Contact::where('email2' , $email)->update(['is_email' => 0]);
            }
        }
        return redirect()->route('login')->with('success', 'Campaign created successfully.');
    }
}