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
           
      //  $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      //  @dd($uriSegments);
      // $lastUriSegment = array_pop($uriSegments);
      // $data = DB::table('help_video')->select('id','links')->where('name',$lastUriSegment)->first();

      

      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      $lastUriSegment = array_pop($uriSegments);

      $data = DB::table('help_video')->select('id', 'links')
         ->where('name', $lastUriSegment)
         ->first();

         if (empty($data)) {
            // @dd($data->link);
            // $data is empty, so run the insert query with a dummy URL
            $dummyUrl = 'http://example.com/dummy-url'; // Replace with your desired dummy URL
            DB::table('help_video')->insert([
               'name' => $lastUriSegment,
               'links' => $dummyUrl,
            ]);

            $data = DB::table('help_video')->select('id', 'links')
            ->where('name', $lastUriSegment)
            ->first();
         
}
       
   
if($data){
   return $data;
}else{
   return '';
}





    }




?>