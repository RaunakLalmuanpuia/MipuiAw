<?php

use App\Models\DeletedUser;
use App\Models\Grievance;
use App\Models\GrievanceMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

if(!function_exists('thangteaSMS')){
    function thangteaSMS($phone,$message,$templateId,$otp=false){
        if(is_array($phone)){
            $mPhones=implode(",",$phone);
        }else{
            $mPhones=$phone;
        }

        
         if($otp){

            $response = Http::withHeaders([
                'Authorization' => "Bearer 162|" . env('SMS_TOKEN'),
             ])->get("https://sms.msegs.in/api/send-otp",[
                'template_id' => $templateId,
                'message' => $message,
                'recipient'=>$mPhones
             ]);
         }else{

                $response = Http::withHeaders([
                    'Authorization' => "Bearer 162|" . env('SMS_TOKEN'),
                 ])->get("https://sms.msegs.in/api/send-sms",[
                    'template_id' => $templateId,
                    'message' => $message,
                    'recipient'=>$mPhones
                 ]);            
         
         
            }
        return $response;
    }
}

if(!function_exists('email')){
    function email($name, $email, $details, $subject){
        $data = array("body" => "New Grievance :".$details.". Please visit https://mipuiaw.in to response");

        Mail::send('emails.mail', $data, function($message) use ($name,$email,$subject)
        {
            $message->to($email,$name)
                    ->subject($subject);
            $message->from('grievance@mipuiaw.com','Mipui Aw');
        });
    }
}


if(!function_exists('createUserBackUpBeforeDelete')){
    function createUserBackUpBeforeDelete( $userId){
         
            $user = User::find($userId);

            Grievance::where('user_id', $userId)
                            ->update(['user_id' => null]);
            
            GrievanceMovement::where('from_type','App\Models\User')->where('from_id',$userId)
                    ->update(['from_id' => null]);
            GrievanceMovement::where('to_type','App\Models\User')->where('to_id',$userId)
                    ->update(['to_id' => null]);

            $deletedUserBackUp = new DeletedUser();
            $deletedUserBackUp->department_id = $user->department_id;
            $deletedUserBackUp->sub_department_id = $user->sub_department_id;
            $deletedUserBackUp->role_id = $user->role_id;
            $deletedUserBackUp->name = $user->name;
            $deletedUserBackUp->email = $user->email;
            $deletedUserBackUp->password = $user->password;
            $deletedUserBackUp->mobile = $user->mobile;
            $deletedUserBackUp->gender = $user->gender;
            $deletedUserBackUp->designation = $user->designation;
            $deletedUserBackUp->address = $user->address;
            $deletedUserBackUp->pincode = $user->pincode;
            $deletedUserBackUp->alternate_mobile = $user->alternate_mobile??'';
            $deletedUserBackUp->district = $user->district;
            $deletedUserBackUp->notification = $user->notification;
            $deletedUserBackUp->active = $user->active;
            $deletedUserBackUp->last_login = $user->last_login;
            $deletedUserBackUp->save();
            
            $user->delete();
    }
}

if(!function_exists('testy')){
    function testy(){
        return "change now";
    }
}
