<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public $DOMAIN_NAME;

    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    public function create(): Response
    {
        return Inertia::render('Guest/Register');
    }
 
    public function store(Request $request): RedirectResponse
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required'],
            'district' => 'required',
            'gender' => 'required',
            'mobile' => 'required|numeric|digits:10'
        ]);
         
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'address'=>$request->address,
            'district'=>$request->district,
            'gender'=>$request->gender,
            'mobile'=>$request->mobile,
            'active' => true,
            'role_id'=>5, //ROLE ID 5 = CITIZEN|FROM THIS ONLY CITIZEN WILL REGISTER
        ]);

        //TODO:SEND SMS | Sl. 14
        
        $phone = $request->mobile;
        //Chibai {#var#}, {#var#} ah i lo in-register avangin kan lâwm e. I registration a fel tawh a. {#var#}.mizoram.gov.in ah lûtin Grievance i theih lût thei e. EGOV-MZ
        $message = 'Chibai '.$request->name.', MIPUI AW ah i lo in-register avangin kan lâwm e. I registration a fel tawh a. '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lûtin Grievance i theih lût thei e. EGOV-MZ';
        $templateId ='1407170608238248851';
        // $message = 'Hello '.$request->name.', thank you for registering with MIPUI AW. Your registration process is now completed. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for more actions. EGOV-MZ';
        // $templateId ='1407168966062765340';
        thangteaSMS($phone,$message,$templateId);


        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
