<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\SubDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class DepartmentNodalController extends Controller
{
    public $DOMAIN_NAME;

    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 
    public function index()
    {
        $user = Auth::user();
        
        $DEPARTMENT_ID = $user->department_id;
        $departmentName = Department::where('id',$DEPARTMENT_ID)->pluck('organization_name')->first();
        $departmentUsers = User::with(['role','subDepartment'])
                    ->where('department_id',$DEPARTMENT_ID)
                    ->where('role_id',4)
                    ->get();
         
        //  bid  \\ 
        // iiiii \\  
        // |-|-| \\
        //  ---  \\

        return Inertia::render('Auth/DepartmentNodal/Index',[
            'departmentUsers' => $departmentUsers,
            'departmentName' => $departmentName,
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        $subDepartment = SubDepartment::select('id as value','organization_name as label' )
        ->where('department_id',$user->department_id)->get();
 
        $DEPARTMENT_ID = $user->department_id;
        $departmentName = Department::where('id',$DEPARTMENT_ID)->select('id','organization_name')->first();
        
        return Inertia::render('Auth/DepartmentNodal/Create',[
            'departmentName' => $departmentName,
            'subDepartment' => $subDepartment,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        
        $attributes = $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users'.$request->id,
            'password'=>'required|max:250',
            'mobile'=>'required|digits:10',
            'gender'=> 'required',
            'designation'=> 'required',
            'address'=> 'required',
            'pincode'=> 'required',
            //'alternate_mobile'=> 'required',
            
            'active'=> 'required',
            'subDepartment'=> 'required',

        ]);

        //GET THE CURRENT DEPARTMENT NODAL OFFICER AND USE THE DEPT ID FOR THE SUBORDINATE ID
        
        $DEPARTMENT_ID = Auth::user()->department_id; 
        $USER_ID = Auth::user()->id;
        
        $newSubDepartmentOfficer = new User();
        $newSubDepartmentOfficer->department_id = $request->department_id; //the subdepartment nodal officer used the State Nodal department ID
        $newSubDepartmentOfficer->sub_department_id = $request->subDepartment['value']; 

        $newSubDepartmentOfficer->name = $request->name;
        $newSubDepartmentOfficer->email = $request->email;
        $newSubDepartmentOfficer->password = Hash::make($request->password);

        $newSubDepartmentOfficer->mobile = $request->mobile;
        $newSubDepartmentOfficer->gender = $request->gender;
        $newSubDepartmentOfficer->designation = $request->designation;
        $newSubDepartmentOfficer->address = $request->address;
        $newSubDepartmentOfficer->pincode = $request->pincode;
        $newSubDepartmentOfficer->alternate_mobile = $request->alternate_mobile??'';
        $newSubDepartmentOfficer->notification = $request->notification;
        $newSubDepartmentOfficer->active = $request->active['value'];

        $newSubDepartmentOfficer->role_id = 4; //ROLE: SubDepartment Nodal Officer=4


        $newSubDepartmentOfficer->save();
        
        //TODO:SEND SMS | Sl. 15
        $phone = $request->mobile;
        $message = 'Chibai '.$newSubDepartmentOfficer->name.', '.$this->DOMAIN_NAME.'.mizoram.gov.in ah in Department Nodal Officer in a register che tih hriattir I ni e. EGOV-MZ';
        $templateId ='1407170608242353930';
        // $message = 'Hello '.$newAppellateOfficer->name.', you have been registered to '.$this->DOMAIN_NAME.'.mizoram.gov.in by your Department Nodal Officer, '.$CURRENT_USER->name.'. EGOV-MZ';
        // $templateId ='1407168966069639802';
        thangteaSMS($phone,$message,$templateId);
        email($newSubDepartmentOfficer->name, $newSubDepartmentOfficer->email, $message,"Mipui Aw registration successful" );
        
        return to_route('departmentnodal.index');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
    
    }

 
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name'=>'required',
            'email'=>'required|max:250|unique:users,email,'.$id,
        ]);

        $stateNodalOfficer=User::find($id);
        $stateNodalOfficer->name = $request->name;
        $stateNodalOfficer->email = $request->email;
        $stateNodalOfficer->sub_department_id = $request->subDepartment['value'];

        $stateNodalOfficer->mobile = $request->mobile;
        $stateNodalOfficer->gender = $request->gender;
        $stateNodalOfficer->designation = $request->designation;
        $stateNodalOfficer->address = $request->address;
        $stateNodalOfficer->pincode = $request->pincode;
        $stateNodalOfficer->alternate_mobile = $request->alternate_mobile??'';
        $stateNodalOfficer->notification = $request->notification;
        $stateNodalOfficer->active = $request->active['value'];
        
        $stateNodalOfficer->save();
        
        return to_route('index.nodal.sibling',$stateNodalOfficer->department->id);
    }

    public function destroy(string $id)
    {
        //
    }

    public function editSubNodal($userId){
        $roles = Role::all();
        $stateNodalOfficer=User::find($userId);

        $subDepartment = SubDepartment::select('id as value','organization_name as label' )
            ->where('department_id',$stateNodalOfficer->department_id)->get();
       
        $currentSubDepartment=SubDepartment::select('id as value','organization_name as label')
            ->where('id',$stateNodalOfficer->sub_department_id)->first();

        return Inertia::render('Auth/DepartmentNodal/Edit',[
            'stateNodalOfficer'=>$stateNodalOfficer,
            'roles'=>$roles,
            'subDepartment' => $subDepartment,
            'currentSubDepartment' => $currentSubDepartment,
            
        ]);
    }
}
