<?php

use App\Http\Controllers\API\AbsenceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\JobappController;
use App\Http\Controllers\API\JobOfferController;
use App\Http\Controllers\API\OffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('edit-user/{id}',[AuthController::class,'viewEditUser']);
Route::put('update-user/{id}',[AuthController::class,'updateUser']);
   
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum', 'isAPIAdmin')->group(function () {
    Route::post('create_chef', [AuthController::class,'createChef']);
    Route::get('view_chefs', [AuthController::class,'viewChefs']);
    Route::get('view_seekers', [AuthController::class,'viewSeekers']);
    Route::delete('delete_chef/{id}', [AuthController::class,'deleteChef']);
 

    //manage Employees
    Route::post('create_employee', [EmployeeController::class,'createEmployee']);
    Route::get('view_employees', [EmployeeController::class,'viewEmployees']);
    Route::post('view_employees_by_department', [EmployeeController::class,'getEmployeesByDepartment']);
    Route::get('view_employee/{id}', [EmployeeController::class,'viewEmployee']);
    Route::put('update_employee/{id}', [EmployeeController::class,'updateEmployee']);
    Route::delete('delete_employee/{id}', [EmployeeController::class,'deleteEmployee']);
    //manage offs
    Route::post('create_off', [OffController::class,'createOff']);
    Route::get('view_offs', [OffController::class,'viewOffs']);
    Route::get('view_off/{id}', [OffController::class,'viewOff']);
    Route::put('update_off/{id}', [OffController::class,'updateOff']);
    Route::delete('delete_off/{id}', [OffController::class,'deleteOff']);
    //manage absences
    Route::post('create_absence', [AbsenceController::class,'createAbsence']);
    Route::get('view_absences', [AbsenceController::class,'viewAbsences']);
    Route::get('view_absence/{id}', [AbsenceController::class,'viewAbsence']);
    Route::put('update_absence/{id}', [AbsenceController::class,'updateAbsence']);
    Route::delete('delete_absence/{id}', [AbsenceController::class,'deleteAbsence']);
    //manage job offer
    Route::post('create_job_offer', [JobOfferController::class,'createJobOffer']);
    Route::get('view_job_offers', [JobOfferController::class,'viewJobOffers']);
    Route::get('view_job_offer/{id}', [JobOfferController::class,'viewJobOffer']);
    Route::put('update_job_offer/{id}', [JobOfferController::class,'updateJobOffer']);
    Route::delete('delete_job_offer/{id}', [JobOfferController::class,'deleteJobOffer']);
    //manage departments
    Route::post('create_department', [DepartmentController::class,'createDepartment']);
    Route::get('view_departments', [DepartmentController::class,'viewDepartments']);
   
    Route::get('view_department_info', [DepartmentController::class,'viewDepartmentInf']);
    Route::get('view_departments_mec', [DepartmentController::class,'viewDepartmentMec']);
    Route::get('view_departments_elec', [DepartmentController::class,'viewDepartmentElec']);
    
    Route::get('view_department/{id}', [DepartmentController::class,'viewDepartment']);
    Route::put('update_department/{id}', [DepartmentController::class,'updateDepartment']);
    Route::delete('delete_department/{id}', [DepartmentController::class,'deleteDepartment']);
   //update profile
   Route::get('view_jobs_pending', [JobappController::class,'viewJobsPending']);
   Route::get('view_jobs_accepted', [JobappController::class,'viewJobsAccepted']);
});
Route::middleware('auth:sanctum', 'auth.job_seeker')->group(function () {
    //view offers
    Route::get('view_job_offers', [JobOfferController::class,'viewJobOffers']);
     //apply job applications
     Route::post('create_job_application', [JobappController::class,'createJobApplication']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('view_job_applications', [JobappController::class,'viewJobApplications']);
    Route::get('view_job_offers', [JobOfferController::class,'viewJobOffers']);
});
Route::put('accept_job_application/{id}', [JobappController::class,'acceptJobApplication']);
Route::put('refuse_job_application/{id}', [JobappController::class,'refuseJobApplication']);




