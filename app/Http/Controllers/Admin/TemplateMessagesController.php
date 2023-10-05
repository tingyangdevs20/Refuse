<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Template;
use App\Model\TemplateMessages;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Facades\View as View;

class TemplateMessagesController extends Controller
{
    public function create(Request $request)
    {
        
        $media = null;
     
        
            if ($request->media_file_mms != null) {
                $media = $request->file('media_file_mms');
                $filename = $media->getClientOriginalName();
                $extension = $media->getClientOriginalExtension();
                $tmpname = 'MMS_'.time() .'.'. $extension;
                $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
                $media = config('app.url') . '/public/uploads/' . $path;
            }
        
        

       // return $media;
        $template = new TemplateMessages();
        $template->template_id = $request->tmpid;
        $template->msg_title = $request->title;
      
        if($request->type == 'SMS'){
            $template->msg_content = $request->body;
       }elseif($request->type == 'MMS'){
            $template->mediaUrl = $media;
            $template->msg_content = $request->mms_body;
       }elseif($request->type == 'Email'){
            $template->subject = $request->subject;
            $template->msg_content = $request->email_body;
       }
        $template->save();
        $id=$request->tmpid;
        
        $templates = Template::where('id',$id)->first();
        $templates->message_count +=1;
        $templates->save();
        Alert::success('Success!', 'Message Created!');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $id=$request->tmpid;
        $templates = Template::where('id',$id)->first();
       $msg_cnt= $templates->message_count;
       if($msg_cnt>=0)
       {
        $templates->message_count -=0;
       }
        $templates->save();
        TemplateMessages::find($request->id)->delete();
       
        Alert::success('Success!', 'Message Deleted');
       
        return redirect()->back();
    }

}

