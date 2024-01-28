<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Category;
use App\Models\Department;
use App\Models\Grievance;
use App\Models\GrievanceMovement;
use App\Models\SubDepartment;
use App\Models\MaximumDay;
use App\Models\Quote;
use App\Models\MonthlyCredit;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use stdClass;
use PDF;
use Illuminate\Database\Eloquent\Builder;

class GrievanceController extends Controller
{
    private $DOMAIN_NAME;

    public function __construct() {
        $this->DOMAIN_NAME = env('MY_DOMAIN_NAME');
    } 

    public function index() { }
    public function create() { }
    public function store(Request $request) { } 
    public function show(Grievance $grievance) { }
    public function edit(Grievance $grievance) { }
    public function update(Request $request, Grievance $grievance){ }
    public function destroy(Grievance $grievance){ }
 
    public function grievance1(){

        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $grievanceCount = Grievance::where('user_id',$user->id)
        ->where('is_transfer',0)
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();
        
        $monthlyCredit = MonthlyCredit::first();
        $creditRemains = $monthlyCredit->monthly_limit - $grievanceCount;
        
        if($creditRemains > 0){
        //if(false){
        return Inertia::render('Citizen/Grievance/Submission/CreateStep1',[
                'monthlyLimit' => $monthlyCredit,
                'grievanceCount' => $grievanceCount,
                'creditRemains' =>  $creditRemains, 
            ]);
        }else{
            return Inertia::render('Citizen/Grievance/Submission/CreditLimitExhaust',[
                'monthlyLimit' => $monthlyCredit,
            ]);
        }
        
        
    }

    public function grievance2(Request $request){
        
        $departments = Department::select(['id as value','organization_name as label'])->orderBy('organization_name','ASC')->get();
        $validate = $request->validate([
            'agree' => 'required|in:true',
        ]);

        $users = User::where('role_id', 3)->get(); //TAKE ALL THE DEPARTMENTAL OFFICER

        foreach($departments as $dept){
            
            if($users->contains('department_id',$dept['value'])){//DARK GREEN
                $dept['label']="<span style='color:#18ba20'><b>&#x2219 </b></span>".$dept['label'];
            }else{//RED
                $dept['label']="<span style='color:#ff0000'><b>&#x2219 </b></span>".$dept['label'];

            }    
        }

        return Inertia::render('Citizen/Grievance/Submission/CreateStep2',[
            'agree'=>true,
            'departments'=>$departments,
        ]);
    }
     
    public function grievance3(Request $request){
       
        $validate = $request->validate([
            'department' => 'required',
        ]);
        
        $stateNodal = User::where('role_id',2)->pluck('email')->toArray() ;
        
        $user = User::where('department_id',$request->department['value'])->where('active',true)->first();

        if($user==null){
            return redirect()->back()->with('message','No officer in the selected department/I department thlan ah hian officer an awm rih lo. Please Contact: '. implode(",", $stateNodal));    
        }

        $randomQuote = Quote::inRandomOrder()->first();

        return Inertia::render('Citizen/Grievance/Submission/CreateStep3',[            
            'department'=>$request->department,
            'randomQuote' => $randomQuote,
        ]);
    }

