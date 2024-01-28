<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\User;
use App\Models\Department;
use App\Models\Grievance;
use App\Models\HomeText;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use stdClass;

class HomeController extends Controller
{
    public function homeCarousel(Request $request){
       
         
         $carousels = Carousel::where('visible',true)->get();
        $homeText = HomeText::find(1);
        if($homeText==null){
            $homeText['body1']='';
            $homeText['body2']='';
        }
        $range = '';
         switch($request->query('range')){
            case 'year':
                    $departmentCount = Grievance::whereYear('created_at', Carbon::now()->year)
                            ->where('is_transfer',false)
                            ->count();
                    $grievance_closed = Grievance::whereYear('created_at', Carbon::now()->year)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                    $grievance_not_yet_process = Grievance::whereYear('created_at', Carbon::now()->year)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();
                    $grievance_processing = Grievance::whereYear('created_at', Carbon::now()->year)
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();
                    $range = 'Year ('.Carbon::today()->format('Y').')';


            break;

            case 'month': 
                    $departmentCount = Grievance::whereMonth('created_at', Carbon::now()->month)
                            ->where('is_transfer',false)
                            ->count();
                    $grievance_closed = Grievance::whereMonth('created_at', Carbon::now()->month)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                    $grievance_not_yet_process = Grievance::whereMonth('created_at', Carbon::now()->month)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();
                    $grievance_processing = Grievance::whereMonth('created_at', Carbon::now()->month)
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();
                    
                    $range = 'Month ('.Carbon::today()->format('F').')';

            break;

            case 'week': 
                    $departmentCount = Grievance::whereBetween('created_at', [
                                Carbon::now()->startOfWeek(Carbon::SUNDAY),
                                Carbon::now()->endOfWeek(Carbon::SATURDAY),
                            ])
                            ->where('is_transfer',false)
                            ->count();
                    $grievance_closed = Grievance::whereBetween('created_at', [
                                Carbon::now()->startOfWeek(Carbon::SUNDAY),
                                Carbon::now()->endOfWeek(Carbon::SATURDAY),
                            ])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                    $grievance_not_yet_process = Grievance::whereBetween('created_at', [
                                Carbon::now()->startOfWeek(Carbon::SUNDAY),
                                Carbon::now()->endOfWeek(Carbon::SATURDAY),
                            ])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();
                    $grievance_processing = Grievance::whereBetween('created_at', [
                                Carbon::now()->startOfWeek(Carbon::SUNDAY),
                                Carbon::now()->endOfWeek(Carbon::SATURDAY),
                            ])
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();    
                  // $range = 'Week';
                    $range = 'Week ('.Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('d M Y').' - '.
                                    Carbon::now()->endOfWeek(Carbon::SATURDAY)->format('d M Y').')'  ;

            break;

            case 'today': 
                    $departmentCount = Grievance::whereDate('created_at', Carbon::today())
                            ->where('is_transfer',false)
                            ->count();
                    $grievance_closed = Grievance::whereDate('created_at', Carbon::today())
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                    $grievance_not_yet_process = Grievance::whereDate('created_at', Carbon::today())
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();
                    $grievance_processing = Grievance::whereDate('created_at', Carbon::today())
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();

                    $range = 'Today ('.Carbon::today()->format('d M Y').')';
            break;

            case 'all': default: 
                    $departmentCount = Grievance::where('is_transfer',false)
                            ->count();
                    $grievance_closed = Grievance::where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                    $grievance_not_yet_process = Grievance::where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();
                    $grievance_processing = Grievance::where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();

                    $range = 'All';
            break;
        }
        

        $allDepartment = new stdClass();
         
        $allDepartment->grievance_received = $departmentCount;
        $allDepartment->grievance_closed = $grievance_closed;
        $allDepartment->grievance_not_yet_process = $grievance_not_yet_process;
        $allDepartment->grievance_processing = $grievance_processing;
        $allDepartment->range = $range;

 

        return Inertia::render('Landing/Home',[
            'carousels' => $carousels,
            'homeText' => $homeText,
            'allDepartment' => $allDepartment,
            'remember'=>true,
       ]);
    }

    public function departmentStatistics(){
        
        $departments = Department::all();
        $myDepartmentCount = collect();

        foreach($departments as $d){
            $departmentCount = Grievance::where('department_id',$d->id)
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $d->id)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();

            $grievance_not_yet_process = Grievance::where('department_id', $d->id)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[9])
                            ->count();

            $grievance_processing = Grievance::where('department_id', $d->id)
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();

            $tempObj = new stdClass();
            $tempObj->id = $d->id;
            $tempObj->organization_name = $d->organization_name;
            $tempObj->grievance_received = $departmentCount;
            $tempObj->grievance_closed = $grievance_closed;
            $tempObj->grievance_not_yet_process = $grievance_not_yet_process;
            $tempObj->grievance_processing = $grievance_processing;

            if($departmentCount==0){
                $tempObj->percentage_closed = '0%';    
            }else{
                $tempObj->percentage_closed = (100 * round($grievance_closed/$departmentCount,4) ).'%';
            }
            $myDepartmentCount->push($tempObj);
        }

        return Inertia::render('Landing/Department-Statistics',[
            'myDepartmentCount'=> $myDepartmentCount,
        ]);
    }

    public function nodals(){
        //role_id 3 = Department Nodal officer
        $nodals = User::with('department')->where('role_id',3)->orderBy('department_id','asc')->get();
        return Inertia::render('Landing/Nodal',[
            'nodals'=>$nodals
        ]);
        
    }

   
}
