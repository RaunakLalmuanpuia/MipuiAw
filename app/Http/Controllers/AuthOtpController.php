<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AuthOtpController extends Controller
{

    private $DOMAIN_NAME;
    
    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    //OTP TIME OUT 5 MINUTE
    public function generateOtp(Request $request){
        //DELETE ALL THE EXPIRED OTP
        VerificationCode::where('expire_at','<',Carbon::now())->delete();
          
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => 'required|min:4|confirmed',
            'address' => ['required'],
            'district' => 'required',
            'gender' => 'required',
            'mobile' => 'required|numeric|digits:10'
        ]);
         
        $OTP = rand(123456,999999);
        
        $verification = VerificationCode::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => ($request->password),

            'address'=>$request->address,
            'district'=>$request->district,
            'gender'=>$request->gender,
            'mobile'=>$request->mobile,
            'role_id'=>5, //ROLE ID 5 = CITIZEN|FROM THIS ONLY CITIZEN WILL REGISTER

            'otp'=> $OTP,
            'expire_at' => Carbon::now()->addMinutes(5),
        ]);
        //Otp (16)
        //{#var#} atâna OTP chu {#var#} a ni e. EGOV-MZ
        $templateID = "1407170608246834529";
        
        $message = "MIPUI-AW atâna OTP chu ".$OTP ." a ni e. EGOV-MZ";
        // $templateID = "1407165911820847483";
        // $message = "OTP for MIPUI-AW is ".$OTP .". -MSeGS";
        thangteaSMS($request->mobile,$message,$templateID,true);

        $mailDetails = $OTP ." is your OTP for MIPUI-AW";
        email($request->name, $request->email, $mailDetails,$mailDetails );

        return Inertia::render('Guest/OTPPage',[
            'verification_id'=> $verification->id,
        ]);

    }

    public function resentOtp($verificationId){
        $verification = VerificationCode::find($verificationId);
        $OTP = rand(123456,999999);
         //Otp (16)
        //{#var#} atâna OTP chu {#var#} a ni e. EGOV-MZ
        $templateID = "1407170608246834529";
        $message = "MIPUI-AW atâna OTP chu ".$OTP ." a ni e. EGOV-MZ";
        
        // $templateID = "1407165911820847483";
        // $message = "OTP for MIPUI-AW is ".$OTP .". -MSeGS";
        thangteaSMS($verification->mobile,$message,$templateID,true);
        
        $mailDetails = $OTP ." is your OTP for MIPUI-AW";
        email($verification->name, $verification->email, $mailDetails,$mailDetails );
        
        $verification->otp = $OTP;
        $verification->expire_at =Carbon::now()->addMinutes(5);
        $verification->save();

        return Inertia::render('Guest/OTPPage',[
            'verification_id'=> $verification->id,
        ]);

    }

    public function verification(Request $request){
        $verification = VerificationCode::where('id',$request->verification_id)
                ->where('expire_at','>=',Carbon::now())->latest()->first();
        
            if($verification){
            if($verification->otp==$request->userOtp){
                $user = User::create([
                    'name' => $verification->name,
                    'email' => $verification->email,
                    'password' => Hash::make($verification->password),
                    'address'=>$verification->address,
                    'district'=>$verification->district,
                    'gender'=>$verification->gender,
                    'mobile'=>$verification->mobile,
                    'active'=> true,
                    'role_id'=>5, //ROLE ID 5 = CITIZEN|FROM THIS ONLY CITIZEN WILL REGISTER
                ]);


                $phone = $verification->mobile;
                //template 14
                //Chibai {#var#}, {#var#} ah i lo in-register avangin kan lâwm e. I registration a fel tawh a. {#var#}.mizoram.gov.in ah lûtin Grievance i theih lût thei e. EGOV-MZ
                $message = 'Chibai  '.$verification->name.',  MIPUI AW ah i lo in-register avangin kan lâwm e. I registration a fel tawh a. '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lûtin Grievance i theih lût thei e. EGOV-MZ';
                $templateId ='1407170608238248851';
                // $message = 'Hello '.$verification->name.', thank you for registering with MIPUI AW. Your registration process is now completed. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for more actions. EGOV-MZ';
                // $templateId ='1407168966062765340';
                thangteaSMS($phone,$message,$templateId);
        
                email($verification->name, $verification->email, $message,"Mipui Aw registration successful" );

                VerificationCode::find($request->verification_id)->delete();
                event(new Registered($user));
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }else{
                return Inertia::render('Guest/OTPPage',[
                    'error'=> "Wrong OTP, Try Again",
                    'verification_id'=> $verification->id,
                ]);
            }
        }else{
            return "Time out or something, please go back and try again";
        }
    }

    public function generateOtpForMobileUpdate(Request $request){
         
        VerificationCode::where('expire_at','<',Carbon::now())->delete();
        $request->validate([ 'new_mobile' => 'required|numeric|digits:10' ]);

        $OTP = rand(123456,999999);
        $CURRENT_USER = Auth::user();
        $verification = VerificationCode::create([
            'name' => $CURRENT_USER->name,
            'email' => $CURRENT_USER->email,
            'password' => $CURRENT_USER->password,
            'address'=>$CURRENT_USER->address,
            'district'=>$CURRENT_USER->district,
            'gender'=>$CURRENT_USER->gender,
            'mobile'=>$request->new_mobile,
            'role_id'=>5, //ROLE ID 5 = CITIZEN|FROM THIS ONLY CITIZEN WILL REGISTER
            'otp'=> $OTP,
            'expire_at' => Carbon::now()->addMinutes(5),
        ]);
        //Otp (16)
        //{#var#} atâna OTP chu {#var#} a ni e. EGOV-MZ
        $templateID = "1407170608246834529";
        $message = "MIPUI-AW atâna OTP chu ".$OTP ." a ni e. EGOV-MZ";
        thangteaSMS($request->new_mobile,$message,$templateID,true);

        $mailDetails = $OTP ." is your OTP for MIPUI-AW";
        email($CURRENT_USER->name, $CURRENT_USER->email, $mailDetails,$mailDetails );

        if(Auth::user()->role_id == 5){
            $path ='Citizen/User/UpdatePhone/OtpPage';
        }else{
            $path ='Auth/OfficerUser/UpdatePhone/OtpPage';
        }

        return Inertia::render($path,[
            'verification_id'=> $verification->id,
            'new_mobile'=>$request->new_mobile,
        ]);
    }

    public function verificationForMobileUpdate(Request $request){
       
        $verification = VerificationCode::where('id',$request->verification_id)
                ->where('expire_at','>=',Carbon::now())->latest()->first();
        if($verification){
            if($verification->otp==$request->userOtp){
                $user=User::find(Auth::user()->id);
                $user->mobile= $verification->mobile;
                $user->save();
                VerificationCode::find($request->verification_id)->delete();
 
                return to_route('user.details.show')->with('message','Phone number update successfully');
            }else{
                //return redirect()->back()->with('message','Wrong OTP, Try Again');

                if(Auth::user()->role_id == 5){
                    $path ='Citizen/User/UpdatePhone/OtpPage';
                }else{
                    $path ='Auth/OfficerUser/UpdatePhone/OtpPage';
                }

                
                return Inertia::render($path,[
                    'error'=> "Wrong OTP, Try Again",
                    'verification_id'=> $verification->id,
                ])->with('message','Wrong OTP, Try Again');
            }
        }else{
            return redirect()->back()->with('message','Time out, please go back and try again');
          
        }
    }

    public function resentOtpForMobileUpdate($verificationId){
        $verification = VerificationCode::find($verificationId);
        $OTP = rand(123456,999999);
        //Otp (16)
        //{#var#} atâna OTP chu {#var#} a ni e. EGOV-MZ
        $templateID = "1407170608246834529";
        $message = "MIPUI-AW atâna OTP chu ".$OTP ." a ni e. EGOV-MZ";
        // $templateID = "1407165911820847483";
        // $message = "Your OTP for MIPUI-AW is ".$OTP .".EGOVMZ";
        thangteaSMS($verification->mobile,$message,$templateID,true);
    
        $mailDetails = $OTP ." is your OTP for MIPUI-AW";
        email($verification->name, $verification->email, $mailDetails,$mailDetails );

        $verification->otp = $OTP;
        $verification->expire_at =Carbon::now()->addMinutes(5);
        $verification->save();

        return redirect()->back()->with('message_success','OTP resent successfully');

       

    }
}
