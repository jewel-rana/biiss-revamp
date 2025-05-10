<?php

namespace App\Http\Controllers;

use App\Employee;
use App\General;
use Illuminate\Http\Request;
use App\User;
use App\UserLog;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\DeviceToken;


class ApiLoginController extends Controller
{


    public function login(Request $request){
        $data = $request->all();


        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 'password' => 'required'
        ]);

        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {

            $user = User::where('email',$data['email'])->first();


            if(count($user)>0){



                if (Hash::check($data['password'], $user->password)) {


                    $isExists = UserLog::where("user_id", $user->id)->where("is_loggedin", 1)->first();

                    $profileInfo = Employee::where('user_id',$user->id)->first();



                    $host = env('HOST');

                    if($profileInfo->avatar != null){
                        $avatar = $host."/uploads/profile/".$profileInfo->avatar;
                    }else {
                        $avatar = '';
                    }





                    if(count($isExists)>0){
                        $this->arr["status"] = 1;
                        $this->arr["message"] = "You are already logged in.";
                        $this->arr["oauth_token"] = $isExists->oauth_token;
                        $this->arr["avatar"] = $avatar;
                        $this->arr["profile"] = $profileInfo;
                        return Response::json($this->arr);
                    } else {


                        // Generate oAuth Token
                        $oauth_token=$user->id . time() . $_SERVER["REMOTE_ADDR"];

                        $oauth_token=base64_encode(md5($oauth_token));



                        // Add Token
                        $userLog = new UserLog();
                        $userLog->oauth_token=$oauth_token;
                        $userLog->user_id=$user->id;
                        $userLog->login_date=date("Y-m-d H:i:s");
                        $userLog->is_loggedin=1;
                       





                        if ($userLog->save()) {
                            $this->arr["status"] = 1;
                            $this->arr["message"] = "login success.";
                            $this->arr["oauth_token"] = $oauth_token;
                            $this->arr["avatar"] = $avatar;
                            $this->arr["profile"] = $profileInfo;
                            return Response::json($this->arr);
                        } else {
                            $this->arr["status"] = 1;
                            $this->arr["message"] = "Something went wrong. Please try again !";
                            return Response::json($this->arr);
                        }
                    }
                }else{
                    $this->arr['status'] = 0;
                    $this->arr['message'] = 'worng password!';
                    return Response::json($this->arr);
                }

            } else {
                $this->arr['status'] = 0;
                $this->arr['message'] = 'user not found!';
                return Response::json($this->arr);
            }

        }

    }



    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);

        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);

            $user = new User();
            $user->name=$data['name'];
            $user->email=$data['email'];
            $user->password=Hash::make($data['password']);
            if($user->save()){
                $this->arr['status'] = 1;
                $this->arr['message'] = "You are registered now ! login please";
                $this->arr["data"] = $user;
                return Response::json($this->arr);
            }else{
                $this->arr['status'] = 0;
                $this->arr['message'] = 'Something Wrong';
                return Response::json($this->arr);
            }


        }


    }


    public function logout(Request $request){

        $data = $request->input();


        $validator = Validator::make($request->all(), [
            'oauth_token' => 'required',
        ]);

        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {

            $isUserLogEx = UserLog::where('oauth_token', $data['oauth_token'])->where('is_loggedin',1)->first();


            if(count($isUserLogEx)>0){

                UserLog::where('oauth_token', $data['oauth_token'])->update(['is_loggedin' => 0]);
                //UserLog::where('oauth_token', $data['oauth_token'])->delete();

                $this->arr['status'] = 1;
                $this->arr['message'] = "you are Sucessfully logout!";

                return Response::json($this->arr);

            } else {

                $this->arr['status'] = 0;
                $this->arr['message'] = 'token not found try again!';
                return Response::json($this->arr);
            }


        }
    }


    public function forgotPassword(Request $request){


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails())
        {
            $error =  $validator->errors()->all();
            $this->arr['status'] = 0;
            $this->arr['message'] = $error;
            return Response::json($this->arr);
        } else {
            $eEmail = new General();
            $tempPassword = $eEmail->get_rand_numbers(6);

            $email = $data['email'];
            $subject = 'Pk71japan temp password';
            $to = $email;
            $message = ' Your temp password is : '.$tempPassword;
            $userInfo = User::where('email',$email)->first();
            if(count($userInfo)>0){
                $result = $eEmail->emailMe($to,$subject,$message);
                $update = User::where('id',$userInfo->id)->update(['password' => bcrypt($tempPassword)]);
                $this->arr['status'] = 1;
                $this->arr['message'] = 'please check your email';
                return Response::json($this->arr);
            }else{
                $this->arr['status'] = 0;
                $this->arr['message'] = 'This user not available!';
                return Response::json($this->arr);
            }
        }
    }



    public function submitDeviceToken(Request $request){


        $data = $request->input();

        $resData = ApiOAuth::check();

        if( $resData["status"] == 0 ) {
            $this->arr['status'] = 0;
            $this->arr["message"] = "Invalid token!";
            return Response::json($this->arr);
        }


        $isExist = DeviceToken::where('user_id',$resData['user_id'])->first();

        if(count($isExist)>0){

            $info = DeviceToken::where('id',$isExist->id)->update(['token' => $data['device_token'],'type' => $data['type']]);

            if($info){
                $this->arr['status'] = 1;
                $this->arr["message"] = "Device token Updated!";
                return Response::json($this->arr);
            }

        } else {
            $deviceToken = new DeviceToken();
            $deviceToken->user_id = $resData['user_id'];
            $deviceToken->type = $data['type'];
            $deviceToken->token = $data['device_token'];
            $saved = $deviceToken->save();
            if($saved){
                $this->arr['status'] = 1;
                $this->arr["message"] = "Device token submitted!";
                return Response::json($this->arr);
            } else {
                $this->arr['status'] = 0;
                $this->arr["message"] = "Device token not submitted!";
                return Response::json($this->arr);
            }
        }

    }





}