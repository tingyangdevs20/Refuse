<?php 
namespace App\Classes;
use Session;
use Redirect;
// use Illuminate\Http\Request;
use Request;
use App\Model\Template;
use Cookie;
use URL;
use DB;
use App\CommonModel;
use App\Model\User;
use File;

class CommonLibrary {
    
    public static function getBody($template_id = ''){
        $template = Template::where('id' , $template_id)->first();
        if($template){
            return $template;
        }else{
            return '';
        }
    }
}

?>