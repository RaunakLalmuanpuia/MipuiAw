<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Grievance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class OfficerAppellateController extends Controller
{
    public $DOMAIN_NAME;

    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    public function index(){

        $CURRENT_USER = Auth::user();
        if($CURRENT_USER->role_id ==1 || $CURRENT_USER->role_id==2){
            $appellateAuthority = User::with(['department','role'])->where('role_id',6)->get();//GET THE APPELLATE AUTHORITY FROM ALL DEPARTMENT
            $isSuperAdmin = true;
        }else{
            $appellateAuthority = User::with(['department','role'])->where('department_id',$CURRENT_USER->department_id)->where('role_id',6)->get();//GET THE APPELLATE AUTHORITY FROM MY DEPARTMENT
            $isSuperAdmin = false;
        }

        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();

        return Inertia::render('Auth/AppellateAuthority/Index',[
            'appellateAuthority' => $appellateAuthority,
            'isSuperAdmin' => $isSuperAdmin,
            'departments' => $departments,
        ]); 
               
    }

    public function create(){

        $CURRENT_USER=Auth::user();

        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();
        
        if($CURRENT_USER->role_id ==1 ||$CURRENT_USER->role_id ==2 )
        $isSuperAdmin = true;
        else $isSuperAdmin = false;

        return Inertia::render('Auth/AppellateAuthority/Create',[
            'departments' => $departments,
            'isSuperAdmin' => $isSuperAdmin,
        ]);
    }

    public function store(Request $request){

        $CURRENT_USER = Auth::user();

        $validate = $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email'.$request->id,
            'password'=>'required|max:250',
             
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'alternate_mobile'=> 'required',
            
            'active'=> 'required',
            
        ]);

        if($CURRENT_USER->role_id ==1 || $CURRENT_USER->role_id ==2){
            $request->validate([
                'department' => 'required'
            ]);
        }
         
        $newAppellateOfficer = new User();

        $newAppellateOfficer->name = $request->name;
        $newAppellateOfficer->email = $request->email;
        $newAppellateOfficer->password = Hash::make($request->password);
        $newAppellateOfficer->mobile = $request->mobile;
        $newAppellateOfficer->gender = $request->gender;
        $newAppellateOfficer->designation = $request->designation;
        $newAppellateOfficer->address = $request->address;
        $newAppellateOfficer->pincode = $request->pincode;
        $newAppellateOfficer->alternate_mobile = $request->alternate_mobile??'';
        $newAppellateOfficer->notification = $request->notification;
        $newAppellateOfficer->active = $request->active['value'];

        $newAppellateOfficer ->role_id = 6;//ROLE: DEPARTMENTAL APPELLATE AUTHORITY=6

        if($CURRENT_USER->role_id ==1 ||$CURRENT_USER->role_id ==2 ){
            $newAppellateOfficer->department_id = $request->department['value'];
        }
        else{
            $newAppellateOfficer->department_id = $CURRENT_USER->department_id;
        }  

        $newAppellateOfficer->save();
                
        //TODO:SEND SMS | Sl. 15
        $phone = $request->mobile;
        $message = 'Chibai '.$newAppellateOfficer->name.', '.$this->DOMAIN_NAME.'.mizoram.gov.in ah in Department Nodal Officer in a register che tih hriattir I ni e. EGOV-MZ';
        $templateId ='1407170608242353930';
        // $message = 'Hello '.$newAppellateOfficer->name.', you have been registered to '.$this->DOMAIN_NAME.'.mizoram.gov.in by your Department Nodal Officer, '.$CURRENT_USER->name.'. EGOV-MZ';
        // $templateId ='1407168966069639802';
        thangteaSMS($phone,$message,$templateId);

        return to_route('appellate.index');
    }

    public function update(Request $request, $id){

        $CURRENT_USER=Auth::user();

        $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email,'.$id,
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'alternate_mobile'=> 'required',
            'active' => 'required'
        ]);

        if($CURRENT_USER->role_id ==1 || $CURRENT_USER->role_id ==2){
            $request->validate([
                'department' => 'required'
            ]);
        }
         
        $appellateOfficer = User::find($id);
       
        $appellateOfficer->name = $request->name;
        $appellateOfficer->email = $request->email;

        $appellateOfficer->mobile = $request->mobile;
        $appellateOfficer->gender = $request->gender;
        $appellateOfficer->designation = $request->designation;
        $appellateOfficer->district = $request->district;
        $appellateOfficer->address = $request->address;
        $appellateOfficer->pincode = $request->pincode;
        $appellateOfficer->alternate_mobile = $request->alternate_mobile??'';
        $appellateOfficer->notification = $request->notification;
        $appellateOfficer->active = $request->active['value'];
        
        if($CURRENT_USER->role_id ==1 ||$CURRENT_USER->role_id ==2 ){
            $appellateOfficer->department_id = $request->department['id'];
        }
        else{
            $appellateOfficer->department_id = $CURRENT_USER->department_id;
        } 

        $appellateOfficer->save();

        return to_route('appellate.index');
        
    }

}
