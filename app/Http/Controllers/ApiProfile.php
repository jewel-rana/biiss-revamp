<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\UserLog;


class ApiProfile extends Controller
{


    public function profileDashboard(Request $request){
        $data = $request->all();
        $resData = ApiOAuth::check();
        if( $resData["status"] == 0 ) {
            $this->arr['status'] = 0;
            $this->arr["message"] = "Invalid token!";
            return Response::json($this->arr);
        }
        $userIn = User::where('id',$resData['user_id'])->first();

        $this->arr['status'] = 1;
        $this->arr['message'] = 'Dashboard!';
        $this->arr["userprofile"] = $userIn;

        return Response::json($this->arr);

    }

    public function submitUpdate(Request $request){
        $data = $request->all();
        $resData = ApiOAuth::check();

        if( $resData["status"] == 0 ) {
            $this->arr['status'] = 0;
            $this->arr["message"] = "Invalid token!";
            return Response::json($this->arr);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'email' => 'required|email|unique:users,email,'.$resData['user_id'],
            'password' => 'required|same:confirm-password'
        ]);

        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {
            $userupdate=User::find($resData['user_id']);
            $userupdate->name =$data['name'];
            $userupdate->password =bcrypt($data['password']);
            $userupdate->save();

            $userInfo = User::where('id',$resData['user_id'])->first();
            $tokenInfo = UserLog::where("user_id", $resData['user_id'])->where("is_loggedin", 1)->first();
            $this->arr['status'] = 1;
            $this->arr['message'] = 'Info Updated!';
            $this->arr["oauth_token"] = $tokenInfo->oauth_token;
            $this->arr["data"] = $userInfo;
            return Response::json($this->arr);

        }
     }





}
