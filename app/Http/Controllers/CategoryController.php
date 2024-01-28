<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function index()
    {

        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();
        
        $CURRENT_USER= Auth::user();
        if($CURRENT_USER->role_id==1){ //SUPER ADMIN
            $categories= Category::with('department')->get();

            $grievances = Grievance::where('category_id','!=',null)->select('category_id')->get();

            foreach($categories as $category){
                foreach($grievances as $g){
                    if($category->id == $g->category_id){
                        //$category->put('isDirty',true);
                        $category['isUsed']=true;
                    }
                }
            }
             
        }else if ($CURRENT_USER->role_id==2 ||$CURRENT_USER->role_id==3){
            $categories=Category::with('department')->where('department_id',$CURRENT_USER->department_id)->get();
            $grievances = Grievance::where('category_id','!=',null)->select('category_id')->get();

            foreach($categories as $category){
                foreach($grievances as $g){
                    if($category->id == $g->category_id){
                        //$category->put('isDirty',true);
                        $category['isUsed']=true;
                    }
                }
            }
             
        }else{
            return view('403');
        }

        
        return Inertia::render('Auth/Category/Index',[
            'categories' => $categories,
            'departments' => $departments,
            'CURRENT_USER' => $CURRENT_USER,
            'categoryMessage' => null,

        ]);
    }

    public function create()
    {
        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();
        $CURRENT_USER = Auth::user();

        return Inertia::render('Auth/Category/Create',[
            'departments'=> $departments,
            'CURRENT_USER'=> $CURRENT_USER,

        ]);
    }

    public function store(Request $request)
    { 
        $validate=$request->validate([
            'name'=>'required',
            'department'=>'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->department_id = $request->department;
        $category->save();
        return to_route('category.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    { 
        $validate=$request->validate([
            'name'=>'required',
        ]);
        $category = Category::find($category->id);
        $category->name = $request->name;
        $category->department_id = $request->department;
        $category->save();
    }

    public function destroy(Category $category)
    {
        $grievances=Grievance::where('category_id',$category->id)->get();
        foreach($grievances as $g){
            $g->category_id = null;
            $g->save();
        }
        //$grievances->save();

        $category = Category::find($category->id);
        $category->delete();
        
    }

     
}
