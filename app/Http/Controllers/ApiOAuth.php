<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserLog;

class ApiOAuth extends Controller
{
    public static function check() {

        $res = array();
        $res["status"] = 0;
        if( !isset( $_SERVER["HTTP_AUTHORIZATION"] ) ) {
            return $res;
        }
        if( strlen( $_SERVER["HTTP_AUTHORIZATION"] ) < 7 ) {
            return $res;
        }
        $oauth_token = strip_tags($_SERVER["HTTP_AUTHORIZATION"]);

        //$oauth_token = substr($oauth_token, 7);

        $data = UserLog::where("is_loggedin",1)->where("oauth_token",$oauth_token)->first();
        if(count($data)>0) {
            $res["status"] = 1;
            $res["id"] = $data->id;
            $res["user_id"] = $data->user_id;
        }
        return $res;
    }
}
