<?php
   //use DB;
   use DB as DBS;


    function systemMsg(){
       $systemsg = DB::table('system_messages')->select('message')->get();
       if(!empty($systemsg)){
       foreach($systemsg as $value){
        $data = $value->message;
       }
       return $data; }
    }

    function helpvideolink(){

      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      $lastUriSegment = array_pop($uriSegments);
      $data = DB::table('help_video')->select('id','links')->where('name',$lastUriSegment)->first();
      if($data){
          return $data;
      }else{
          return '';
      }
       
   }
   










?>