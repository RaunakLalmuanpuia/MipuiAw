<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ApplicantController extends Controller
{
 
    public function index(Request $request)
    {
       
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
 

        $applicantUsers = User::where('role_id',5)
            ->where(function($query) use($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('name','LIKE',"%$SEARCH%")
                    ->orWhere('mobile','LIKE',"%$SEARCH%")
                    ->orWhere('email','LIKE',"%$SEARCH%");
            })->latest()->paginate($PER_PAGE);
        
        return Inertia::render('Auth/Applicant/Index',[
            'applicantUsers' => $applicantUsers,
            'search' => $SEARCH
        ]);
    }

 
    public function create()
    {
        return Inertia::render('Auth/Applicant/Create');

    }
 
    public function store(Request $request)
    {

        $validate=$request->validate([
            'name'=>'required',
            'mobile'=>'required|digits:10',
            'password'=>'required|confirmed',
            'email'=>'required|max:250|unique:users,email,'.$request->id,
            'gender'=>'required',
            'address'=>'required',
            'pincode'=>'required',
            //'alternate_mobile'=>'required',
            'district'=>'required',
            'active'=>'required',
            
        ]);

        $applicant = new User();
        $applicant->name = $request->name;
        $applicant->mobile = $request->mobile;
        $applicant->password = $request->password;
        $applicant->email = $request->email;
        $applicant->gender = $request->gender;
        $applicant->address = $request->address;
        $applicant->pincode = $request->pincode;
        $applicant->alternate_mobile = $request->alternate_mobile??'';
        $applicant->district = $request->district;
        $applicant->active = $request->active['value'];

        $applicant->role_id = 5;//CITIZEN ROLE

        $applicant->save();

        return to_route('applicant.index');


    }

 
    public function show(string $id)
    {
        $user=User::with(['grievance','role','department'])->find($id);

        return Inertia::render('Auth/Applicant/Show',[
            'user'=>$user,

        ]);
    }
    public function singleUserShow()
    {
        $user = Auth::user();
        $user=User::with(['grievance','role','department'])->find($user->id);

        return Inertia::render('Citizen/User/Show',[
            'user'=>$user,

        ]);
    }
    public function singleOfficerShow()
    {
        $user = Auth::user();
        $user=User::with(['grievance','role','department'])->find($user->id);

        return Inertia::render('Auth/OfficerUser/Show',[
            'user'=>$user,
        ]);
    }

    public function edit(string $id)
    {
        $user=User::with(['grievance','role','department'])->find($id);
         
        return Inertia::render('Auth/Applicant/Show',[
            'user'=>$user,

        ]);
    }
 
    public function update(Request $request, string $id)
    {
         
        $validate=$request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email,'.$id,
            'gender'=>'required',
            'address'=>'required',
            'pincode'=>'required',
           // 'alternate_mobile'=>'required',
            'district'=>'required',
            'active'=>'required',
            
        ]);

        $mUser = User::find($id);

        if($mUser->role_id==3 ||$mUser->role_id==4 ||$mUser->role_id==6 ){
            $validate=$request->validate([
                'designation'=>'required',
        ]);
            

        }

        $mUser->name = $request->name;
        $mUser->designation = $request->designation;

        $mUser->mobile = $request->mobile;
        $mUser->email = $request->email;
        $mUser->gender = $request->gender;
        $mUser->address = $request->address;
        $mUser->pincode = $request->pincode;
        $mUser->alternate_mobile = $request->alternate_mobile??'';
        $mUser->district = $request->district;
        $mUser->active = $request->active['value'];
        if($request->password!=null)    
            $mUser->password = Hash::make($request->password);
       
        $mUser->save();
    }
 
    public function destroy(string $id)
    {
      
        $userId = $id;
        $CURRENT_USER = Auth::user();

        if($CURRENT_USER->id == $id) {
            createUserBackUpBeforeDelete($userId);
        }elseif($CURRENT_USER->role_id==1 ||$CURRENT_USER->role_id==2){
            
            //create backup and delete
            createUserBackUpBeforeDelete($userId);
        }

        

    }
}
