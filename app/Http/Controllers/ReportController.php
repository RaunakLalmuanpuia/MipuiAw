<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Category;
use App\Models\Department;
use App\Models\Grievance;
use App\Models\GrievanceMovement;
use App\Models\Quote;
use App\Models\SubDepartment;
use PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use stdClass;

use function Psy\debug;

class ReportController extends Controller
{
    public function departmentList(Request $request){
        
        $departments = Department::all();
        $myDepartmentCount = collect();
       if( $request->rangeSelect){
        //DATE RANGE IS SELECTED
        Log::debug($request->rangeSelect);

        $startDate = Carbon::createFromFormat('d/m/Y',$request->rangeSelect['from'])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $request->rangeSelect['to'])->endOfDay();

        foreach($departments as $d){
            $departmentCount = Grievance::where('department_id',$d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            
            $grievance_not_yet_process = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();

            $grievance_processing = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $tempObj = new stdClass();
            $tempObj->id = $d->id;
            $tempObj->organization_name = $d->organization_name;
            $tempObj->grievance_received = $departmentCount;
            $tempObj->grievance_closed = $grievance_closed;
            $tempObj->grievance_not_yet_process = $grievance_not_yet_process;
            $tempObj->grievance_processing = $grievance_processing;

            $myDepartmentCount->push($tempObj);
        }

       }else{
        //ALL RANGE
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
                            ->where('is_seen_by_department',null)
                            ->count();

            $grievance_processing = Grievance::where('department_id', $d->id)
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $tempObj = new stdClass();
            $tempObj->id = $d->id;
            $tempObj->organization_name = $d->organization_name;
            $tempObj->grievance_received = $departmentCount;
            $tempObj->grievance_closed = $grievance_closed;
            $tempObj->grievance_not_yet_process = $grievance_not_yet_process;
            $tempObj->grievance_processing = $grievance_processing;

            $myDepartmentCount->push($tempObj);
        }

       }

