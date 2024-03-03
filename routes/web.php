<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'jobDetails'])->name('jobdetails');
Route::post('/job-apply', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job',[JobsController::class,'saveJob'])->name('saveJob');

//Admin Group
Route::group(['prefix' => 'admin', 'middleware' => 'checkRole'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/jobs', [JobController::class, 'adminJobs'])->name('admin.jobs');
    Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('admin.jobs.edit');
    Route::post('/jobs/{id}', [JobController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/jobs', [JobController::class, 'destroy'])->name('admin.jobs.destroy');

});


Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/process-registration', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('account.updateProfilePicture');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/create-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::post('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/edit-job/{id}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::post('/edit-job/{id}',[AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::get('/delete-job/{id}', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('/applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');
        Route::post('/remove-job-application',[AccountController::class,'removeJobs'])->name('account.removeJobs');
        Route::get('/saved-jobs', [AccountController::class, 'savedJobs'])->name('account.savedJobs');
        Route::post('remove-saved-job',[AccountController::class,'removeSavedJob'])->name('account.removeSavedJob');
        Route::post('update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
    });
});