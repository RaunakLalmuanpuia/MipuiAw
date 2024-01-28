<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Psy\debug;

class DepartmentController extends Controller
{
  
    public function index()
    {
        $departments = Department::all();
        return Inertia::render('Auth/Department/Index',[
            'departments'=>$departments,
            
        ]);
    }

    public function create()
    {
        
        return Inertia::render('Auth/Department/Create');
    }

    public function store(Request $request)
    {
       
        $attributes = $request->validate([
            'organization_name'=>'required|max:250',
            'organization_code'=>'required|max:250',
            'organization_type'=>'required|max:250',
            'organization_address'=>'required|max:250',
            'pincode'=>'required|max:250',
        ]);

        Department::create($attributes);

        return redirect('/department');
    }

    public function show(Department $department)
    {
        //
    }

    public function edit(Department $department)
    {
      
    }

    public function update(Request $request, Department $department)
    {
       // dd($request);
        $mDepartment = Department::find($department->id);
        $mDepartment->organization_name=$request->organization_name;
        $mDepartment->organization_code=$request->organization_code;
        $mDepartment->organization_type=$request->organization_type;
        $mDepartment->organization_address=$request->organization_address;
        $mDepartment->pincode=$request->pincode;

        $mDepartment->save();
       
    }

    public function destroy(Department $department)
    {
         
    }
}
