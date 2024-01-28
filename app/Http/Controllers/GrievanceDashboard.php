<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Grievance; 

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder; 

class GrievanceDashboard extends Controller
{
    public function NotYetOpen(Request $request){ 
      
        $CURRENT_USER=Auth::user();

        $mUser=User::find($CURRENT_USER->id);
        $mUser->last_login=Carbon::now()->toDateTimeString();
        $mUser->save();

        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
        $PROBABLE_DEPARTMENT = Department::where('organization_name','LIKE',"%{$request->search}%")->pluck('id');

        if($CURRENT_USER->role_id==5){
            return view('403');
        }
       
        if($CURRENT_USER->role_id == 1 ||$CURRENT_USER->role_id == 2) //ROLE 1 = SUPER ADMIN ; ROLE 2 = STATE NODAL OFFICER
        {
            $grievances = Grievance::with(['department','action','grievanceMovement'])
                ->where('action_id','!=',7)
                ->where('action_id','!=',5)
                ->where('is_seen_by_department',null)

                ->where(function ($query) use($SEARCH,$PROBABLE_DEPARTMENT){
                    $query->when($SEARCH, fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                })->orderBy('created_at','DESC')->paginate($PER_PAGE);
        } 
        
        $fromNotYetOpen=true;
        return Inertia::render('Auth/Grievance/NotYetOpen',[
            'grievances' => $grievances,
            'search'=>$SEARCH,
            'fromNotYetOpen'=>$fromNotYetOpen,
           
        ]);
        
    } 

    public function deleteGrievanceIndex(){
        
        return Inertia::render('Auth/Grievance/Delete',[
            'grievanceDetails'=>false,
        ]);
    }

    public function deleteGrievanceShow(Request $request){
      
        $grievanceRequestForDelete = Grievance::with(['department'])->where('registration_number',$request->registrationNumber)->where('is_transfer','!=',1)->first();
        
        if($grievanceRequestForDelete==null){
            return Inertia::render('Auth/Grievance/Delete',[
                'grievanceDetails'=>false,
                'grievanceRequestForDelete'=>false,
            ]);
        }else{
            return Inertia::render('Auth/Grievance/Delete',[
                'grievanceDetails'=>true,
                'grievanceRequestForDelete'=> $grievanceRequestForDelete,
            ]);
        }
    }

    public function deleteGrievanceDestroy(Request $request){
        $deleteGrievance = Grievance::where('registration_number',$request->registrationNumber)->delete();
       

        return to_route('officer.deleteGrievance')->with('message','Grievance Registration Number: '.$request->registrationNumber.' is deleted successfully!' );

    }
}
