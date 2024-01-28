<?php

namespace App\Http\Controllers;

use App\Models\DeletedUser;
use App\Models\Department;
use App\Models\Role;
use App\Models\SubDepartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OfficerProfileController extends Controller
{
 
    public $DOMAIN_NAME;
    
    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    public function index()
    {
        //return $stateNodalOfficers;
    }

    public function create()
    {
        $CURRENT_USER = Auth::user();
        
        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();
        if($CURRENT_USER->role_id == 1){
            $roles = Role::select(['id as value','name as label'])->get();    
        }else{
            //GET THE , STATE NODAL OFFICER | DEPARTMENT NODAL OFFICER | DEPARTMENTAL APPELLATE OFFICER
            $roles = Role::select(['id as value','name as label'])->whereIn('id',[3,4,6])->get();    
        }
        $roles = Role::select(['id as value','name as label'])->get();
        
        

        return Inertia::render('Auth/AllUser/Create',[
            'departments'=> $departments,
            'roles' => $roles,
        ]);
    }
 
    public function store(Request $request)
    {
        
        $attributes = $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users'.$request->id,
            'password'=>'required|max:250',
            'department'=> 'required',
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'alternate_mobile'=> 'required',
            //'notification'=> 'required',
            'active'=> 'required',

        ]);

        $newDepartmentNodalOfficer = new User();
        $newDepartmentNodalOfficer->name = $request->name;
        $newDepartmentNodalOfficer->email = $request->email;
        $newDepartmentNodalOfficer->password = Hash::make($request->password);
        $newDepartmentNodalOfficer->department_id = $request->department['value'];

        $newDepartmentNodalOfficer->mobile = $request->mobile;
        $newDepartmentNodalOfficer->gender = $request->gender;
        $newDepartmentNodalOfficer->designation = $request->designation;
        $newDepartmentNodalOfficer->address = $request->address;
        $newDepartmentNodalOfficer->pincode = $request->pincode;
        $newDepartmentNodalOfficer->alternate_mobile = $request->alternate_mobile??'';
        $newDepartmentNodalOfficer->notification = $request->notification;
        $newDepartmentNodalOfficer->active = $request->active['value'];

        $newDepartmentNodalOfficer->role_id = 3;//ROLE: DEPARTMENT NODAL OFFICER-3
        //$newStateNodalOfficer->role_id = $request->role['value'];

        $newDepartmentNodalOfficer->save();

        $CURRENT_USER = Auth::user();

        //TODO:SEND SMS | Sl. 16
        $phone = $request->mobile;
        $message = 'Chibai '.$newDepartmentNodalOfficer->name.', '.$this->DOMAIN_NAME.'.mizoram.gov.in ah in Department Nodal Officer in a register che tih hriattir I ni e. EGOV-MZ';
        $templateId ='1407170608242353930';
        // $message = 'Hello '.$newDepartmentNodalOfficer->name.', you have been registered to '.$this->DOMAIN_NAME.' by your Department Nodal Officer, '.$CURRENT_USER->name.'. EGOV-MZ';
        // $templateId ='1407168966069639802';
        thangteaSMS($phone,$message,$templateId);

        return to_route('all.officer');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, string $id)
    {
        
        $roles = Role::select('id as value','name as label' )->get();

        $stateNodalOfficer=User::with('role')->find($id);//->with('role')->first();
        $departments= Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();

        $myDepartment= Department::select('id as value','organization_name as label' )
            ->where('id',$stateNodalOfficer->department_id)->first();
        $myRole =Role::select('id as value','name as label' )->where('id',$stateNodalOfficer->role_id)->first();
        
        // $subDepartment = SubDepartment::select('id as value','organization_name as label' )
        //     ->where('department_id',$stateNodalOfficer->department)->get();
       
        // $currentSubDepartment=SubDepartment::select('id as value','organization_name as label')
        //     ->where('id',$stateNodalOfficer->sub_department)->first();

        return Inertia::render('Auth/AllUser/Edit',[
            'stateNodalOfficer'=>$stateNodalOfficer,
            'roles'=>$roles,
            'departments' => $departments,
            'myDepartment' => $myDepartment,
            'myRole' => $myRole,
            'referer'=> $request->header('referer'),
            
        ]);
    }

    public function update(Request $request, string $id)
    { 
        
        $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email,'.$id,
            'department'=> 'required',
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'alternate_mobile'=> 'required',
            //'notification'=> 'required',
            'active'=> 'required',
        ]);
          
        $updateDepartmentNodalOfficer=User::find($id);
        
        if($request->password!='' || $request->password!=null) {
            $updateDepartmentNodalOfficer->password = Hash::make($request->password);
        }
        $updateDepartmentNodalOfficer->name = $request->name;
        $updateDepartmentNodalOfficer->email = $request->email;
        $updateDepartmentNodalOfficer->department_id = $request->department['value'];
        $updateDepartmentNodalOfficer->role_id = $request->role['value'];

        $updateDepartmentNodalOfficer->mobile = $request->mobile;
        $updateDepartmentNodalOfficer->gender = $request->gender;
        $updateDepartmentNodalOfficer->designation = $request->designation;
        $updateDepartmentNodalOfficer->address = $request->address;
        $updateDepartmentNodalOfficer->pincode = $request->pincode;
        $updateDepartmentNodalOfficer->alternate_mobile = $request->alternate_mobile??'';
        $updateDepartmentNodalOfficer->notification = $request->notification;
        $updateDepartmentNodalOfficer->active = $request->active['value'];
        $updateDepartmentNodalOfficer->save();

        // referer can be:
        //     1. null
        //     2. http://localhost:8000/allsubofficer
        //     3. http://localhost:8000/allofficerlist

        if(str_contains($request->referer,'allofficerlist')){
            return to_route('all.officer');
        }else if (str_contains($request->referer,'allsubofficer')){
            return to_route('all.subofficer');
        }else{
            return to_route('officer.dashboard');
        }
    }

   
    public function destroy(string $id)
    {
        $userId = $id;
        $currentUser=  User::where('id',Auth::user()->id)->first();
        if($currentUser->role_id==1 || $currentUser->role_id==2 || $currentUser->role_id==3){
            //Create backup and delete
            createUserBackUpBeforeDelete($userId);
    
        }

    }

    public function allOfficer(){
       
        $currentUser=  User::with(['role'])->where('id',Auth::user()->id)->first();
        
        if($currentUser->role_id==1 || $currentUser->role_id==2  ){

            $stateNodalOfficers = User::with(['role','department'])->whereIn('role_id',[2,3])->get();
            //2=STATE NODAL
            //3=DEPARTMENT NODAL
            //6=DEPARTMENTAL APPELETE|
          
            return Inertia::render('Auth/AllUser/Index',[
                'stateNodalOfficers'=>$stateNodalOfficers,
            ]);

        }else{
            return "This page is available for super admin only";
        }
    }
    
    public function subOfficer(){
       
        $currentUser=  User::with(['role'])->where('id',Auth::user()->id)->first();
        if($currentUser->role_id==1 || $currentUser->role_id==2  ){
            $subNodalOfficers = User::with(['role','department'])->whereIn('role_id',[4])->get();
            //2=STATE NODAL
            //3=DEPARTMENT NODAL
            //6=DEPARTMENTAL APPELETE|
            return Inertia::render('Auth/AllUser/SubOfficerIndex',[
                'subNodalOfficers'=>$subNodalOfficers,
            ]);
        }else{
            return "This page is available for super admin only";
        }
    }

    public function sibling($parentDepartmentId){

        $mySiblings = User::with(['role'])->where('department_id',$parentDepartmentId)->where('role_id',4)->get();

        $departmentRow = Department::find($parentDepartmentId);

        return Inertia::render('Auth/AllUser/SubUser/Index',[
            'sibling'=> $mySiblings,
            'departmentName' => $departmentRow->organization_name,
            'departmentId' => $departmentRow->id,
        ]);
    }

    public function createSibling($parentDepartmentId){
        
        //dd($parentDepartmentId);
        $departmentRow = Department::find($parentDepartmentId);
        $subDepartment = SubDepartment::select('id as value','organization_name as label' )->orderBy('organization_name','ASC')
            ->where('department_id',$parentDepartmentId)->get();

        //dd($subDepartment);
        return Inertia::render('Auth/AllUser/SubUser/Create',[
            'departmentName' => $departmentRow->organization_name,
            'departmentId' => $parentDepartmentId,
            'subDepartment' => $subDepartment,
        ]);
    }

    public function storeSibling(Request $request){

        $attributes = $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users'.$request->id,
            'password'=>'required|max:250',
            'department'=> 'required',
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'notification'=> 'required',
            'active'=> 'required',
             
        ]);

        $newSubDepartmentOfficer = new User();

        $newSubDepartmentOfficer->name = $request->name;
        $newSubDepartmentOfficer->email = $request->email;
        $newSubDepartmentOfficer->password = Hash::make($request->password);
        $newSubDepartmentOfficer->department_id = $request->department;
        $newSubDepartmentOfficer->sub_department_id = $request->subDepartment['value'] ;
        $newSubDepartmentOfficer->mobile = $request->mobile;
        $newSubDepartmentOfficer->gender = $request->gender;
        $newSubDepartmentOfficer->designation = $request->designation;
        $newSubDepartmentOfficer->address = $request->address;
        $newSubDepartmentOfficer->pincode = $request->pincode;
        $newSubDepartmentOfficer->alternate_mobile = $request->alternate_mobile??'';
        $newSubDepartmentOfficer->notification = $request->notification;
        $newSubDepartmentOfficer->active = $request->active['value'];
        $newSubDepartmentOfficer->role_id = 4;//ROLE:SUBNODAL OFFICER-4
        dd($newSubDepartmentOfficer);
        $newSubDepartmentOfficer->save();

        return to_route('index.nodal.sibling',$request->department);
    }

    public function adminViewSubNodalOfficerEdit($userId){
        
        $roles = Role::all();
        $subNodalOfficer=User::find($userId);

        $subDepartment = SubDepartment::select('id as value','organization_name as label' )->orderBy('organization_name','ASC')
            ->where('department_id',$subNodalOfficer->department_id)->get();
       
        $currentSubDepartment=SubDepartment::select('id as value','organization_name as label')
            ->where('id',$subNodalOfficer->sub_department_id)->first();

        return Inertia::render('Auth/AllUser/SubUser/Edit',[
            'subNodalOfficer'=>$subNodalOfficer,
            'roles'=>$roles,
            'subDepartment' => $subDepartment,
            'currentSubDepartment' => $currentSubDepartment,
            
        ]);

    }

    public function officerPasswordChange(Request $request){

        $CURRENT_USER = Auth::user();
        
        $validate = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        
        $theOfficer = User::find($request->officer_id);
        $theOfficer->password = Hash::make($request->password);
        $theOfficer->save();
 
        $resetBy = $CURRENT_USER->name.', '.$CURRENT_USER->designation;

        //TODO:SEND SMS | Sl. 17
        $phone = $theOfficer->mobile;
        $message = 'Chibai  '.$theOfficer->name.',  Mipui Aw a I password '.$resetBy.' in a thlak a. I password thar chu '.$request->password.' a ni. A rang thei ang ber a '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lutin I password thlak ang che. EGOV-MZ';
        $templateId ='1407170608250496376';
        thangteaSMS($phone,$message,$templateId);

    }
}
