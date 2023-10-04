<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Template;
use App\Model\TemplateMessages;
use App\Model\Helpvideo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use \Illuminate\Support\Facades\View as View;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::all();
        $categories = Category::all();
        $sr = 1;
        return view('back.pages.template.index', compact('templates', 'categories', 'sr'));
    }

    public function view($id = '')
    {
        $templates = TemplateMessages::where('template_id',$id)->get();
        $sr = 1;
        return view('back.pages.template.view', compact('templates', 'sr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $media = null;
      //  if($request->type == 'MMS'){
           // if ($request->media_file_mms != null) {
            //    $media = $request->file('media_file_mms');
            //    $filename = $media->getClientOriginalName();
            //    $extension = $media->getClientOriginalExtension();
             //   $tmpname = 'MMS_'.time() .'.'. $extension;
            //    $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
             //   $media = config('app.url') . '/public/uploads/' . $path;
          //  }
      //  }else{
           // if ($request->media_file != null) {
            //    $media = $request->file('media_file');
           //     $filename = $media->getClientOriginalName();
           //     $extension = $media->getClientOriginalExtension();
           //     $tmpname = 'RVM_'.time() .'.'. $extension;
          //      $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
            //    $media = config('app.url') . '/public/uploads/' . $path;
         //   }
        

        //return $media;
        $template = new Template();
        $template->title = $request->title;
        $template->type = $request->type;
       // $template->category_id = $request->category_id;
       // if($request->type == 'SMS'){
            //$template->body = $request->body;
       //}elseif($request->type == 'MMS'){
           // $template->mediaUrl = $media;
          //  $template->body = $request->mms_body;
      //  }elseif($request->type == 'Email'){
          //  $template->subject = $request->subject;
          //  $template->body = $request->email_body;
      //  }elseif($request->type == 'RVM'){
          //  $template->body = $media;
      //  }
        $template->save();
        Alert::success('Success!', 'Template Created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return response($template, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $media = null;
        // if ($request->media_file != null) {
        //     $media = $request->file('media_file');
        //     $filename = $media->getClientOriginalName();
        //     $tmpname = time() . $filename;
        //     $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
        //     $media = config('app.url') . '/uploads/' . $path;
        //     $request->body = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $request->body);
        // }else{
        //     $template = Template::find($request->id);
        //     $media = $template->body;
        // }
      //  if($request->type == 'MMS'){
           // if ($request->media_file_mms != null) {
            //    $media = $request->file('media_file_mms');
             //   $filename = $media->getClientOriginalName();
            //    $extension = $media->getClientOriginalExtension();
             //   $tmpname = 'MMS_'.time() .'.'. $extension;
             //   $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
            //    $media = config('app.url') . '/public/uploads/' . $path;
        //    }else{
             //   $template = Template::find($request->id);
              //  $media = $template->mediaUrl;
          //  }
      //  }else{
            //if ($request->media_file != null) {
              //  $media = $request->file('media_file');
               // $filename = $media->getClientOriginalName();
               // $extension = $media->getClientOriginalExtension();
              //  $tmpname = 'RVM_'.time() .'.'. $extension;
               // $path = $media->storeAs("MMS_Media", $tmpname, "uploads");
               // $media = config('app.url') . '/public/uploads/' . $path;
           // }else{
              //  $template = Template::find($request->id);
              //  $media = $template->body;
          //  }
       // }

        $template = Template::find($request->id);
        $template->title = $request->title;
        $template->type = $request->type;
        //$template->body = $request->body . "\n" . $media;
      //  $template->category_id = $request->category_id;
       // if($request->type == 'SMS'){
         //   $template->body = $request->body;
      //  }elseif($request->type == 'MMS'){
        //    $template->mediaUrl = $media;
         //   $template->body = $request->mms_body;
       // }elseif($request->type == 'Email'){
        //    $template->subject = $request->subject;
         //   $template->body = $request->email_body;
      //  }elseif($request->type == 'RVM'){
        //    $template->body = $media;
      //  }
        $template->save();
        Alert::success('Success!', 'Template Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Template::find($request->id)->delete();
        Alert::success('Success!', 'Template Updated');
        return redirect()->back();
    }

    public function getTemplate($type = ''){
        $templates = Template::where('type',$type)->get();
        return view('back.pages.template.ajaxTemplate', compact('templates'));
    }
    public function getTemplateContent($id = ''){
        $templates = Template::where('id',$id)->get();
        return view('back.pages.campaign.ajaxTemplate', compact('templates'));
    }

    // sneha 04/09/2023

    public function helpvideo_update(Request $request,$id)
    {
        $helpvideoResponses = Helpvideo::find(intval($id));
        $helpvideoResponses->links = $request->input('video_url');
        $helpvideoResponses->update();
       Alert::success('Success','Help Video Updated..');
       return redirect()->back();
    }
    // sneha 04/09/2023

    public function getTemplateWithCondition(Request $request){
        $template_type = (!empty($request->template_type)) ? strtoupper($request->template_type) : '';
        $category = $request->category;
        $count = $request->id;

        $templates = Template::where('type',$template_type)->where('category_id',$category)->first();
        $html = View::make('back.pages.campaign.ajaxTemplate',['templates' => $templates,'count' => $count,'type'=>$request->template_type])->render();
        echo $html;
    }
}
