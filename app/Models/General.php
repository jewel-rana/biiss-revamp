<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class General extends Model{

    public function gTest(){
        echo "test text";
    }


    //random password
    public function assign_rand_value($num): string
    {

        // accepts 1 - 36
        switch($num) {
            case "1"  : $rand_value = "a"; break;
            case "2"  : $rand_value = "b"; break;
            case "3"  : $rand_value = "c"; break;
            case "4"  : $rand_value = "d"; break;
            case "5"  : $rand_value = "e"; break;
            case "6"  : $rand_value = "f"; break;
            case "7"  : $rand_value = "g"; break;
            case "8"  : $rand_value = "h"; break;
            case "9"  : $rand_value = "i"; break;
            case "10" : $rand_value = "j"; break;
            case "11" : $rand_value = "k"; break;
            case "12" : $rand_value = "l"; break;
            case "13" : $rand_value = "m"; break;
            case "14" : $rand_value = "n"; break;
            case "15" : $rand_value = "o"; break;
            case "16" : $rand_value = "p"; break;
            case "17" : $rand_value = "q"; break;
            case "18" : $rand_value = "r"; break;
            case "19" : $rand_value = "s"; break;
            case "20" : $rand_value = "t"; break;
            case "21" : $rand_value = "u"; break;
            case "22" : $rand_value = "v"; break;
            case "23" : $rand_value = "w"; break;
            case "24" : $rand_value = "x"; break;
            case "25" : $rand_value = "y"; break;
            case "26" : $rand_value = "z"; break;
            case "27" : $rand_value = "0"; break;
            case "28" : $rand_value = "1"; break;
            case "29" : $rand_value = "2"; break;
            case "30" : $rand_value = "3"; break;
            case "31" : $rand_value = "4"; break;
            case "32" : $rand_value = "5"; break;
            case "33" : $rand_value = "6"; break;
            case "34" : $rand_value = "7"; break;
            case "35" : $rand_value = "8"; break;
            case "36" : $rand_value = "9"; break;
        }
        return $rand_value;
    }

    public function get_rand_alphanumeric($length): string
    {
        $rand_id="";
        if ($length>0) {
            for ($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,36);
                $rand_id .= $this->assign_rand_value($num);
            }
        }
        return $rand_id;
    }

    public function get_rand_numbers($length): string
    {
        $rand_id="";
        if ($length>0) {
            for($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(27,36);
                $rand_id .= $this->assign_rand_value($num);
            }
        }
        return $rand_id;
    }

    public function get_rand_letters($length): string
    {
        $rand_id="";
        if ($length>0) {
            for($i=1; $i<=$length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,26);
                $rand_id .= $this->assign_rand_value($num);
            }
        }
        return $rand_id;
    }
    public function randomString($length = 6): string
    {
        $str = "";
        $characters = array_merge(range('a','z'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    //for array
    public function firePushArray($appUser,$pushData): bool|int|string
    {
        $userId = Auth::user()->id;
        $deviceToken = [];
        foreach ($appUser as $user){

                $deviceToken[] = DeviceToken::where('user_id',$user->id)->first();

        }
        $res = 0;
        foreach ($deviceToken as $token){

            $res += $this->sendPushAndroid($token['token'],$pushData);
        }

        return $res;
    }

    //send push
    public function firePush($appUser,$pushData): bool|int|string
    {
        $userId = Auth::user()->id;

        //$token = 'c9to5OOxGW0:APA91bFv2hSaW6pFArphRgnLwiOrFPbrQiMv7Hsm0Ufbf8UnbHaDnM0u0Uk-Kv5eWphLz5HRQc4ghicysav67MQ0gG7dTpFkbPGXLLQ0mgLhKTgi4j2GwqRcxv-ZpajjeaDpU_9SLGq8';
        $appUser = explode(",", $appUser);
        $deviceToken = [];
        foreach ($appUser as $user){
            $deviceToken[] = DeviceToken::where('user_id',$user)->first();
        }

        $res = 0;
        foreach ($deviceToken as $token){

            $res += $this->sendPushAndroid($token['token'],$pushData);
        }

        return $res;
    }

    public function sendPushAndroid($registration_id,$message): bool|string
    {

        $message = $message['title'];
        //$ids[] = 'daYaloiuRMY:APA91bHdlU5AyIHwBC8GW6atZHp8zjUp0OqW18_GO3sK6EZshDiqbijwL_qs9CJkRu7-Xf8tpiCVpdO1oXQDOMrZAh2lihF5pxYwsc-7UV6NY0p876VqEHieBx0v276XN3b-RBXLMSZ4';
        $ids[] = $registration_id;
        //print_r(settype($message,"string"));


        settype($message,"string");

        $message = array( "message" => $message);

        //$message = array('message'=>$message );

        $fields = array(
            'registration_ids' => $ids,
            'data' => $message
        );
        $headers = array(
            'Authorization: key=AIzaSyCMuneQn8TBbWlLMc1b4z1BpU2ui3a1LPw',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporary
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));


        // Execute post
        $res = curl_exec($ch);
        if ($res === FALSE) {
            $res = 'Curl failed: ' . curl_error($ch);
        }

        // Close connection
        curl_close($ch);

        return $res;
    }

    public function sendEmail($email,$password): void
    {

        $content = array(
            'password' => $password,

        );
        Mail::send('update-password', ['title' => 'password update', 'content' => $content], function ($message) use ($email) {
            $message->from('tkanan.swe@gmail.com', 'kanan');

            $message->to($email);
            $message->subject('update password');
        });
    }

    public function emailMe($to,$subject,$message): void
    {




        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        // Additional headers
        $headers[] = 'To: Biman <'.$to.'>';
        //$headers[] = 'From: Birthday Reminder <birthday@example.com>';
        //$headers[] = 'Cc: birthdayarchive@example.com';
        //$headers[] = 'Bcc: birthdaycheck@example.com';

        // Mail it
        mail($to, $subject, $message, implode("\r\n", $headers));
    }


}
