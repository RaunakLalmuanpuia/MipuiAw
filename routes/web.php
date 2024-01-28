<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DeletedUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentNodalController;
use App\Http\Controllers\GrievanceActionController;

use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\GrievanceDashboard;
use App\Http\Controllers\GrievanceMovementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeTextController;
use App\Http\Controllers\LoginController as ControllersLoginController;
use App\Http\Controllers\MaximumDayController;
use App\Http\Controllers\MonthlyCreditController;
use App\Http\Controllers\OfficerAppellateController;
use App\Http\Controllers\OfficerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\SystemController;
use App\Http\Middleware\Admin;
use App\Models\Grievance;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Request;

Route::post('generateOtp', [AuthOtpController::class, 'generateOtp'])->name('generateOtp');
Route::get('generateOtpForMobileUpdate', [AuthOtpController::class, 'generateOtpForMobileUpdate'])->name('generateOtpForMobileUpdate');

//Route::get('otpCreate', [AuthOtpController::class, 'otpCreate'])->name('otpCreate');
Route::post('verification', [AuthOtpController::class, 'verification'])->name('verification');
Route::post('verificationForMobileUpdate', [AuthOtpController::class, 'verificationForMobileUpdate'])->name('verificationForMobileUpdate');

Route::get('resentOtp/{verificationId}', [AuthOtpController::class, 'resentOtp'])->name('resentOtp');
Route::get('resentOtpForMobileUpdate/{verificationId}', [AuthOtpController::class, 'resentOtpForMobileUpdate'])->name('resentOtpForMobileUpdate');

// Route::get('/',function(){       return inertia('Landing/Home'); });
Route::get('/',[HomeController::class,'homeCarousel'])->name('landing');
Route::get('department-statistics',[HomeController::class,'departmentStatistics']);

Route::get('nodals',[HomeController::class,'nodals'])->name('home.nodals');

Route::get('grievance1',[GrievanceController::class,'grievance1'])->name('grievance.create1');

Route::get('contact-us', function(){
    return Inertia('Guest/Contact-Us');
})->name('contact-us');
Route::post('contact-us',[ContactUsController::class,'contactUs'])->name('contactus');

Route::get('/login', function(){
    redirect('/login');
});
 

