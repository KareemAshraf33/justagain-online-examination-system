<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;

/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*/


Route::get('/', function () {
    return view('welcome');
});

//Register
Route::get('/register',[AuthController::class,'loadRegister'] );
Route::post('/register/studentRegister',[AuthController::class,'studentRegister']);
//login
Route::get('/login',[AuthController::class,'loadLogin'] );
Route::post('/login/userLogin',[AuthController::class,'userLogin']);
//logout
Route::get('/logout',[AuthController::class,'logout'] );

////forgetpassword & reset
Route::get('/password/forgot',[AuthController::class,'showForgotForm'])->name('forgot.password.form');
Route::post('/password/forgot',[AuthController::class,'sendResetLink'])->name('forgot.password.link');
Route::get('/password/reset/{token}',[AuthController::class,'showResetForm'])->name('reset.password.form');
Route::post('/password/reset',[AuthController::class,'resetPassword'])->name('reset.password');
////forgetpassword
//Route::get('/forget-password',[AuthController::class,'forgetPasswordLoad'] );
//Route::post('/forget-password',[AuthController::class,'forgetPassword'] );
//
////change password
//Route::get('/reset-password/{token}',[AuthController::class,'resetPasswordLoad']);
//Route::post('/reset-password',[AuthController::class,'resetPassword'] );

//middleware
Route::group([ 'middleware'=>['web','checkAdmin'] ],function(){
   Route::get('/admin/dashboard',[AuthController::class,'adminDashboard']);

        //show exams
    Route::get('/exams/list',[AdminController::class, 'list']);
    //create exam
    Route::get('/exams/create',[AdminController::class, 'create']);
    Route::post('/exams/store',[AdminController::class, 'store']);

    //Questions
    Route::get('/exams/qna-ans',[AdminController::class, 'qnaDashboard']);
    Route::post('/add-qna-ans',[AdminController::class, 'addQna'])->name('addQna');

    //show all students
    Route::get('/admin/students',[AdminController::class, 'studentsDashboard']);
    
    //qna exams
    Route::get('/get-questions',[AdminController::class, 'getQuestions']);
    Route::post('/add-questions',[AdminController::class, 'addQuestions']);

});

Route::group([ 'middleware'=>['web','checkStudent'] ],function(){
   Route::get('/dashboard',[AuthController::class,'loadDashboard']);
   Route::get('/exam/{id}',[ExamController::class,'loadExamDashboard']);
    
   //submit exam 
   Route::post('/exam-submit',[ExamController::class,'examSubmit']);  
    
   //exam result 
   Route::get('/result',[ExamController::class,'resultDashboard']);
    
});