    public function grievanceStore1(Request $request){
  
        //CREATING NEW GRIEVANCE
        $validate=$request->validate([
            'agree' => 'required|in:'.true,
            'grievance'=>'required|max:50000',
            'files.*'  => 'mimes:jpeg,jpg,png,pdf',
        ]);

        $CURRENT_USER = Auth::user();
        $currentTime = Carbon::now()->timestamp;

        $newGrievance = new Grievance();
        $newGrievance->action_id = 9;//GRIEVANCE SUBMISSION

        $newGrievance->grievance_description = $request->grievance;
        $newGrievance->department_id = $request->department_id;

        $newGrievance->user_id = $CURRENT_USER->id;
        $newGrievance->applicant_name = $CURRENT_USER->name;
        $newGrievance->applicant_mobile= $CURRENT_USER->mobile;
        $newGrievance->applicant_email = $CURRENT_USER->email;
        $newGrievance->registration_number = $currentTime;//THIS COULD BE APPEND WITH DEPT NAME ETC
        $newGrievance->date_of_receipt = Carbon::now()->toDateTimeString();
        $newGrievance->applicant_address = $CURRENT_USER->address;
        $newGrievance->applicant_district = $CURRENT_USER->district;

        if($request['files']!=null){
            $data=[];
            foreach($request['files'] as $file){
                
                $extension = $file->getClientOriginalExtension();
                
                $name = "USR".time().rand(100,999).".".$extension;
                $file->move(storage_path('app/public').'/files/', $name);
                $data[]=$name;
            }
            $newGrievance->grievance_attachment = implode(",",$data);
        }
        $newGrievance->is_appeal = false;
        $newGrievance->is_transfer = false;
        $newGrievance->is_duplicate = false;

        $newGrievance->is_seen_by_citizen = Carbon::now()->toDateTimeString();

        $newGrievance->save();

        //TODO:SEND SMS TO OFFICER . Sl 1
        //GET THE OFFICER NUMBER
        
        //THE BELOW CODE ALLOWS ONLY ONE OFFICER IN OFFICE
        //$mOfficer = User::where('department_id',$request->department_id)->where('role_id','3')->first();//GET THE FIRST NODAL OFFICER OF THE DEPARTMENT
        
        //start
        //THE BELOW CODE ALLOWS ONLY MULTIPLE OFFICER IN OFFICE
        $mOfficer = User::where('department_id',$request->department_id)->where('role_id','3')
                    ->select('name','email','mobile')->get();//GET THE FIRST NODAL OFFICER OF THE DEPARTMENT
        if($mOfficer!=null){ 
            //CREATE ARRAY OF NAMES AND MOBILE
            $nameArray=[];
            $mobileArray=[];
            $emailArray=[];
            foreach($mOfficer as $user) {
                $nameArray[]=$user->name;
                $mobileArray[]=$user->mobile;
                $emailArray[]=$user->email;
            }     
            $phone = $mobileArray;
            $message = 'Grievance thar I dawng e. Registration No:'.$currentTime.'. Tih tur tul ti turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608169814576'; 
            // $message = 'New Grievance received. Registration No:'.$currentTime.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in to take necessary action. EGOV-MZ';
            // $templateId ='1407168965966436622';        
            //TODO:SEND SMS TO OFFICER . Sl 1
            //Mizo
             
            thangteaSMS($phone,$message,$templateId);
            email($nameArray, $emailArray, $request->grievance,"New Grievance Received");
             
        }else{  
            //TODO:SEND SMS TO OFFICER . Sl 2
            $department = Department::find($request->department_id);
            $stateNodal = User::where('role_id','2')->first();//GET THE FIRST NODAL OFFICER OF THE DEPARTMENT
            $phone = $stateNodal->mobile??'';
            //Mizo
            $message = 'Grievance hi '.$department->organization_name.' hnenah thawn a ni e. Department i thlan hi register/activate a ni lova. Department create/active tur a hriattir i ni e. Chutiang tih nan '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608175181603';
            // $message = 'Grievance is sent to '.$department->organization_name.'. This Department is not register/active. Please create/activate the department. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
            // $templateId ='1407168965973991232';
            thangteaSMS($phone,$message,$templateId);
        }
        //TODO:SEND SMS TO OFFICER . Sl 3
        $phone = $CURRENT_USER->mobile;
        $message = 'I Grievance Registration No :'.$currentTime.' i thawn fel e. EGOV-MZ';
        $templateId ='1407170608163175906';
        thangteaSMS($phone,$message,$templateId);
        email($CURRENT_USER->name, $CURRENT_USER->email, $message, "New Grievance Created" );
        // end
        
        //1ST MOVEMENT. SAVE TO THE MOVEMENT AS YOU TO DEPT AS FIRST MOVEMENT

        $department= Department::find($request->department_id);

        $movement = new GrievanceMovement();
        $movement->grievance_id = $newGrievance->id;
        $movement->action_id = 8;//RECEIVED THE GRIEVANCE
        $movement->from_id = $CURRENT_USER->id;
        $movement->from_type = User::class;
        $movement->to_id = $department->id;
        $movement->to_type = $department->getMorphClass();
        $movement->remark = $request->grievance;
        $movement->action_taken_by = $CURRENT_USER->name;
        $movement->action_taken_by_id = $CURRENT_USER->id;
        $movement->date_of_action = Carbon::now()->toDateTimeString();
        $movement->case_can_be_close=true;
        $movement->save();      
    
        //THE BELOW CODE ALLOWS ONLY MULTIPLE OFFICER IN OFFICE
        $mOfficer = User::where('department_id',$request->department_id)->where('role_id','3')
                    ->select('name','email','mobile')->get();//GET THE FIRST NODAL OFFICER OF THE DEPARTMENT
        if($mOfficer!=null){
            //CREATE ARRAY OF NAMES AND MOBILE
            $nameArray=[];
            $mobileArray=[];
            $emailArray=[];
            foreach($mOfficer as $user) {
                $nameArray[]=$user->name;
                $mobileArray[]=$user->mobile;
                $emailArray[]=$user->email;
            }     
            $phone = $mobileArray;
            $message = 'Grievance thar I dawng e. Registration No:'.$currentTime.'. Tih tur tul ti turin '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608169814576';
            // $message = 'New Grievance received. Registration No:'.$currentTime.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in to take necessary action. EGOV-MZ';
            // $templateId ='1407168965966436622';
            thangteaSMS($phone,$message,$templateId);
            email($nameArray, $emailArray, $request->grievance,"New Grievance Received");

        }else{
            //TODO:SEND SMS TO OFFICER . Sl 2
            $department = Department::find($request->department_id);
            $stateNodal = User::where('role_id','2')->first();//GET THE FIRST NODAL OFFICER OF THE DEPARTMENT
            $phone = $stateNodal->mobile??'';
            $message = 'Grievance hi '.$department->organization_name.' hnenah thawn a ni e. Department i thlan hi register/activate a ni lova. Department create/active tur a hriattir i ni e. Chutiang tih nan '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608175181603';
            // $message = 'Grievance is sent to '.$department->organization_name.'. This Department is not register/active. Please create/activate the department. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for necessary action. EGOV-MZ';
            // $templateId ='1407168965973991232';
            thangteaSMS($phone,$message,$templateId);
        }
        //TODO:SEND SMS TO OFFICER . Sl 3
        $phone = $CURRENT_USER->mobile;
        $message = 'I Grievance Registration No :'.$currentTime.' i thawn fel e. EGOV-MZ';
        $templateId ='1407170608163175906';
        thangteaSMS($phone,$message,$templateId);
        
        return to_route('citizen.dashboard');
    }

    //CITIZEN SHOW
    public function showGrievance($grievanceId){
        $CURRENT_USER = Auth::user();
   
        //OLD
        $grievance = Grievance::with(['department','user','grievanceMovement.action','action','grievanceMovement'])
        ->where('id',$grievanceId)
        ->first();

        if($CURRENT_USER->id != $grievance->user_id){
            return redirect()->back();
        }

        //"NEW" NOTIFICATION LABEL
        if($CURRENT_USER->role_id==5){
            $grievance->is_seen_by_citizen = Carbon::now()->toDateTimeString();
            $grievance->save();
        }

        $mUserFiles = '';
        if($grievance->grievance_attachment != null){
            $mUserFiles = explode(",",$grievance->grievance_attachment);
        }

        $mNodalFiles = '';
        if($grievance->nodal_attachment != null){
            $mNodalFiles = explode(",",$grievance->nodal_attachment);
        }
        
        $mUser =User::where('id',$CURRENT_USER->id)->first();
         
        if($mUser->role_id==5){
            //CITIZEN
            if($mUser->id == $grievance->user_id){
                //ALLOW

                $case=new stdClass();
                foreach($grievance->grievanceMovement as $movement){
                    if($movement->action_id==7 && $movement->appeal_number==null && $movement->case_can_be_close==true){//7=closed
                        $case->status=true;
                        $case->remark=$movement->remark;
                        $case->date_of_action = $movement->date_of_action;
                    }
                }

                if($grievance->action_id == 7 || $grievance->action_id == 6 || $grievance->is_appeal){
                    $case->status=true;
                    $case->remark=$grievance->final_remark;
                    $case->date_of_action = $grievance->date_of_final_remark;
                }
                
                $hoursDifference = Carbon::parse($grievance->date_of_receipt)->diffInHours(Carbon::now());
                //CITIZEN EDITING HOUR = 1hr
                
                if($hoursDifference < config('app.EDITING_HOURS_FOR_CITIZEN')){
                    $grievance->edit = true;
                }else{
                    $grievance->edit = false;
                }
                
                $EDITING_HOURS_FOR_CITIZEN = config('app.EDITING_HOURS_FOR_CITIZEN');

                if($grievance->grievance_attachment != null){
                    // $grievance->grievance_attachment_array = (object) explode(',',$grievance->grievance_attachment,0);
                    $grievance->grievance_attachment_array = '/path/to/prepopulated-file.txt';
                  
                }

                return Inertia::render('Citizen/Grievance/Show',[
                    'grievance' => $grievance,
                    'case'=>$case,
                    'mUserFiles'=> $mUserFiles,
                    'mNodalFiles'=> $mNodalFiles,
                    'EDITING_HOURS_FOR_CITIZEN' => $EDITING_HOURS_FOR_CITIZEN,
                ]);

            }else{
                //NOT ALLOW
                // 13865
                return "Not Allow";
            }

        }else{
            //NOT CITIZEN
        }
    }