Route::group(['prefix' => '','middleware' => 'auth'], function() {
    Route::get('grievance1',[GrievanceController::class,'grievance1'])->name('grievance.create1');
   
    // Route::get('grievance2', function(){return redirect('/grievance1');});
    // Route::get('grievance3', function(){return redirect('/grievance1');});
    //Route::post('grievance2', [GrievanceController::class,'grievance2'])->name('grievance.create2'); 
    // Route::post('grievance3',[GrievanceController::class,'grievance3'])->name('grievance.create3');   
    Route::get('grievance2', [GrievanceController::class,'grievance2'])->name('grievance.create2'); 
    Route::get('grievance3',[GrievanceController::class,'grievance3'])->name('grievance.create3');   
    
    Route::post('grievance/store',[GrievanceController::class,'grievanceStore1'])->name('grievance.store1');   
    Route::get('/department/closed',[GrievanceController::class,'officerClosed'])->name('officer.closed');
    Route::get('/grievance/closed/all',[GrievanceController::class,'adminClosedView'])->name('admin.closed');

    Route::get('grievance/citizen/show/{grievanceId}',[GrievanceController::class,'showGrievance'])->name('grievance.citizen.show');
    Route::get('grievance/officer/show/{grievanceId}',[GrievanceController::class,'showOfficerGrievance'])->name('grievance.citizen.show');

    Route::post('grievance/officer/noactionrequired',[GrievanceActionController::class,'noActionRequired'])->name('grievance.noActionRequired');
    Route::post('grievance/officer/examineatourlevel',[GrievanceActionController::class,'officerExamineAtOurLevel'])->name('grievance.examineAtOurLevel');
    Route::post('grievance/officer/takeupwithsubdepartment',[GrievanceActionController::class,'takeUpWithSubDepartment'])->name('grievance.takeUpWithSubDepartment');
    Route::post('grievance/officer/casedisposeof',[GrievanceActionController::class,'caseDisposeOf'])->name('grievance.caseDisposeOf');
    Route::post('grievance/officer/transfertoanotherdepartment',[GrievanceActionController::class,'transferToAnotherDepartment'])->name('grievance.transferToAnotherDepartment');

    Route::post('/grievance/citizen/feedback',[GrievanceController::class,'citizenFeedback'])->name('citizen.citizenFeedback');

    Route::get('/citizen/dashboard',[GrievanceController::class,'dashboard'])->name('citizen.dashboard');   

    Route::get('allofficer',[OfficerProfileController::class,'allOfficer'])->name('all.officer');   
    Route::get('allsubofficer',[OfficerProfileController::class,'subOfficer'])->name('all.subofficer');   

    Route::get('admin/adminViewSubNodalOfficerEdit/{userId}',[OfficerProfileController::class,'adminViewSubNodalOfficerEdit'])->name('admin.adminViewSubNodalOfficerEdit');   
    Route::post('admin/officer/password-change',[OfficerProfileController::class,'officerPasswordChange'])->name('admin.officer.passsword.change');

    Route::get('citizen/appeal', [AppealController::class,'index'])->name('appeal.index');
    Route::post('citizen/appeal',[AppealController::class,'store'])->name('appeal.store');
    Route::get('citizen/appeal/dashboard',[AppealController::class,'dashboard'])->name('appeal.dashboard');
    Route::get('appeal/citizen/show/{grievanceId}',[AppealController::class,'appealDetails'])->name('appeal.details');
    
    Route::get('admin/appeal',[AppealController::class,'adminAppealView'])->name('admin.appeal.index');

    Route::resource('profile',ProfileController::class);
    Route::resource('department',DepartmentController::class);
    Route::resource('subdepartment',SubDepartmentController::class);
    Route::get('/department/sibling/{parentId}',[SubDepartmentController::class,'sibling'])->name('index.sibling');
    Route::get('/sibling/create/{parentId}',[SubDepartmentController::class,'createSibling'])->name('create.sibling');
    Route::get('/nodal/sibling/{parentId}',[OfficerProfileController::class,'createSibling'])->name('create.nodal.sibling');
    Route::get('/nodalindex/sibling/{parentDepartmentId}',[OfficerProfileController::class,'sibling'])->name('index.nodal.sibling');
    Route::post('/nodal/sibling',[OfficerProfileController::class,'storeSibling'])->name('store.nodal.sibling');

    Route::get('admin/subnodal/{userId}/edit',[DepartmentNodalController::class,'editSubNodal']);

    Route::resource('admin/nodal',OfficerProfileController::class);
    Route::resource('admin/role',RoleController::class);
    Route::resource('admin/departmentnodal',DepartmentNodalController::class);

    Route::get('/grievance/print/{id}',[GrievanceController::class,'printGrievance']);
    Route::get('/user/details/show',[ApplicantController::class,'singleUserShow'])->name('user.details.show');
    Route::get('/officer/details/show',[ApplicantController::class,'singleOfficerShow'])->name('officer.details.show');
    Route::put('/user/details/update/{applicant}',[ApplicantController::class,'update'])->name('user.details.update');

    Route::get('/admin/appellate/create',[OfficerAppellateController::class,'create'])->name('appellate.create');
    Route::get('/admin/appellate',[OfficerAppellateController::class,'index'])->name('appellate.index');
    Route::post('/admin/appellate',[OfficerAppellateController::class,'store'])->name('appellate.store');
    Route::put('/appellate/{id}',[OfficerAppellateController::class,'update'])->name('appellate.update');

    Route::post('/admin/grievance/movement/open',[GrievanceMovementController::class,'movementOpen'])->name('grievance.movement.open');

    Route::post('/password/change',[ProfileController::class,'updateMyPassword'])->name('password.change');
    Route::get('/mobile/change',[ProfileController::class,'updateMyMobile'])->name('mobile.change');

    Route::get('/admin/setting/carousel',[SystemController::class,'carousel'])->name('admin.system.carousel.index');
    Route::post('/admin/setting/carousel',[SystemController::class,'carouselStore'])->name('admin.system.carousel.store');
    Route::post('/admin/setting/carousel/edit/{id}',[SystemController::class,'carouselUpdate'])->name('admin.system.carousel.update');
    Route::delete('/admin/setting/carousel/delete/{id}',[SystemController::class,'carouselDelete'])->name('admin.system.carousel.delete');
    
    Route::get('/admin/setting/hometext',[HomeTextController::class,'index'])->name('admin.system.hometext.index');
    Route::post('/admin/setting/hometext/{id}',[HomeTextController::class,'update'])->name('admin.system.hometext.update');

    Route::post('grievance/answer/update',[GrievanceController::class,'answerUpdate']);
    Route::post('grievance/answer/updateByAppellate',[GrievanceController::class,'answerUpdateByAppellate']);

    Route::post('grievance/movement/answer/update',[GrievanceController::class,'movementAnswerUpdate']);
    Route::post('grievance/movement/maximumdays/update',[GrievanceController::class,'movementMaximumDaysUpdate']);
    
    Route::post('grievance/citizen/update',[GrievanceController::class,'grievanceDescriptionUpdateCitizen']);
    Route::post('grievance/movefrompendingtoclosed',[GrievanceActionController::class,'moveFromPendingToClosed']);

    Route::get('/myreport',[ReportController::class,'departmentReport'])->name('department.report');
    Route::get('/departmentreport/print',[ReportController::class,'departmentReportPrint'])->name('department.report.print');

});

