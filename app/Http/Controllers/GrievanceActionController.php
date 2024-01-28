<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Grievance;
use App\Models\GrievanceMovement;
use App\Models\SubDepartment;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class GrievanceActionController extends Controller
{
    private $DOMAIN_NAME;
    
    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    public function noActionRequired(Request $request){
      
        $validate=$request->validate([
            'remark'=>'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',

        ]);
    
        $user_temp = Grievance::find($request->grievance_id);
        $CURRENT_USER = Auth::user();
        
        $department = Department::find($CURRENT_USER->department_id);
       
        $movement = new GrievanceMovement();
        $movement->grievance_id = $request->grievance_id;
        
        $movement->remark = $request->remark;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->action_taken_by_id = $CURRENT_USER->id;

        $movement->date_of_action = Carbon::now()->toDateTimeString();
        $movement->officer_id = $CURRENT_USER->id;
        $movement->officer_name = $CURRENT_USER->name;
        $movement->officer_designation = $CURRENT_USER->designation;
        $movement->officer_mobile = $CURRENT_USER->mobile;
        $movement->officer_email = $CURRENT_USER->email;
        $movement->is_mark_close = $request->mark_as_closed_for_no_action;

        //if subnodal and cannot close 
        if($CURRENT_USER->role_id==4 && $request->subDepartmentCanCloseCheckBox==false){
            $movement->from_id = $CURRENT_USER->sub_department_id;
            $movement->from_type = SubDepartment::class;
            $movement->to_id = $department->id;
            $movement->to_type = $department->getMorphClass();
            $movement->action_id= 11;//sub nodal hian a close thei loa, mhs no_action a rawn tih khan, a in closed nghal tur a ni na chung in, subnodal a nih avang in no_action pawh ti se, a close direct thei lo, case_can_be_close=false vangin
        }else{
            $movement->from_id = $department->id;
            $movement->from_type = $department->getMorphClass();
            $movement->to_id = $user_temp->user_id;
            $movement->to_type = User::class;
            $movement->action_id= 7;//'closed'
        }
            
        $gm = GrievanceMovement::where('grievance_id',$request->grievance_id)->latest()->first();
       
        if($gm->to_type=="App\\Models\\Department"){
            $movement->case_can_be_close = true;
        }else{
            $movement->case_can_be_close = $gm->case_can_be_close;
        }
        
        $movement->appeal_number = $gm->appeal_number;
        $movement->sub_department_owner = $CURRENT_USER->sub_department_id;
        $movement->save();

        $mGrievance = Grievance::find($request->grievance_id);
        if($CURRENT_USER->role_id==4 && $request->subDepartmentCanCloseCheckBox==false){
            $mGrievance->action_id= 11;//sub nodal hian a close thei loa, mhs no_action a rawn tih khan, a in closed nghal tur a ni na chung in, subnodal a nih avang in no_action pawh ti se, a close direct thei lo, case_can_be_close=false vangin
        }else{
            $mGrievance->action_id= 7;//'closed'; 

            $mGrievance->final_remark = $request->remark;
            $mGrievance->nodal_attachment = $movement->nodal_attachment;
            $mGrievance->date_of_final_remark=Carbon::now()->toDateTimeString();
        }

         //multi-sub dept a forward ciah in hetag tang hian, tuin nge close tih track na
        if($CURRENT_USER->role_id == 4){
            $mGrievance->closed_by_sub_id = array($CURRENT_USER->id);
        }
        $mGrievance->category_id = $request->category!=null?$request->category['value']:null;

        $mGrievance->officer_id = $CURRENT_USER->id;
        $mGrievance->officer_name = $CURRENT_USER->name;
        $mGrievance->officer_designation = $CURRENT_USER->designation;
        $mGrievance->officer_mobile = $CURRENT_USER->mobile;
        $mGrievance->officer_email = $CURRENT_USER->email;

        $mGrievance->is_seen_by_citizen = null;
        $mGrievance->save();

        //TODO:SEND SMS | Sl. 4
        $phone = $mGrievance->applicant_mobile;
        //mizo
        $message = 'Chibai '.$mGrievance->applicant_name.', I grievance Registration No: '.$mGrievance->registration_number.' dawnsawn tawh niin enfiah mek a ni. Action
        dang lak a ngai love. Ka lawm e EGOV-MZ';
        $templateId ='1407170608201398374';
        // $message = 'Hello '.$mGrievance->applicant_name.', we received and reviewed your Grievance Registration No:'.$mGrievance->registration_number.'. No further action is required. Thank you. EGOV-MZ';
        // $templateId ='1407168965995340899';

        $mailDetails = "New Update on Grievance Registration Number: ". (string)$mGrievance->registration_number;
        email($mGrievance->applicant_name, $mGrievance->applicant_email, $mailDetails, "Grievance No Action Required");
        thangteaSMS($phone,$message,$templateId);

        return to_route('officer.dashboard');

    }

    public function officerExamineAtOurLevel(Request $request) {
        $validate=$request->validate([
            'remark' => 'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',
        ]);
        //ADD TO THE MOVEMENT
        //grievance_actions AH HIAN ENG CHIN NGE DAH NGAI ANG AW
        $CURRENT_USER = Auth::user();
        $departmentName = Department::find($CURRENT_USER->department_id);
        $mGrievance = Grievance::find($request->grievance_id);
        $departmentNodalOfficer = User::where('role_id',3)->where('department_id',$departmentName->id)->get();

        $movement = new GrievanceMovement();
        $movement->grievance_id = $request->grievance_id; 
        $movement->from_id =  $departmentName->id;
        $movement->from_type = $departmentName->getMorphClass();
        $movement->to_id = $mGrievance->user_id;
        $movement->to_type = User::class;

        if($CURRENT_USER->role_id==4){

            //IF THIS FUNCTION IS TRIGGER BY SUBDEPARTMENT
            $subDepartmentName = SubDepartment::find($CURRENT_USER->sub_department_id);
            $movement->from_id =   $subDepartmentName->id;
            $movement->from_type = $subDepartmentName->getMorphClass();
            //MOVE TO PARENT DEPARTMENT
            $movement->to_id = $departmentName->id;
            $movement->to_type = $departmentName->getMorphClass();
            $movement->is_mark_close = $request->mark_as_closed_for_examine;

            //TODO:SEND SMS | Sl. 5 | FOR OFFICER
            if(!$departmentNodalOfficer->isEmpty()){
                
                //CREATE ARRAY OF NAMES AND MOBILE
                $nameArray=[];
                $mobileArray=[];
                $emailArray=[];
                foreach($departmentNodalOfficer as $user) {
                    $nameArray[]=$user->name;
                    $mobileArray[]=$user->mobile;
                    $emailArray[]=$user->email;
                }     

                //TODO: NOTIFICATION FOR OFFICER
                $transferFrom_forEmail = $CURRENT_USER->name .' '.$CURRENT_USER->designation.', '.$subDepartmentName->organization_name;
                $transferFrom_forSms = $subDepartmentName->organization_name;

                $phone = $mobileArray;
                $message = 'Grievance Registration No:'.$mGrievance->registration_number.' a lo thleng. Grievance hi '.$transferFrom_forSms.' hnen atang a rawn transfer a ni. Grievance chingfel turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
                $templateId ='1407170608213280113';
                // $message = 'You have received Grievance Registration No:'.$mGrievance->registration_number.' transferred from '.$transferFrom_forSms.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
                // $templateId ='1407168966016907916';

                email($nameArray, $emailArray, $request->grievance,"Grievance Update from ".$transferFrom_forEmail);
                thangteaSMS($phone,$message,$templateId);

            }
           

            if($request->mark_as_closed_for_examine==true){
                $movement->action_id = 13;
            }else{
                $movement->action_id = 12;
            }
            $movement->sub_department_owner = $CURRENT_USER->sub_department_id;
        }else{
            $movement->action_id = $request->action['value'];
        }

        $movement->remark = $request->remark;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->action_taken_by_id = $CURRENT_USER->id;

        $movement->date_of_action = Carbon::now()->toDateTimeString();

        $gm = GrievanceMovement::where('grievance_id',$request->grievance_id)->latest()->first();
        
        if($gm->to_type=="App\\Models\\Department" && $request->mark_as_closed_for_examine==true){
            $movement->case_can_be_close = true;
        }else{
            $movement->case_can_be_close = $gm->case_can_be_close;
        }
        
        $movement->appeal_number = $gm->appeal_number;

        if($request['files']!=null){
            
            $data=[];
            foreach($request['files'] as $file){
                $extension = $file->getClientOriginalExtension();
                $name = "NODAL".time().rand(100,999).".".$extension;
                $file->move(storage_path('app/public').'/files/', $name);
                $data[]=$name;
            }
            $movement->nodal_attachment = implode(",",$data);
        }
        $movement->officer_id = $CURRENT_USER->id;
        $movement->officer_name = $CURRENT_USER->name;
        $movement->officer_designation = $CURRENT_USER->designation;
        $movement->officer_mobile = $CURRENT_USER->mobile;
        $movement->officer_email = $CURRENT_USER->email;
        $movement->save();

        if($request->mark_as_closed_for_examine==true || $request->action['value']==11){
           // $mGrievance->action_id = 13;

            //multi-sub dept a forward ciah in hetag tang hian, tuin nge close tih track na
            if($CURRENT_USER->role_id == 4){
                $mGrievance->closed_by_sub_id = array($CURRENT_USER->id);
            }
        }else{
            $mGrievance->action_id = $request->action['value'];
        }
        
        $mGrievance->category_id = $request->category!=null?$request->category['value']:null;
        $mGrievance->is_seen_by_citizen = null;
        $mGrievance->save();

        //TODO:SEND SMS | Sl. 5 | FOR CITIZEN
        $phone = $mGrievance->applicant_mobile; 
        $message = 'Chibai '.$mGrievance->applicant_name.', I Grievance Registration No:'.$mGrievance->registration_number.' process mek a ni.I grievance thehluh kal zel dan enturin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
        $templateId ='1407170608203994678';

        // $message = 'Hello '.$mGrievance->applicant_name.', your Grievance Registration No:'.$mGrievance->registration_number.' is being processed. We appreciate your patience. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for more updates. EGOV-MZ.';
        // $templateId ='1407168966002821431';
        
        $mailDetails = "New Update on Grievance Registration Number: ". (string)$mGrievance->registration_number;
        email($mGrievance->applicant_name, $mGrievance->applicant_email, $mailDetails, "Update on Grievance Submission");
        thangteaSMS($phone,$message,$templateId);

        return to_route('officer.dashboard');

    }

    public function takeUpWithSubDepartment(Request $request) {

        $validate=$request->validate([
            'remark'=>'required',
            'subDepartment'=>'required',
            'maximumDaysDefine' => 'required'

        ]);
        $CURRENT_USER = Auth::user();
        $department = Department::find($CURRENT_USER->department_id);

        $subPhones=[];
        $noSubDepartment=array();

        foreach($request->subDepartment as $index=>$subDepartment){
            //CHECK IF SUB OFFICER IS PRESENT, ACTION DONE BY NODAL OFFICE ROLE_ID = 3
            if($CURRENT_USER->role_id==3){
                $isUserPresent = User::where('department_id',$CURRENT_USER->department_id)
                                ->where('sub_department_id',$subDepartment['value'])
                                ->where('active',true)->first();

                if($isUserPresent==null){

                    $noOfficer = SubDepartment::find($subDepartment['value']);
                    $noSubDepartment[]= $noOfficer->organization_name;

                }
            }
        }
       
        if($noSubDepartment!=null) {
            return redirect()->back()->with('message','There is no officer in the selected office:<b> '. implode(", ",$noSubDepartment) .' </b>. Please create one "Users > Department User".');

        } 

        foreach($request->subDepartment as $index=>$subDepartment){
            
            $movement = new GrievanceMovement();
            $movement->grievance_id = $request->grievance_id;
            $movement->action_id = $request->action['value'];

            //$movement->from = $departmentName->organization_name;
            $movement->from_id = $department->id;
            $movement->from_type = $department->getMorphClass();

            //$movement->to = $subDepartment['value'];
            $movement->to_id = $subDepartment['value'];
            $movement->to_type = SubDepartment::class;

            $movement->remark = $request->remark;
            $movement->action_taken_by = $CURRENT_USER->name;
            $movement->action_taken_by_id = $CURRENT_USER->id;

            $movement->case_can_be_close = $request->subDepartmentCanCloseCheckBox;
            $movement->date_of_action = Carbon::now()->toDateTimeString();

            $movement->officer_id = $CURRENT_USER->id;
            $movement->officer_name = $CURRENT_USER->name;
            $movement->officer_designation = $CURRENT_USER->designation;
            $movement->officer_mobile = $CURRENT_USER->mobile;
            $movement->officer_email = $CURRENT_USER->email;

            $movement->sub_department_owner = $subDepartment['value'];
            $movement->maximum_days = $request->maximumDaysDefine;

            $movement->save();

            $mGrievance = Grievance::find($request->grievance_id);
            if($request->subDepartmentCanCloseCheckBox == true){
                $mGrievance->action_id = 10; //SUBORGANIZATION CAN CLOSED
                $mGrievance->sub_organization_can_close_case = true; //SUBORGANIZATION CAN CLOSED

            }else{
                $mGrievance->action_id= $request->action['value'];
                
            }
            $mGrievance->is_seen_by_citizen = null;
            $mGrievance->save(); 

            $mUser = User::where('department_id',$department->id)->where('sub_department_id',$subDepartment['value'])->first();
            $subPhones[$index] = $mUser->mobile;

            GrievanceMovement::where('grievance_id',$request->grievance_id)
            ->where('sub_department_owner', $subDepartment['value'])
            ->where('is_mark_close',true)->update(["is_mark_close"=>false]);
        }
        $grievanceTemp = Grievance::find($request->grievance_id);
        if($request->subDepartmentCanCloseCheckBox){
            //TODO:SEND SMS | Sl. 6
            $phone = $subPhones;
            $grievance = Grievance::find($request->grievance_id);
            $message = 'Grievance Registration No:'.$grievanceTemp->registration_number.' a lo thleng.  Grievance h '.$CURRENT_USER->name.', '.$CURRENT_USER->designation??''.' hnen atanga rawn transfer a ni. Grievance chingfel turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608209319780';
            // $message = 'You have received Grievance Registration No:'.$grievanceTemp->registration_number.' transferred from '.$CURRENT_USER->name.', '.$CURRENT_USER->designation??''.'.You are required to close the grievance. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
            // $templateId ='1407168966010791546';

        }else{
            //TODO:SEND SMS | Sl. 7
            $phone = $subPhones;
            $message = 'Grievance Registration No:'.$grievanceTemp->registration_number.' a lo thleng.  Grievance hi '.$CURRENT_USER->name.' hnen atang a rawn transfer a ni. Grievance chingfel turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608213280113';
            // $message = 'You have received Grievance Registration No:'.$grievanceTemp->registration_number.' transferred from '.$CURRENT_USER->name.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
            // $templateId ='1407168966016907916';
        }
        $mailDetails ="Grievance Registration Number: " . $mGrievance->registration_number." has been moved to Sub Office.";

        email($mGrievance->applicant_name, $mGrievance->applicant_email, $mailDetails, "Grievance moved to Sub Office");
        thangteaSMS($phone,$message,$templateId);

        return redirect()->route('officer.dashboard')->with('message','');
    }

    public function caseDisposeOf(Request $request) {
        
        $validate=$request->validate([
            'remark'=>'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',
        ]); 

        $CURRENT_USER = Auth::user();
        
        if($CURRENT_USER->sub_department_id == null){
            //OFFICER IS FROM PARENT DEPARTMENT
            $department = Department::find($CURRENT_USER->department_id);
            
        }else{
            //OFFICER IS FROM SUB DEPARTMENT
            $department = SubDepartment::find($CURRENT_USER->sub_department_id);
        }
    
        $movement = new GrievanceMovement();
        $movement->grievance_id = $request->grievance_id;
        $movement->action_id = $request->action['value'];

        //$movement->from = $departmentName->organization_name;
        $movement->from_id = $department->id;
        $movement->from_type = $department->getMorphClass();

        //$movement->to = "YOU";
        $movement->to_id = $movement->grievance->user_id;
        $movement->to_type = User::class;

        $movement->remark = $request->remark;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->action_taken_by_id = $CURRENT_USER->id;

        $movement->date_of_action = Carbon::now()->toDateTimeString();
        $movement->action_id= 7;//closed
        
        $data=[];
        if($request['files']!=null){
            foreach($request['files'] as $file){
                $extension = $file->getClientOriginalExtension();
                $name = "NODAL".time().rand(100,999).".".$extension;
                $file->move(storage_path('app/public').'/files/', $name);
                $data[]=$name;
            }
            $movement->nodal_attachment = implode(",",$data);
        }

        $movement->officer_id = $CURRENT_USER->id;
        $movement->officer_name = $CURRENT_USER->name;
        $movement->officer_designation = $CURRENT_USER->designation;
        $movement->officer_mobile = $CURRENT_USER->mobile;
        $movement->officer_email = $CURRENT_USER->email;
        
        $gm = GrievanceMovement::where('grievance_id',$request->grievance_id)->latest()->first();
        $movement->appeal_number = $gm->appeal_number;

        if($gm->to_type=="App\\Models\\Department"){
            $movement->case_can_be_close = true;
        }else{
            $movement->case_can_be_close = $gm->case_can_be_close;
        }

        $movement->save();
        //TODO: SENT SMS

        $mGrievance = Grievance::find($request->grievance_id);

        $mGrievance->action_id= 7;//'closed'; 
        if(!$mGrievance->is_appeal){
            $mGrievance->final_remark = $request->remark;
            $mGrievance->nodal_attachment = $movement->nodal_attachment;
            $mGrievance->date_of_final_remark=Carbon::now()->toDateTimeString();
            $mGrievance->category_id = $request->category!=null?$request->category['value']:null;
            if($request['files']!=null){
                $mGrievance->nodal_attachment = implode(",",$data);
            }
            $mGrievance->officer_id = $CURRENT_USER->id;
            $mGrievance->officer_name = $CURRENT_USER->name;
            $mGrievance->officer_designation = $CURRENT_USER->designation;
            $mGrievance->officer_mobile = $CURRENT_USER->mobile;
            $mGrievance->officer_email = $CURRENT_USER->email;
        }
        
        $mGrievance->is_seen_by_citizen = null;     

        $mGrievance->save();

        //TODO:SEND SMS | Sl. 8
        $phone1 = $mGrievance->applicant_mobile;
        $message1 = 'Chibai '.$mGrievance->applicant_name.', I Grievance Registration No: '.$mGrievance->registration_number.' chhanna a lo chhuak a, chipchiar zawk a I en duh chuan '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
        $templateId1 ='1407170608216481350';
        // $message1 = 'Hello '.$mGrievance->applicant_name.', we have responded to your Grievance Registration No:'.$mGrievance->registration_number.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for more details. EGOV-MZ';
        // $templateId1 ='1407168966026896717';
        $mailDetails = "Grievance Registration Number: " .$mGrievance->registration_number." has been disposed. ";
        email($mGrievance->applicant_name, $mGrievance->applicant_email, $mailDetails, "Grievance No Action Required");

        //TODO:SEND SMS | Sl. 9
        $phone2 = $CURRENT_USER->mobile;
        $message2 = ' '.$mGrievance->officer_name.'in Grievance Registration No:'.$mGrievance->registration_number.' a chingfel tawh e. EGOV-MZ';
        $templateId2 = '1407170608219857039';
        // $message2 = 'Grievance Registration No:'.$mGrievance->registration_number.' closed successfully by '.$mGrievance->officer_name.'. EGOV-MZ';
        // $templateId2 ='1407168966035386892';

        thangteaSMS($phone1,$message1,$templateId1);
        thangteaSMS($phone2,$message2,$templateId2);

        return to_route('officer.dashboard');
    }

    public function transferToAnotherDepartment(Request $request){

        $validate=$request->validate([
            'remark'=>'required',
        ]);

        $user = User::where('department_id',$request->department['value'])->where('active',true)->first();
        $stateNodal = User::where('role_id',2)->pluck('email')->toArray();

        if($user==null){
            return redirect()->back()->with('message','No Department Nodal Officer in the selected department/I department thlan ah hian Department Nodal Officer an awm rih lo. Please contact State Nodal Officer: ' . implode(',',$stateNodal));    
        }

        $CURRENT_USER = Auth::user();
        $department = Department::find($CURRENT_USER->department_id);

        $movement = new GrievanceMovement();
        $movement->grievance_id = $request->grievance_id;
        $movement->action_id = $request->action['value'];

        //$movement->from = $department->organization_name;
        $movement->from_id = $department->id;
        $movement->from_type = $department->getMorphClass();

        //$movement->to = $request->department['value'];
        $movement->to_id = $request->department['value'];
        $movement->to_type = Department::class;

        $movement->remark = $request->remark;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->action_taken_by_id = $CURRENT_USER->id;

        $movement->date_of_action = Carbon::now()->toDateTimeString();

        $movement->officer_id = $CURRENT_USER->id;
        $movement->officer_name = $CURRENT_USER->name;
        $movement->officer_designation = $CURRENT_USER->designation;
        $movement->officer_mobile = $CURRENT_USER->mobile;
        $movement->officer_email = $CURRENT_USER->email;

        $movement->save();
        //TODO: SENT SMS

        $oldGrievance = Grievance::find($request->grievance_id);
        $oldGrievance->action_id=  $request->action['value'];
        $oldGrievance->is_transfer = true;
        $oldGrievance->save();

        //NOW SENT TO THE OTHER DEPARMENT
        
        $newGrievanceTransfer = new Grievance();
        $newGrievanceTransfer->action_id = 9;//GRIEVANCE SUBMISSION
        $newGrievanceTransfer->grievance_description = $oldGrievance->grievance_description;
        $newGrievanceTransfer->grievance_attachment = $oldGrievance->grievance_attachment;
        $newGrievanceTransfer->department_id = $request->department['value'];
        $newGrievanceTransfer->user_id = $oldGrievance->user_id;
        $newGrievanceTransfer->applicant_name = $oldGrievance->applicant_name;
        $newGrievanceTransfer->applicant_mobile= $oldGrievance->applicant_mobile;
        $newGrievanceTransfer->applicant_email = $oldGrievance->applicant_email;
        $newGrievanceTransfer->registration_number = $oldGrievance->registration_number;//THIS COULD BE APPEND WITH DEPT NAME ETC
        $newGrievanceTransfer->date_of_receipt = Carbon::now()->toDateTimeString();
        $newGrievanceTransfer->applicant_address = $oldGrievance->applicant_address;

        $newGrievanceTransfer->is_appeal = false;
        $newGrievanceTransfer->is_transfer = false;
        $newGrievanceTransfer->is_duplicate = true;

        $newGrievanceTransfer->is_seen_by_citizen = null;

        $newGrievanceTransfer->save();

        //DUPLICATE ALL THE MOVEMENT
        $grievanceMovementForDuplicate = GrievanceMovement::where('grievance_id',$request->grievance_id)->get();
        foreach($grievanceMovementForDuplicate as $gmRow)
        {
            $movement = new GrievanceMovement();
            $movement->grievance_id = $newGrievanceTransfer->id;
            $movement->action_id = $gmRow->action_id;
            $movement->officer_id = $gmRow->officer_id;
            $movement->officer_name = $gmRow->officer_name;
            $movement->officer_designation = $gmRow->officer_designation;
            $movement->officer_mobile = $gmRow->officer_mobile;
            $movement->officer_email = $gmRow->officer_email;
            $movement->from_id = $gmRow->from_id;
            $movement->from_type = $gmRow->from_type;
            $movement->to_id = $gmRow->to_id;
            $movement->to_type =  $gmRow->to_type;
            $movement->remark = $gmRow->remark;
            $movement->action_taken_by = $gmRow->action_taken_by;
            $movement->action_taken_by_id = $gmRow->action_taken_by_id;
            $movement->date_of_action =  $gmRow->date_of_action;
            $movement->is_duplicate =  true;
            //$movement->case_can_be_close =  $gmRow->case_can_be_close;
            $movement->save();
        }

        //TODO:SEND SMS | Sl. 10
        $mTempUser = User::where('role_id',3)->where('department_id',$request->department['value'])->first();
        $phone1 = $mTempUser->mobile;
        $oldDepartment = Department::find($oldGrievance->department_id);
        $message1 = 'Grievance thar '.$oldDepartment->organization_name.' hnen atangin I dawng a. Tih tur tul ti turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
        $templateId1 ='1407170608223484264';
        // $message1 = 'New Grievance has been transferred from '.$oldDepartment->organization_name.'. Please check '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
        // $templateId1 ='1407168966039986281';
        $emailDetails = $oldGrievance->grievance_description . " Grievance Registration Number: " . $oldGrievance->registration_number;
        email($mTempUser->name, $mTempUser->email,$emailDetails, "New Grievance transferred from another department");
        // email($mTempUser->name, $mTempUser->email, $oldGrievance->grievance_description + " Grievance Registration Number: "+ $oldGrievance->registration_number, "New Grievance transferred from another department");
        //TODO:SEND SMS | Sl. 11 

        $newDepartment = Department::find($newGrievanceTransfer->department_id);
        $phone2 = $CURRENT_USER->mobile;

        $message2 = 'Grievance Registration No:'.$oldGrievance->registration_number.' hi '.$newDepartment->organization_name.' hnenah a in thawn fel e. EGOV-MZ';
        $templateId2 ='1407170608227684807';

        // $message2 = 'Grievance Registration No:'.$oldGrievance->registration_number.' has been transferred successfully to '.$newDepartment->organization_name.'. EGOV-MZ';
        // $templateId2 ='1407168966044966123';
        $mailDetails = $oldGrievance->grievance_description . " Grievance Registration Number: " . $oldGrievance->registration_number;
        email($CURRENT_USER->name, $CURRENT_USER->email,  $mailDetails, "Transfered success");

        //TODO:SEND SMS | Sl. 12
        $phone3 = $oldGrievance->applicant_mobile;

        $message3 = 'Chibai '.$oldGrievance->applicant_name.', I Grievance Registration No:'.$oldGrievance->registration_number.' chu '.$newDepartment->organization_name.' hnenah a in thawn fel e. Tih tur tul ti tur in '.$this->DOMAIN_NAME.'.mizoram.gov.in  ah lit rawh. EGOV-MZ';
        $templateId3 ='1407170608232020886';

        // $message3 = 'Hello '.$oldGrievance->applicant_name.', your Grievance Registration No:'.$oldGrievance->registration_number.' is transferred to '.$newDepartment->organization_name.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
        // $templateId3 ='1407168966049990099';
        $mailDetails =  $oldGrievance->grievance_description . " Grievance Registration Number: ". $oldGrievance->registration_number;
        email($CURRENT_USER->name, $CURRENT_USER->email, $mailDetails, "Transfered success");

        thangteaSMS($phone1,$message1,$templateId1);
        thangteaSMS($phone2,$message2,$templateId2);
        thangteaSMS($phone3,$message3,$templateId3);

        return to_route('officer.dashboard');
    }

    public function moveFromPendingToClosed(Request $request){
        $CURRENT_USER = Auth::user();
        
        if($CURRENT_USER->role_id==4){
            
            $gm = GrievanceMovement::where('grievance_id',$request->grievance_id)
                ->where('sub_department_owner',$CURRENT_USER->sub_department_id)->get();
            
           
            foreach($gm as $g){
                $g->is_mark_close=true;
                $g->save();
            }
            
            
    
            return to_route('officer.dashboard');
        
        }else{

        }
        

    }
}