        return Inertia::render('Auth/Report/AllDepartments',[
            'myDepartmentCount'=> $myDepartmentCount,
            'rangeSelect'=>$request->rangeSelect,
        ]);
    }

    public function singleDepartment(Request $request, $departmentId){
     
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10; 

        $grievances = Grievance::where('is_transfer',false)
                ->where('department_id',$departmentId)
                ->where(function($query) use($SEARCH){
                    $query->when($SEARCH, fn( $builder)=>$builder)
                        ->where('applicant_name','LIKE',"%$SEARCH%")
                        ->orWhere('applicant_mobile','LIKE',"%$SEARCH%")
                        ->orWhere('registration_number','LIKE',"%$SEARCH%");
                })->latest()->paginate($PER_PAGE);
      
        return Inertia::render('Auth/Report/SingleDepartment',[
            'grievances' => $grievances,
            'search' => $SEARCH,
            'departmentId' => $departmentId,
        ]);
    }

    public function showGrievance($grievanceId){

        $CURRENT_USER = Auth::user();

        $grievance = Grievance::with(['department','user','grievanceMovement.action','action','grievanceMovement'])->where('id',$grievanceId)->first();

        $mUserFiles = '';
        if($grievance->grievance_attachment != null){
            $mUserFiles = explode(",",$grievance->grievance_attachment);
        }

        $mNodalFiles = '';
        if($grievance->nodal_attachment != null){
            $mNodalFiles = explode(",",$grievance->nodal_attachment);
        }

        $subDepartment = SubDepartment::where('department_id',$grievance->department_id)->select('id as value','organization_name as label')->orderBy('organization_name','ASC')->get();
        
        $action = Action::where('visible',true)->select('id as value','label as label')->get();
         
        $department = Department::select('id as value','organization_name as label')->whereNot('id',$CURRENT_USER->department_id)->orderBy('organization_name','ASC')->get();

        if($CURRENT_USER->role_id==1){
            $grievanceCategory = Category::select('id as value','name as label')->get();
        }else{
            $grievanceCategory = Category::where('department_id',$CURRENT_USER->department_id)->select('id as value','name as label')->get();
        }

        $case = new stdClass();

        foreach($grievance->grievanceMovement as $movement){
             if($movement->action_id==7 && $movement->case_can_be_close==true){//7=CLOSED
           // if($movement->action_id==7){//7=CLOSED

                $case->status=true;
                $case->remark=$movement->remark;
                $case->date_of_action = $movement->date_of_action;
            }
        }

        if($CURRENT_USER->role_id==4){//DEPARTMENT SUBORGANIZATION NODAL
            
            if($grievance->action_id==3 || $grievance->action_id==10 || $grievance->action_id==12){//TRANSFER FROM PARENT DEPARTMENT
                $case->forOurSubOrganization=true;
                if($grievance->action_id==10){ //SUBORGANIZATION CAN CLOSE
                    //$action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','5')->select('id as value','label as label')->get(); 
                    $action = Action::whereIn('id',[11,12,4])->select('id as value','label as label')->get(); 
                }else{
                    // $action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','4')->where('id','!=','5')->select('id as value','label as label')->get(); 
                    $action = Action::whereIn('id',[11,12])->select('id as value','label as label')->get(); 
                }
            }

            $mMovement = GrievanceMovement::where('grievance_id',$grievanceId)->latest()->first();
            
            if($mMovement->case_can_be_close == 1){
                $action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','5')->select('id as value','label as label')->get(); 
            }
        }

        $gm = GrievanceMovement::where('grievance_id',$grievanceId)->latest()->first();
        
        if($gm->case_can_be_close==true){
            if($CURRENT_USER->role_id==3 && $gm->action_id==10)
                $showAction = false;
            else $showAction = true;
        }else{
            $showAction = true;
        }

        if($CURRENT_USER->role_id==4 && $gm->action_id == 13){
            $showAction = false;
        }

        if($grievance->is_appeal){
            $gm = GrievanceMovement::where('grievance_id', $grievanceId )->where('action_id', 6)->first();
            $grievance->appealQuestion = $gm->remark;
            $action = Action::where('visible',true)->whereIn('id',[2,4])->select('id as value','label as label')->get(); 

        }

        if($CURRENT_USER->role_id==4 && $grievance->action_id==13){
            $isMarkedClosedBySub = true;
        }else{
            $isMarkedClosedBySub = false;
        }

        $randomQuote = Quote::inRandomOrder()->first();
        $EDITING_HOURS = config('app.EDITING_HOURS');

        return Inertia::render('Auth/Grievance/Show',[
            'grievance' => $grievance,
            'action' => $action,
            'subDepartment' => $subDepartment,
            'case' => $case,
            'department' => $department,
            'grievanceCategory'=> $grievanceCategory,
            'currentRole' => $CURRENT_USER->role_id,
            'mUserFiles'=> $mUserFiles,
            'mNodalFiles'=> $mNodalFiles,
            'showAction' => false,
            'isMarkedClosedBySub' => $isMarkedClosedBySub,
            'fromReport' => true,

            'answerEdit' => false,
            'EDITING_HOURS' => $EDITING_HOURS,
            'from_closed_page'=>false,
            'randomQuote' => $randomQuote,
            'answerEditByAppellate' => false,

        ]);

        return Inertia::render('Auth/Report/',[

        ]);
    }

    public function printAllReport(Request $request){
    
        $departments = Department::all();
        $myDepartmentCount = collect();

        if( $request->query('from') ){

        //DATE RANGE IS SELECTED
        Log::debug($request->rangeSelect);
        $startDate = Carbon::createFromFormat('d/m/Y',$request->query('from'))->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $request->query('to'))->endOfDay();
        foreach($departments as $d){
            $departmentCount = Grievance::where('department_id',$d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $d->id)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $tempObj = new stdClass();
            $tempObj->id = $d->id;
            $tempObj->organization_name = $d->organization_name;
            $tempObj->grievance_received = $departmentCount;
            $tempObj->grievance_closed = $grievance_closed;
            $tempObj->grievance_not_yet_process = $grievance_not_yet_process;
            $tempObj->grievance_processing = $grievance_processing;
             
            $myDepartmentCount->push($tempObj);
        }  
        $range = $request->query('from') .' - '.$request->query('to');

       }else{
        //ALL RANGE
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
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $d->id)
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $tempObj = new stdClass();
            $tempObj->id = $d->id;
            $tempObj->organization_name = $d->organization_name;
            $tempObj->grievance_received = $departmentCount;
            $tempObj->grievance_closed = $grievance_closed;
            $tempObj->grievance_not_yet_process = $grievance_not_yet_process;
            $tempObj->grievance_processing = $grievance_processing;

            $myDepartmentCount->push($tempObj);
        }
        $range = 'ALL';

       }

       $now = Carbon::now()->format('d M, Y h:i a');

        $allReportPdf = PDF::loadView('print/all-report', 
            compact(['myDepartmentCount','range','now']));

        $allReportPdf->setPaper('A4');
        $fileName="";
        try{
            $fileName=Carbon::now();
        }catch(Exception $e){
            $fileName='report';
        }
        return $allReportPdf->download($fileName.'.pdf');
    }

    
    public function printSingleDepartment(Request $request,$departmentId){


        $department = Department::find($departmentId);
        $myDepartmentCount = collect();

        $now = Carbon::now()->format('d M, Y h:i a');

        if( $request->query('from') ){

            //DATE RANGE IS SELECTED
            $startDate = Carbon::createFromFormat('d/m/Y',$request->query('from'))->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $request->query('to'))->endOfDay();
         
            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $departmentId;
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range =$request->query('from') .' - '.$request->query('to');
            
            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
            
       }else{
        //ALL RANGE
         
            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            //->whereNotIn('action_id',[6,8,9])
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();
            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $request->query('departmentId');
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range = 'ALL';

            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
       }


        $allReportPdf = PDF::loadView('print/single-report', 
            compact(['myDepartmentCount','now']));

        $allReportPdf->setPaper('A4');
        $fileName="";
        try{
            $fileName=Carbon::now();
        }catch(Exception $e){
            $fileName='report';
        }
        return $allReportPdf->download($fileName.'.pdf');
       
    }

    public function departmentReport(Request $request){
  
        $CURRENT_USER=Auth::user();
        
        if($CURRENT_USER->role_id !=3 )
            return exit;

        $departmentId = $CURRENT_USER->department_id;
        $department = Department::find($departmentId);
        $myDepartmentCount = collect();

        $now = Carbon::now()->format('d M, Y h:i a');
        
        if( $request->query('rangeSelect') ){
            
            //DATE RANGE IS SELECTED
            $startDate = Carbon::createFromFormat('d/m/Y',$request->query('rangeSelect')['from'])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $request->query('rangeSelect')['to'])->endOfDay();
         
            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $departmentId;
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range =$request->query('rangeSelect')['from'] .' - '.$request->query('rangeSelect')['to'];
            
            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
            
       }else{
        //ALL RANGE

            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();
            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $request->query('departmentId');
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range = 'ALL';

            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
       }

       if( $request->query('printSelect') ){
            $now = Carbon::now()->format('d M, Y h:i a');

            $allReportPdf = PDF::loadView('print/department-report', 
                compact(['myDepartmentCount','now']));

            $allReportPdf->setPaper('A4');
            $fileName="";
            try{
                $fileName=Carbon::now();
            }catch(Exception $e){
                $fileName='report';
            }
            return $allReportPdf->download($fileName.'.pdf');
       }else{

        return Inertia::render('Auth/Report/DepartmentReport',[
            'myDepartmentCount'=> $myDepartmentCount,
        ]);
       }
    }

    public function departmentReportPrint(Request $request){
        $CURRENT_USER=Auth::user();
        
        if($CURRENT_USER->role_id !=3 )
            return exit;

        $departmentId = $CURRENT_USER->department_id;
        $department = Department::find($departmentId);
        $myDepartmentCount = collect();

        $now = Carbon::now()->format('d M, Y h:i a');
        
        if( $request->query('rangeSelect') ){
            
            //DATE RANGE IS SELECTED
            $startDate = Carbon::createFromFormat('d/m/Y',$request->query('rangeSelect')['from'])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $request->query('rangeSelect')['to'])->endOfDay();
         
            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->whereBetween('created_at',[$startDate, $endDate])
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();

            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $departmentId;
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range =$request->query('rangeSelect')['from'] .' - '.$request->query('rangeSelect')['to'];
            
            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
            
       }else{
        //ALL RANGE

            $departmentCount = Grievance::where('department_id',$departmentId)
                            ->where('is_transfer',false)
                            ->count();
            $grievance_closed = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
            $grievance_not_yet_process = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->where('is_seen_by_department',null)
                            ->count();
            $grievance_processing = Grievance::where('department_id', $departmentId)
                            ->where('is_transfer',false)
                            ->whereNotIn('action_id',[7])
                            ->where('is_seen_by_department','!=',null)
                            ->count();
            $myDepartmentCount = new stdClass();
            $myDepartmentCount->id = $request->query('departmentId');
            $myDepartmentCount->organization_name = $department->organization_name;
            $myDepartmentCount->grievance_received = $departmentCount;
            $myDepartmentCount->grievance_closed = $grievance_closed;
            $myDepartmentCount->grievance_not_yet_process = $grievance_not_yet_process;
            $myDepartmentCount->grievance_processing = $grievance_processing;
            $myDepartmentCount->range = 'ALL';

            if ($departmentCount)
                $myDepartmentCount->closed_percentage = round(($grievance_closed/$departmentCount)*100,2);
            else $myDepartmentCount->closed_percentage = 0;
       }

       
        $now = Carbon::now()->format('d M, Y h:i a');

        $allReportPdf = PDF::loadView('print/department-report', 
            compact(['myDepartmentCount','now']));

        $allReportPdf->setPaper('A4');
        $fileName="";
        try{
            $fileName=Carbon::now();
        }catch(Exception $e){
            $fileName='report';
        }
        return $allReportPdf->download($fileName.'.pdf');
       
    }
}