Route::group(['middleware'=>['admin']], function() {
    Route::resource('/admin/action',ActionController::class);
    Route::resource('applicant', ApplicantController::class);
    Route::get('report/grievancelist',[ReportController::class,'departmentList'])->name('report.grievancelist');
    Route::get('report/mydepartment/{departmentId}',[ReportController::class,'singleDepartment'])->name('report.singleDepartment');
    Route::get('report/mydepartment/grievance/{grievanceId}',[ReportController::class,'showGrievance'])->name('report.showGrievance');
    Route::get('maximumday/',[MaximumDayController::class,'index'])->name('maximumday.index');
    Route::get('/dashboardnyo',[GrievanceDashboard::class,'NotYetOpen'])->middleware(['auth','verified'])->name('officer.notyetopen');
    Route::get('/dashboarddelete',[GrievanceDashboard::class,'deleteGrievanceIndex'])->middleware(['auth','verified'])->name('officer.deleteGrievance');
    Route::post('/dashboarddeleteShow',[GrievanceDashboard::class,'deleteGrievanceShow'])->middleware(['auth','verified'])->name('officer.deleteGrievanceShow');
    Route::post('/dashboarddeleteDestroy',[GrievanceDashboard::class,'deleteGrievanceDestroy'])->middleware(['auth','verified'])->name('officer.deleteGrievanceDestroy');

    Route::get('allofficerlist',[OfficerProfileController::class,'allOfficer'])->name('all.officer');   
    Route::resource('/admin/quote',QuoteController::class);

    Route::resource('/admin/feedback',ContactUsController::class);
    Route::resource('/admin/deletedUser',DeletedUserController::class);
    Route::resource('/admin/monthlyLimit',MonthlyCreditController::class);
    Route::get('/allreport/print',[ReportController::class,'printAllReport']);
    Route::get('/singlereport/print/{departmentId}',[ReportController::class,'printSingleDepartment']);
    // update maximum day
    Route::put('maximumday/update',[MaximumDayController::class,'update'])->name('maximumday.update');

});

Route::group(['middleware'=>['isSuperAdmin']], function() {
    
    
});

Route::group(['middleware'=>['checkStateAndDepartmentNodalOfficer']], function(){
    Route::resource('/admin/category', CategoryController::class);
    Route::get('/categorycheck/{categoryId}',[CategoryController::class,'categoryCheck'])->name('categorycheck');

});

// Route::resource('/admin/action',ActionController::class);
Route::get('/users', function(){
    
    return Inertia::render('Users/Index',[
        'users' => User::paginate(10)->through(fn($user) => [
            'name' => $user->name,
            'id' => $user->id
        ])
    ]);
});

    Route::get('users/create', function() {
        return Inertia::render('Users/Create');
    });

    Route::post('users', function() {

        $attr = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',       
        ]);

        User::create($attr);

        return redirect('/users');
    });

    Route::get('/dashboard',[GrievanceController::class,'OfficerDashboard'])->middleware(['auth','verified'])->name('officer.dashboard');


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
