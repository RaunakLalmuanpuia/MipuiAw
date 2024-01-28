<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\Department;
use App\Models\Grievance;
use App\Models\GrievanceMovement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppealController extends Controller
{
    public function index(){

        $CURRENT_USER = Auth::user();

        if($CURRENT_USER->role_id==5){

            /*
                RATING 1:POOR, 2:AVERAGE, 3:GOOD, 4: VERY GOOD, 5:EXCELLENT
            */
            $grievances = Grievance::where('user_id',$CURRENT_USER->id)
                ->whereIn('applicant_rating',[1])
                ->whereNot('action_id',6)
                ->where('is_appeal',false)//IS APPEAL HI A GAI BAWK SI, APPEAL TAWH HO LANG LOH NAN

               // ->select('id as value','applicant_address as label','department_id')
                ->with(['department','grievanceMovement'])->get();

            foreach($grievances as $g){
                $g->value=$g->id;
                $g->label=$g->registration_number."-".substr($g->grievance_description,0,15).'...';
            }

          

            return Inertia::render('Citizen/Grievance/Appeal/Create',[
                'grievances'=>$grievances,
            ]);

        }else {

            return view('403');
        }
    }

    public function store(Request $request){
        $validate=$request->validate([
            'reason'=>'required',
            'grievance'=>'required',
        ]);
        
        $CURRENT_USER = Auth::user();

        $user = User::where('department_id',$request->grievance['department_id'])
        ->where('role_id',6)
        ->where('active',true)->first();

        if($user==null){
            $departmentNodal = User::where('role_id',3)
                ->where('department_id',$request->grievance['department_id'])
                ->pluck('email')->toArray() ;

            return redirect()->back()->with('message','No Appellate Officer in the selected department/I department thlan ah hian Appellate Officer an awm rih lo Please Contact: '. implode(",", $departmentNodal));    
        }

        //STORE IN MOVEMENT
        $movement = new GrievanceMovement();
      
        $movement->grievance_id = $request->grievance['value'];   
        $movement->action_id = 6;//6=APPEAL
        
        $movement->from_id = $CURRENT_USER->id;
        $movement->from_type = User::class;

        $movement->to_id = $request->grievance['department_id']; 
        $movement->to_type = Department::class;

        $movement->remark = $request->reason;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->date_of_action = Carbon::now()->toDateTimeString();

        $movement->appeal_number = "APPEAL".rand(111,999).Carbon::now()->timestamp;
        $movement->save();      

        //CHANGE GRIEVANCE STATUS
        $grievance = Grievance::find($request->grievance['value']);
        $grievance->action_id = 6;//"APPEAL";
        $grievance->is_appeal = true;
        $grievance->save();

        return to_route('citizen.dashboard')->with('message','Appeal Submit Successfully');
    }

    public function dashboard(){

        $CURRENT_USER = Auth::user();
        $appealGrievances = Grievance::with(['grievanceMovement','department'])
        ->where('user_id',$CURRENT_USER->id)
        ->where('is_appeal',true)
        ->get();
  
        
        return Inertia::render('Citizen/Grievance/Appeal/Dashboard',[
            'appeals'=>$appealGrievances,
        ]);
    }

    public function appealDetails($grievanceId){
      
        $appeal = Grievance::where('id',$grievanceId)->with(['department','grievanceMovement'])->first();

        $gm = GrievanceMovement::where('grievance_id',$grievanceId)->where('action_id', 6)->first();

        $appealReply = GrievanceMovement::where('grievance_id',$grievanceId)
            ->where('appeal_number','!=',null)->where('action_id',7)->first();
         
        $appeal->appealQuestion = $gm->remark??'';
        $appeal->date_of_action = $gm->date_of_action??'';
        $appeal->appeal_number = $gm->appeal_number??'';
        
        $appeal->appealReply = $appealReply->remark??'';
        $appeal->appealReplyDate = $appealReply->date_of_action??'';

        $appeal->daaAttachment = $appealReply->nodal_attachment??'';
        $appeal->officer_id_daa = $appealReply->officer_id??'';
        $appeal->officer_name_daa = $appealReply->officer_name??'';
        $appeal->officer_designation_daa = $appealReply->officer_designation??'';
        $appeal->officer_mobile_daa = $appealReply->officer_mobile??'';
        $appeal->officer_email_daa = $appealReply->officer_email??'';
         
        return Inertia::render('Citizen/Grievance/Appeal/Show',[
            'appeal'=>$appeal,
        ]);
    }

    public function adminAppealView(){
        $CURRENT_USER = Auth::user();


        $appealGrievances = Grievance::with(['grievanceMovement','department'])
        ->where('department_id',$CURRENT_USER->department_id)
        ->where('is_appeal',true)
        ->get();

        
        return Inertia::render('Auth/Grievance/Appeal/Index',[
            'appeals'=>$appealGrievances,

        ]);
    }

}