    //CITIZEN
    public function dashboard(Request $request){
        
        $CURRENT_USER = Auth::user();

        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
        $PROBABLE_DEPARTMENT = Department::where('organization_name','LIKE',"%{$request->search}%")->pluck('id');

        $mUser=User::find($CURRENT_USER->id);
        $mUser->last_login=Carbon::now()->toDateTimeString();
        $mUser->save();

        if($CURRENT_USER->role_id == 5){ //CITIZEN
            $grievances= Grievance::latest()->with(['department','grievanceMovement.action','action'])
            ->where('user_id',$CURRENT_USER->id)
            ->where('action_id','!=',5) //5=TRANSFER TO ANOTHER DEPT.
            ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT){
                $query->when($SEARCH,fn(Builder $builder)=> $builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%")
                    ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
            })
            ->orderBy('created_at','DESC')
            //->dd();
            ->paginate($PER_PAGE);
         
            foreach($grievances as $g){
                if($g->grievanceMovement->toArray()!=null){
                    $movement= $g->grievanceMovement->last();
                    if($movement->action_id==7){ //7 = CLOSED_ON
                        $g->closed_on = $movement->date_of_action;
                    }
                }
            }
           
        }else if($CURRENT_USER->role_id == 1 || $CURRENT_USER->role_id == 2){ //ADMIN
            return redirect()->back();
            dd("Department user are not suppose to come here");

        }else if ($CURRENT_USER->role_id == 3 ||$CURRENT_USER->role_id == 4){ //ADMIN
            return redirect()->back();
            dd("Department user are not suppose to come here");
        }

        $total_grievance_received = Grievance::where('user_id',$CURRENT_USER->id)
                ->where('is_transfer',false)
                ->count();
        $total_grievance_closed = Grievance::where('user_id', $CURRENT_USER->id)
                ->where('is_transfer',false)
                ->whereIn('action_id',[7,6])
                ->count();
        $grievance_not_yet_process = Grievance::where('user_id',$CURRENT_USER->id)
                ->where('is_transfer',false)
                ->whereIn('action_id',[9])
                ->count();
        $total_grievance_processing = Grievance::where('user_id',$CURRENT_USER->id)
                ->where('is_transfer',false)
                ->whereNotIn('action_id',[6,8,9])
                ->count();
        $total_grievance_pending = Grievance::where('user_id',$CURRENT_USER->id)
                ->where('is_transfer',false)
                ->whereNotIn('action_id',[6,7])
                ->count();

        $total_sub_organization = 'xx';
  
        $dashboardData = new stdClass();

        $dashboardData->total_grievance_received = $total_grievance_received;
        $dashboardData->total_grievance_closed = $total_grievance_closed;
        $dashboardData->grievance_not_yet_process = $grievance_not_yet_process;
        $dashboardData->total_grievance_processing = $total_grievance_processing;
        $dashboardData->total_grievance_pending = $total_grievance_pending;
        $dashboardData->sub_organization = $total_grievance_processing;
        $dashboardData->total_sub_organization = $total_sub_organization;

