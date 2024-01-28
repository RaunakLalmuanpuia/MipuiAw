<?php

namespace App\Http\Controllers;

use App\Models\SubDepartment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Department;
use App\Models\GrievanceMovement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subDepartment = SubDepartment::with('department')->get();
        return Inertia::render('Auth/Sub-Department/Index',[
            'subDepartment'=> $subDepartment,
        ]);
    }
 
    public function create()
    {
        //
    }

     
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'department_id'=> 'required',
            'organization_name'=>'required|max:250',
            'organization_code'=>'required|max:250',
            'organization_type'=>'required|max:250',
            'organization_address'=>'required|max:250',
            'pincode'=>'required|max:250',
        ]);

        SubDepartment::create($attributes);
        return redirect()->route('index.sibling',[$request->department_id]);
        //return redirect("'/department/sibing/'+$request->department_id");
    }
 
    public function show(SubDepartment $subDepartment)
    {
        //
    }
 
    public function edit(SubDepartment $subDepartment)
    {
        //
    }
 
    public function update(Request $request, $subDepartmentId)
    {
        
         $mSubDepartment = SubDepartment::find($subDepartmentId);
      
         $mSubDepartment->organization_name=$request->organization_name;
         $mSubDepartment->organization_code=$request->organization_code;
         $mSubDepartment->organization_type=$request->organization_type;
         $mSubDepartment->organization_address=$request->organization_address;
         $mSubDepartment->pincode=$request->pincode;
 
         $mSubDepartment->save();
    }
 
    public function destroy($subDepartmentId)
    {
      
         $userPresent = User::where('sub_department_id',$subDepartmentId)->count();

         $subDepartmentPresent = GrievanceMovement::where("to_type",SubDepartment::class)->where('to_id',$subDepartmentId)->count();
        
         if($userPresent!=0 || $subDepartmentPresent!=0){
            //USER PRESENT 
            //dd("do not delete");
            if($userPresent!=0 && $subDepartmentPresent!=0)
                $message = "He Sub-Department ah hian Officer an la awm, bakah grievance thawh a ni tawh";
            else if($userPresent!=0)
                $message = "He Sub-Department ah hian Officer an awm";
            else if($subDepartmentPresent!=0)
                $message = "He Sub-Department ah hian grievance thawh a ni tawh";
            else    $message="";

            return redirect()->back()->with('message',$message);    

         }else{
            //NO USER
            //dd("can delete");


            $subDepartment = SubDepartment::find($subDepartmentId)->delete();
            
            $message = "Sub-Department remove successfully";
            return redirect()->back()->with('message_success',$message);    

         }
         
    }

    public function sibling($parentId){
     
        $CURRENT_USER = Auth::user();
        if($CURRENT_USER->role_id==1 ||$CURRENT_USER->role_id==2){  
            $mySiblings = SubDepartment::where('department_id',$parentId)->get();
            $departmentRow = Department::find($parentId);
            return Inertia::render('Auth/Department/Sub-Department/Index',[
                'sibling'=> $mySiblings,
                'departmentName' => $departmentRow->organization_name??'x',
                'departmentId' => $departmentRow->id??'',
            ]);
            
        }else{
            if($CURRENT_USER->department_id == $parentId){
                $mySiblings = SubDepartment::where('department_id',$parentId)->get();
                $departmentRow = Department::find($parentId);
                return Inertia::render('Auth/Department/Sub-Department/Index',[
                    'sibling'=> $mySiblings,
                    'departmentName' => $departmentRow->organization_name??'x',
                    'departmentId' => $departmentRow->id??'',
                ]);
            }else{  
                return back();
            }
        }
         
        
    }

    public function createSibling($parentId){

        $departmentRow = Department::find($parentId);
        return Inertia::render('Auth/Department/Sub-Department/Create',[
            'departmentName' => $departmentRow->organization_name,
            'departmentId' => $departmentRow->id,


        ]);
    }
}