        ///dd($dashboardData);
        return Inertia::render('Citizen/Dashboard',[
            'grievances'=>$grievances,
            'dashboardData' =>$dashboardData,
            'search' => $SEARCH,

        ]);
    }

    /*
    NOTE: BELOW IS THE ADMIN CONTROLLER DEUH
    */
    public function OfficerDashboard(Request $request){ 
 
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
        $maximumDaysForDepartmentNodal = MaximumDay::find(1);
        if($CURRENT_USER->role_id == 1 ||$CURRENT_USER->role_id == 2) //ROLE 1 = SUPER ADMIN ; ROLE 2 = STATE NODAL OFFICER
        {
            $grievances = Grievance::with(['department','action','grievanceMovement'])
                ->where('action_id','!=',7)
                ->where('action_id','!=',5)
                ->where(function ($query) use($SEARCH,$PROBABLE_DEPARTMENT){
                    $query->when($SEARCH, fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                })->orderBy('created_at','DESC')->paginate($PER_PAGE);

        }else if($CURRENT_USER->role_id == 3){//ROLE 3 = DEPARTMENT NODAL OFFICER

            $grievances = Grievance::with(['department','action','grievanceMovement'])
                ->where('is_appeal',false)
                ->where('department_id',$CURRENT_USER->department_id)
                ->where('action_id','!=', 7 ) // closed
                ->where('action_id','!=', 5 ) // transferred
                ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT){
                    $query->when($SEARCH,fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                })
                ->orderBy('created_at','DESC')->paginate($PER_PAGE);

            foreach($grievances as $g){
                $g->diff_in_days = Carbon::parse($g->date_of_receipt)->diffInDays(Carbon::now());
            }
            
            
        }else if($CURRENT_USER->role_id == 4){//ROLE 4 = SUB ORGANIZATION NODAL OFFICER
           
            $grievanceMovementClosedId = GrievanceMovement::where('sub_department_owner',$CURRENT_USER->sub_department_id)
                  ->where('is_mark_close',true)
                  ->pluck('grievance_id')->toArray();
            
            
            
            if($grievanceMovementClosedId != NULL) {
                $grievances = Grievance::with(['department','action','grievanceMovement'])
                ->where('department_id',$CURRENT_USER->department_id)
                //->whereIn('action_id',[3,10,12])  //3=take up with sub; 10=transfer to sub org & closed; 12=examine at our level by sub
                ->whereNotIn('id',$grievanceMovementClosedId)
                
                ->whereHas('grievanceMovement', function(Builder $query) use($CURRENT_USER){
                    $query->where('sub_department_owner', $CURRENT_USER->sub_department_id)
                        ->whereIn('action_id',[3,10,12])
                        ->where('is_mark_close',false);
                    ;})

                ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT,$CURRENT_USER){
                    $query->when($SEARCH,fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                    })
                ->orderBy('created_at','DESC')
                ->paginate($PER_PAGE);
                
            }else{
                    
                $grievances = Grievance::with(['department','action','grievanceMovement'])
                    ->where('department_id',$CURRENT_USER->department_id)
                    //->whereNotIn('action_id' ,[1,4,7])  //3=take up with sub; 10=transfer to sub org & closed; 12=examine at our level by sub
                    ->whereHas('grievanceMovement',function(Builder $query) use($CURRENT_USER) {
                            $query->where('sub_department_owner',$CURRENT_USER->sub_department_id)
                                ->whereIn('action_id',[3,10,12])
                                ->where('is_mark_close',false);
                    })
                    ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT,$CURRENT_USER){
                        $query->when($SEARCH,fn(Builder $builder)=> $builder)
                            ->where('grievance_description','like',"%$SEARCH%")
                            ->orWhere('applicant_name','like',"%$SEARCH%")
                            ->orWhere('registration_number','like',"%$SEARCH%")
                            ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                        })
                    ->orderBy('created_at','DESC')
                    ->paginate($PER_PAGE);
                    
            }
            foreach($grievances as $g){
                $g->diff_in_days = Carbon::parse($g->date_of_receipt)->diffInDays(Carbon::now());
            }

        }else if($CURRENT_USER->role_id == 6){//ROLE 6= DEPARTMENTAL APPELLATE OFFICER

            $grievances = Grievance::with(['department','action','grievanceMovement'])
            ->where('department_id',$CURRENT_USER->department_id)
            ->where('is_appeal', true )
            ->where('action_id','!=',7)

            ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%")
                    ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
            })
            ->orderBy('created_at','DESC')->paginate($PER_PAGE);

         

            $tempVar='';
            foreach($grievances as $g){
                foreach($g->grievanceMovement as $gm){
                    if($gm->action_id == 6){
                        $tempVar = $gm->date_of_action;
                        break;
                    }
                }
                $g->date_of_receipt = $tempVar;
            }
        }
  
        // if($CURRENT_USER->role_id==1 || $CURRENT_USER->role_id==2){
        //     $total_grievance_received = Grievance::where('is_transfer',false)
        //                 ->count();
        //     $total_grievance_closed = Grievance::where('is_transfer',false)
        //                 ->whereIn('action_id',[7,6])
        //                 ->count();
        //     $grievance_not_yet_process = Grievance::where('is_transfer',false)
        //                 //->whereIn('action_id',[9])
        //                 ->where('is_seen_by_department',null)
        //                 ->count();
        //     $total_grievance_pending = Grievance::where('is_transfer',false)
        //                 ->whereNotIn('action_id',[6,8,9])
        //                 ->count();
        //     $total_sub_organization = SubDepartment::all()->count();

        //     $total_appeal = Grievance::where('is_appeal',true)->where('is_transfer',false)->count();
            
        // }else{   
        //     $total_grievance_received = Grievance::where('department_id',$CURRENT_USER->department_id)
        //                 ->where('is_transfer',false)
        //                 ->count();
        //     $total_grievance_closed = Grievance::where('department_id', $CURRENT_USER->department_id)
        //                 ->where('is_transfer',false)
        //                 ->whereIn('action_id',[7,6])
        //                 ->count();
        //     $grievance_not_yet_process = Grievance::where('department_id',$CURRENT_USER->department_id)
        //                 ->where('is_transfer',false)
        //                 //->whereIn('action_id',[9])
        //                 ->where('is_seen_by_department',null)
        //                 ->count();
        //     $total_grievance_pending = Grievance::where('department_id',$CURRENT_USER->department_id)
        //                 ->where('is_transfer',false)
        //                 // ->whereNotIn('action_id',[6,8,9])
        //                 ->whereIn('action_id',[7,6])
        //                 ->count();
        //     $total_sub_organization = SubDepartment::where('department_id',$CURRENT_USER->department_id)
        //                 ->count();
        //     $total_appeal = Grievance::where('is_appeal',true)
        //                 ->where('department_id', $CURRENT_USER->department_id)
        //                 ->where('is_transfer',false)
        //                 ->count();
        // }
        
        switch($CURRENT_USER->role_id){
            case 1:
            case 2:
                 
                $total_grievance_received = Grievance::where('is_transfer',false)
                        ->count();
                $total_grievance_closed = Grievance::where('is_transfer',false)
                            ->whereIn('action_id',[7,6])
                            ->count();
                $grievance_not_yet_process = Grievance::where('is_transfer',false)
                            //->whereIn('action_id',[9])
                            ->where('is_seen_by_department',null)
                            ->count();
                $total_grievance_pending = Grievance::where('is_transfer',false)
                            ->whereNotIn('action_id',[6,8,9])
                            ->count();
                $total_sub_organization = SubDepartment::all()->count();

                $total_appeal = Grievance::where('is_appeal',true)->where('is_transfer',false)->count();
            break;

            case 3://Department Nodal
                
                $total_grievance_received = Grievance::where('department_id',$CURRENT_USER->department_id)
                    ->where('is_transfer',false)
                    ->count();
                $total_grievance_closed = Grievance::where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereIn('action_id',[7,6])
                        ->count();
                $grievance_not_yet_process = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->where('is_seen_by_department',null)
                        ->count();
                $total_grievance_pending = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereNotIn('action_id',[7])
                        ->where('is_seen_by_department','!=',null)
                        ->count();
                $total_sub_organization = SubDepartment::where('department_id',$CURRENT_USER->department_id)
                        ->count();
                $total_appeal = Grievance::where('is_appeal',true)
                        ->where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->count();

            break;

            case 4: //Sub-Org
                $total_grievance_pending = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereIn('action_id',[3,11,12])
                        ->count();
                $total_grievance_closed = Grievance::where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereIn('action_id',[7,6])
                        ->count();


                $total_grievance_received = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->count();
                $grievance_not_yet_process = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->where('is_seen_by_department',null)
                        ->count();
                $total_sub_organization = SubDepartment::where('department_id',$CURRENT_USER->department_id)
                        ->count();
                $total_appeal = Grievance::where('is_appeal',true)
                        ->where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->count();
            break;

            case 6: //Department Appellate
                $total_grievance_received = Grievance::where('department_id',$CURRENT_USER->department_id)
                    ->where('is_transfer',false)
                    ->count();
                $total_grievance_closed = Grievance::where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereIn('action_id',[7,6])
                        ->count();
                $grievance_not_yet_process = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->where('is_seen_by_department',null)
                        ->count();
                $total_grievance_pending = Grievance::where('department_id',$CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->whereIn('action_id',[6])
                        ->count();
                $total_sub_organization = SubDepartment::where('department_id',$CURRENT_USER->department_id)
                        ->count();
                $total_appeal = Grievance::where('is_appeal',true)
                        ->where('department_id', $CURRENT_USER->department_id)
                        ->where('is_transfer',false)
                        ->count();
            break;
        }

        $dashboardData = new stdClass();

        $dashboardData->total_grievance_received = $total_grievance_received;
        $dashboardData->total_grievance_closed = $total_grievance_closed;
        $dashboardData->grievance_not_yet_process = $grievance_not_yet_process;
        $dashboardData->total_grievance_pending = $total_grievance_pending;
        //$dashboardData->sub_organization = $total_grievance_pending;
        $dashboardData->total_sub_organization = $total_sub_organization;
        $dashboardData->total_appeal = $total_appeal;

        return Inertia::render('Auth/Dashboard/Dashboard',[
            'grievances' => $grievances,
            'dashboardData' =>$dashboardData,
            'search'=>$SEARCH,
            'maximumDaysForDepartmentNodal' => $maximumDaysForDepartmentNodal->maximum_days??'',
        ]);

    }

    public function officerClosed(Request $request){ 
    
        $CURRENT_USER=Auth::user();
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
        $PROBABLE_DEPARTMENT = Department::where('organization_name','LIKE',"%{$request->search}%")->pluck('id');

        if($CURRENT_USER->role_id==5){
            return view('403');
        }

        //STATUS_ID CLOSE =7
        if($CURRENT_USER->role_id == 1 ||$CURRENT_USER->role_id == 2){
            $grievances = Grievance::with(['department'])
                ->where('action_id',7)
                ->orWhere('action_id',5)
                ->orWhere('is_appeal',true)
                ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT){
                    $query->when($SEARCH,fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($PER_PAGE);
                    
                    return Inertia::render('Auth/Grievance/AllClosed/Closed',[
                        'grievances' => $grievances,
                        'search' => $SEARCH,
                    ]);
           
            }else if($CURRENT_USER->role_id ==3){

                $grievances = Grievance::with(['department'])
                ->where('department_id',$CURRENT_USER->department_id)
                ->where(function ($query){
                    $query->where('action_id',7) //CLOSED
                    ->orWhere('action_id',5) //TRANSFERRED
                    ->orWhere('is_appeal',true);
            })
            ->where(function($query)use ($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%");
                    
            })                
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);

        }else if($CURRENT_USER->role_id == 4){
            
            //1. For SubNodal Officer Search on the Movement table 
            $grievances1 = GrievanceMovement::with('grievance')  
                ->where('sub_department_owner',$CURRENT_USER->sub_department_id)
                ->where('is_mark_close',true)
                ->pluck('grievance_id'); 

            $gmOwnByCurrentUser = GrievanceMovement::where('sub_department_owner',$CURRENT_USER->sub_department_id)
                ->distinct()
                ->pluck('grievance_id'); 

            $searchIfParentClosed = Grievance::with(['department'])->whereIn('id',$gmOwnByCurrentUser)
                ->where('action_id',7)
                ->pluck('id');
     
            if(!$grievances1->isEmpty()){   
                $grievances = Grievance::with(['department'])
                ->where('action_id','!=',10)
                ->where('department_id',$CURRENT_USER->department_id)
                ->whereIn('id', $grievances1->merge($searchIfParentClosed))
                ->where(function($query) use($SEARCH){
                    $query->when($SEARCH, fn(Builder $builder)=>$builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);

            }else{
                $grievances = Grievance::with(['department'])
                ->where('action_id',999999)->get();
            }

            //combine
            //$grievances = $grievances->concat($searchIfParentClosed);
              
        }else if($CURRENT_USER->role_id==6){
           
            $grievances = Grievance::with(['department'])
            ->where('department_id',$CURRENT_USER->department_id)
            ->where('action_id',7)
            ->where('is_appeal',true)
            ->where(function($query)use ($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%");
            })                
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);
        }

         
        return Inertia::render('Auth/Grievance/Closed',[
            'grievances' => $grievances,
            'search' => $SEARCH,
        ]);
    }

    public function adminClosedView(Request $request){
        $CURRENT_USER=Auth::user();
        $SEARCH = $request->get('search');
        $PER_PAGE = $request->get('per_page')??10;
        $PROBABLE_DEPARTMENT = Department::where('organization_name','LIKE',"%{$request->search}%")->pluck('id');

        if($CURRENT_USER->role_id==5){
            return view('403');
        }

        //STATUS_ID CLOSE =7
        if($CURRENT_USER->role_id == 1 ||$CURRENT_USER->role_id == 2){
            $grievances = Grievance::with(['department'])
                ->where('action_id',7)
                ->orWhere('action_id',5)
                ->orWhere('is_appeal',true)
                ->where(function($query) use ($SEARCH,$PROBABLE_DEPARTMENT){
                    $query->when($SEARCH,fn(Builder $builder)=> $builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%")
                        ->orWhereIn('department_id',$PROBABLE_DEPARTMENT);
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($PER_PAGE);
                    //->dd();            
                    ///->get();
        
            }else if($CURRENT_USER->role_id ==3){

                $grievances = Grievance::with(['department'])
                ->where('department_id',$CURRENT_USER->department_id)
                ->where(function ($query){
                    $query->where('action_id',7) //CLOSED
                    ->orWhere('action_id',5) //TRANSFERRED
                    ->orWhere('is_appeal',true);
            })
            ->where(function($query)use ($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%");
                    
            })                
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);

        }else if($CURRENT_USER->role_id == 4){
             
            $grievances = GrievanceMovement::with('grievance')
             
            ->where('sub_department_owner',$CURRENT_USER->sub_department_id)
            ->where('is_mark_close',true)
            ->pluck('grievance_id'); 
         
            if($grievances!=null){
                $grievances = Grievance::with(['department'])
                ->where('action_id','!=',10)
                ->where('department_id',$CURRENT_USER->department_id)
                ->whereIn('id',$grievances)
                ->where(function($query) use($SEARCH){
                    $query->when($SEARCH, fn(Builder $builder)=>$builder)
                        ->where('grievance_description','like',"%$SEARCH%")
                        ->orWhere('applicant_name','like',"%$SEARCH%")
                        ->orWhere('registration_number','like',"%$SEARCH%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);

            }

        }else if($CURRENT_USER->role_id==6){
            
            $grievances = Grievance::with(['department'])
            ->where('department_id',$CURRENT_USER->department_id)
            ->where('action_id',7)
            ->where('is_appeal',true)
            ->where(function($query)use ($SEARCH){
                $query->when($SEARCH, fn(Builder $builder)=>$builder)
                    ->where('grievance_description','like',"%$SEARCH%")
                    ->orWhere('applicant_name','like',"%$SEARCH%")
                    ->orWhere('registration_number','like',"%$SEARCH%");
            })                
            ->orderBy('created_at','DESC')
            ->paginate($PER_PAGE);
        }
        return Inertia::render('Auth/Grievance/Closed',[
            'grievances' => $grievances,
            'search' => $SEARCH,
        ]);
    }

    //OFFICER
    public function showOfficerGrievance(Request $request, $grievanceId){ 

        $CURRENT_USER = Auth::user();
        $grievance = Grievance::with(['department','user','grievanceMovement.action','action','grievanceMovement'])->where('id',$grievanceId)->first();

        if($CURRENT_USER->role_id==1 ||$CURRENT_USER->role_id==2){
        }else{
            if($CURRENT_USER->department_id != $grievance->department_id){
                return redirect()->back();
            }
        }

        //NEW LABEL
        if($CURRENT_USER->role_id==3){
            $grievance->is_seen_by_department = Carbon::now()->toDateTimeString();
        }

        if($CURRENT_USER->role_id==4){
            //MULTIPLE SUB GAITUAH GAI 
            $grievance->is_seen_by_sub_department = Carbon::now()->toDateTimeString();
        }
        if($CURRENT_USER->role_id==6){
            $grievance->is_seen_by_appellate = Carbon::now()->toDateTimeString();
        }
        $grievance->save();
        
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
                $case->status=true;
                $case->remark=$movement->remark;
                $case->date_of_action = $movement->date_of_action;
            }else{
            }
            
            if($movement->nodal_attachment != null){
                $movement->nodal_attachment_array = explode(",",$movement->nodal_attachment);
            }
            

            $movementAnswerOn = Carbon::parse($movement->date_of_action);
            $hoursDifference = $movementAnswerOn->diffInHours(Carbon::now());
            
            //ANSWER WITHIN 72 HRS | 3DAYS = 72HRS 

            if($hoursDifference < config('app.EDITING_HOURS')){
                $movement->replyEdit = true;
            }else{
                $movement->replyEdit = false;
            }
        }
        
        if($grievance->action_id == 7 ||$grievance->action_id == 6 ||$grievance->is_appeal){
            $case->status=true;
            $case->remark=$grievance->final_remark;
            $case->date_of_action = $grievance->date_of_final_remark;
        }

        if($CURRENT_USER->role_id==4){//DEPARTMENT SUBORGANIZATION NODAL
            
            if($grievance->action_id==3 || $grievance->action_id==10 || $grievance->action_id==12 || $grievance->action_id==7){//TRANSFER FROM PARENT DEPARTMENT
                $case->forOurSubOrganization=true;
                if($grievance->action_id==10){ //SUBORGANIZATION CAN CLOSE
                    //$action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','5')->select('id as value','label as label')->get(); 
                    $action = Action::whereIn('id',[11,12,4])->select('id as value','label as label')->get(); 
                }else{         
                    //$action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','4')->where('id','!=','5')->select('id as value','label as label')->get(); 
                    $action = Action::whereIn('id',[11,12])->select('id as value','label as label')->get(); 
                }
            }

            $mMovement = GrievanceMovement::where('grievance_id',$grievanceId)->latest()->first();
            
            if($mMovement->case_can_be_close == 1){
                $action = Action::where('visible',true)->where('id','!=','3')->where('id','!=','5')->select('id as value','label as label')->get(); 
            }
        }

        $gm = GrievanceMovement::where('grievance_id',$grievanceId)
                            ->where('sub_department_owner',$CURRENT_USER->sub_department_id)
                            ->latest()->first();
        
        if($gm->case_can_be_close==true){
            if($CURRENT_USER->role_id==3 && $gm->action_id==10)
                $showAction = false;
            else $showAction = true;
        }else{
            $showAction = true;
        }

        if($CURRENT_USER->role_id==4 && $gm->action_id == 13 || $gm->action_id ==11 ){
            $showAction = false;
        }else{
            $showAction = true;
        }
        
        if($CURRENT_USER->role_id==3 && $grievance->action_id==7){
            $showAction = false;
        }
        
        if($CURRENT_USER->role_id==4 && $grievance->action_id==7){
            $showAction = false;
        }

        if($CURRENT_USER->role_id==6 && $grievance->action_id==7 && $grievance->is_appeal==true){
            $showAction = false;
        }

        if($CURRENT_USER->role_id==1 ||$CURRENT_USER->role_id==2 )
            $showAction = false;

        // if($grievance->is_appeal){
        //     $gm = GrievanceMovement::where('grievance_id', $grievanceId )->where('action_id', 6)->first();
        //     $grievance->appealQuestion = $gm->remark;
        //     $grievance->appealQuestionDate = $gm->date_of_action;

        //     $action = Action::where('visible',true)->whereIn('id',[2,4])->select('id as value','label as label')->get(); 

        //     $appealReply = GrievanceMovement::where('grievance_id',$grievanceId)
        //     ->where('appeal_number','!=',null)->where('action_id',7)->first();
         
        //     $grievance->appealQuestion = $gm->remark??'';
        //     $grievance->date_of_action = $gm->date_of_action??'';
        //     $grievance->appeal_number = $gm->appeal_number??'';
            
        //     $grievance->appealReplyId = $appealReply->id??'';
        //     $grievance->appealReply = $appealReply->remark??'';
        //     $grievance->appealReplyDate = $appealReply->date_of_action??'';
        //     $grievance->appealReplyUpdateDate = $appealReply->update_date_of_action??'';
        //     $grievance->daaAttachment = '';
        //     if($appealReply->nodal_attachment !=null)
        //         $grievance->daaAttachment = explode(",",$appealReply->nodal_attachment);
        //     $grievance->officer_id_daa = $appealReply->officer_id??'';
        //     $grievance->officer_name_daa = $appealReply->officer_name??'';
        //     $grievance->officer_designation_daa = $appealReply->officer_designation??'';
        //     $grievance->officer_mobile_daa = $appealReply->officer_mobile??'';
        //     $grievance->officer_email_daa = $appealReply->officer_email??'';
        // }
        // Raunak
        if ($grievance->is_appeal) {
            $gm = GrievanceMovement::where('grievance_id', $grievanceId )->where('action_id', 6)->first();
        
            if ($gm) {
                $grievance->appealQuestion = $gm->remark;
                $grievance->appealQuestionDate = $gm->date_of_action;
                $grievance->appeal_number = $gm->appeal_number ?? '';
                
                $action = Action::where('visible', true)->whereIn('id', [2, 4])->select('id as value', 'label as label')->get();
        
                $appealReply = GrievanceMovement::where('grievance_id', $grievanceId)
                    ->where('appeal_number', '!=', null)->where('action_id', 7)->first();
        
                if ($appealReply) {
                    $grievance->appealReplyId = $appealReply->id ?? '';
                    $grievance->appealReply = $appealReply->remark ?? '';
                    $grievance->appealReplyDate = $appealReply->date_of_action ?? '';
                    $grievance->appealReplyUpdateDate = $appealReply->update_date_of_action ?? '';
                    $grievance->daaAttachment = '';
        
                    if ($appealReply->nodal_attachment != null) {
                        $grievance->daaAttachment = explode(",", $appealReply->nodal_attachment);
                    }
        
                    $grievance->officer_id_daa = $appealReply->officer_id ?? '';
                    $grievance->officer_name_daa = $appealReply->officer_name ?? '';
                    $grievance->officer_designation_daa = $appealReply->officer_designation ?? '';
                    $grievance->officer_mobile_daa = $appealReply->officer_mobile ?? '';
                    $grievance->officer_email_daa = $appealReply->officer_email ?? '';
                }
            }
        }

        if($CURRENT_USER->role_id==4 && $grievance->action_id==13){
            $isMarkedClosedBySub = true;
        }else{
            $isMarkedClosedBySub = false;
        }
        
        $grievanceAnswerOn = Carbon::parse($grievance->date_of_final_remark);
        $hoursDifference = $grievanceAnswerOn->diffInHours(Carbon::now());
        
        //72hrs = 3 days
        if ($hoursDifference < config('app.EDITING_HOURS') && $CURRENT_USER->role_id==3) {
            $answerEdit = true;
        } else {
            $answerEdit = false;
        }

        if ($hoursDifference < config('app.EDITING_HOURS') && $CURRENT_USER->role_id==6 && $grievance->appealReply!=null) {
            $answerEditByAppellate = true;
        } else {
            $answerEditByAppellate = false;
        }

        $EDITING_HOURS = config('app.EDITING_HOURS');
        
        $randomQuote = Quote::inRandomOrder()->first();
        
       
        
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
            'showAction' => $showAction,
            'isMarkedClosedBySub' => $isMarkedClosedBySub,
            'fromReport' => false,
            'answerEdit' => $answerEdit,
            'EDITING_HOURS' => $EDITING_HOURS,
            'from_closed_page'=>$request->from_closed_page,
            'randomQuote' => $randomQuote,
            'answerEditByAppellate' => $answerEditByAppellate,

        ]);
    }

    public function citizenFeedback(Request $request){

        $validate = $request->validate([
            'category'=>'required',
        ]);

        $CURRENT_USER = Auth::user();
        $grievance = Grievance::find($request->grievance_id);
        if($CURRENT_USER->id==$grievance->user_id){
            $grievance->applicant_rating= $request->category['value'];
            $grievance->applicant_feedback= $request->feedback ;
            $grievance->save();

            //TODO:SEND SMS | Sl. 13
            $mTempUser = User::where('role_id', 3)->where('department_id',$grievance->department_id)->first();
            $phone = $mTempUser->mobile;
            $message = 'Grievance Registration No:'.$grievance->registration_number.' thehluttu hnen atangin Grievance chhanna chungchang a Feedback I dawng a. Tih tur tul ti tur in '.$this->DOMAIN_NAME.'.mizoram.gov.in ah lut rawh. EGOV-MZ';
            $templateId ='1407170608193978241';
            // $message = 'Applicant has submit feedback for Grievance Registration No:'.$grievance->registration_number.'. Please visit '.$this->DOMAIN_NAME.'.mizoram.gov.in for more details. EGOV-MZ';
            // $templateId ='1407168966053518995';
            thangteaSMS($phone,$message,$templateId);


            return to_route('citizen.dashboard');

        }else{
            return "You are not authorized";
        }                             
    }

    public function answerUpdate(Request $request) {

        $CURRENT_USER = Auth::user();
        $validate=$request->validate([
            'final_remark_update'=>'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',
        ]);

        if($CURRENT_USER->role_id != 1 || $CURRENT_USER->role_id != 2 ){
            $grievance=Grievance::find($request->grievance_id);
            if($CURRENT_USER->department_id == $grievance->department_id){
                //NEW FROM HOME
                $data = [];
                if($request['editAnswerFiles']!=null){
                    foreach($request['editAnswerFiles'] as $file){
                        //the EXTENSION PDF SHOULD NOT BE USED. IT SHOULD BE DYNAMIC
                        $name = "NODAL".time().rand(100,999).".".$file->getClientOriginalExtension();
                        $file->move(storage_path('app/public').'/files/', $name);
                        $data[]=$name;
                    }
                   // $newGrievance->grievance_attachment = implode(",",$data);
                }
                //new from home
                if($request['mNodalFiles']!=null){
                    $data = array_merge($data,$request['mNodalFiles']);
                }
                
                $grievance->nodal_attachment = implode(",",$data);
                $grievance->final_remark = $request->final_remark_update;
                $grievance->update_date_of_final_remark = Carbon::now()->toDateTimeString();
                $grievance->save();
            }
        }
        return redirect()->back();
    }

    public function answerUpdateByAppellate(Request $request) {
        //dd($request->grievance);
        $CURRENT_USER = Auth::user();
        $validate=$request->validate([
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',
        ]);

        if($CURRENT_USER->role_id != 1 || $CURRENT_USER->role_id != 2 ){
            $grievanceMovement=GrievanceMovement::find($request->grievance_movement_id);
            $data = [];
            
            if($request->editAnswerFiles != null){
                foreach($request->editAnswerFiles as $file){
                    //the EXTENSION PDF SHOULD NOT BE USED. IT SHOULD BE DYNAMIC
                    $name = "NODAL".time().rand(100,999).".".$file->getClientOriginalExtension();
                    $file->move(storage_path('app/public').'/files/', $name);
                    $data[]=$name;
                }
                // $newGrievance->grievance_attachment = implode(",",$data);
            }

            if($request->grievance['daaAttachment']!=null){
                $data = array_merge($data,$request->grievance['daaAttachment']);
            }
            
            $grievanceMovement->nodal_attachment = implode(",",$data);
            $grievanceMovement->remark = $request->grievance['appealReply'];
            $grievanceMovement->update_date_of_action = Carbon::now()->toDateTimeString();
            $grievanceMovement->save();
            
        }
        return redirect()->back();
    }

    public function movementAnswerUpdate(Request $request){
        $CURRENT_USER = Auth::user();

        $validate=$request->validate([
            'grievance_movement_remark'=>'required',
            'grievance_movement_id'=>'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',

        ]);

        $grievance_movement = GrievanceMovement::find($request->grievance_movement_id);
        
        //checking for authenticity of user will be required!

        $data=[];
        if($request['appended_files'] != null) {
            foreach($request['appended_files'] as $file) {
                $name = "NODAL".time().rand(100,999).".".$file->getClientOriginalExtension();
                $file->move(storage_path('app/public').'/files/', $name);
                $data[]=$name;
            }
        }
        if($request['previous_files']!=null){
            $data = array_merge($data,$request['previous_files']);
        }

        $grievance_movement->nodal_attachment = implode(",",$data);
        $grievance_movement->remark = $request->grievance_movement_remark;
        $grievance_movement->update_date_of_action = Carbon::now();
        $grievance_movement->save();
    }

    public function movementMaximumDaysUpdate(Request $request) {
        $validate=$request->validate([
            'grievance_movement_maximum_days'=>'required',
            'grievance_movement_id'=>'required',
        ]);
        $grievance_movement = GrievanceMovement::find($request->grievance_movement_id);
    
        $grievance_movement->maximum_days = $request->grievance_movement_maximum_days;
        $grievance_movement->update_date_of_action = Carbon::now();
        $grievance_movement->save();
    }

    public function grievanceDescriptionUpdateCitizen(Request $request){
        $CURRENT_USER = Auth::user();
        $validate=$request->validate([
            'grievance_id'=>'required',
            'grievance_description'=>'required',
            'files.*'  => 'mimes:jpeg,png,gif,svg,pdf',
        ]);

        $grievance = Grievance::find($request->grievance_id);
        if($grievance->user_id!=$CURRENT_USER->id){
            return redirect()->back();
        }
         
        $data =[];
        if($request['editGrievanceFiles'] != null) {
            foreach($request['editGrievanceFiles'] as $file) {
                $name = "USR".time().rand(100,999).".".$file->getClientOriginalExtension();
                $file->move(storage_path('app/public').'/files/', $name);
                $data[]=$name;
            }
        }
        if($request['mUserFiles']!=null){
            $data = array_merge($data,$request['mUserFiles']);
        }

        $grievance->grievance_attachment = implode(",",$data);
        $grievance->grievance_description = $request->grievance_description;
        $grievance->update_date_of_receipt = Carbon::now();
        $grievance->save();
 
       // return to_route('grievance.citizen.show',$grievance->id);
        return Inertia::location(route('grievance.citizen.show',$grievance->id));

    }

    public function printGrievance($id){
         
        $grievance=Grievance::with(['department','user','grievanceMovement.action','action'])->find($id);
         
        $grievance->date_of_receipt = Carbon::parse($grievance->date_of_receipt)->format('j F, Y h:i A');
        $grievance->date_of_final_remark = Carbon::parse($grievance->date_of_final_remark)->format('j F, Y h:i A');
        if($grievance->update_date_of_final_remark)
            $grievance->update_date_of_final_remark = Carbon::parse($grievance->update_date_of_final_remark)->format('j F, Y h:i A');
        else $grievance->update_date_of_final_remark = null;
       
        if($grievance->is_appeal){
            $gm = GrievanceMovement::where('grievance_id', $grievance->id )->where('action_id', 6)->first();
            $grievance->appealQuestion = $gm->remark;
            $grievance->appealQuestionDate = Carbon::parse($gm->date_of_action)->format('j F, Y h:i A');
        

        $appealReply = GrievanceMovement::where('grievance_id',$grievance->id)
            ->where('appeal_number','!=',null)->where('action_id',7)->first();
         
        $grievance->appealQuestion = $gm->remark??'';
        $grievance->date_of_action = Carbon::parse( $gm->date_of_action??'')->format('j F, Y h:i A') ;
        $grievance->appeal_number = $gm->appeal_number??'';
        
        $grievance->appealReply = $appealReply->remark??'';
        $grievance->appealReplyDate = Carbon::parse($appealReply->date_of_action??'')->format('j F, Y h:i A') ;

        $grievance->daaAttachment = $appealReply->nodal_attachment??'';
        $grievance->officer_id_daa = $appealReply->officer_id??'';
        $grievance->officer_name_daa = $appealReply->officer_name??'';
        $grievance->officer_designation_daa = $appealReply->officer_designation??'';
        $grievance->officer_mobile_daa = $appealReply->officer_mobile??'';
        $grievance->officer_email_daa = $appealReply->officer_email??'';

        }
        $pdf = PDF::loadView('print/grievance',compact('grievance'));
        $pdf->setPaper('A4');
        $fileName="";
        try{
            $fileName = Carbon::now();
        }
        catch(Exception $e){
            $fileName = 'complain';
        }
        return $pdf->download($fileName.'.pdf');

    }
} 
