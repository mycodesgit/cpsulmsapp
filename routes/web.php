<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomUploadTopicController;
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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/', function () {
        return view('login');
    });
    Route::get('/login',[LoginController::class,'getLogin'])->name('getLogin');
    Route::post('/login',[LoginController::class,'postLogin'])->name('postLogin');
});

Route::group(['middleware'=>['login_auth']],function(){
    Route::get('/dash/view',[MasterController::class,'index'])->name('dash');
    Route::get('/logout', [MasterController::class, 'logout'])->name('logout');

    Route::prefix('student/classroom')->group(function () {
        Route::get('/semester',[ClassroomController::class,'studsemester'])->name('studsemester');
        Route::get('/fac', [ClassroomController::class, 'facultyindex'])->name('classroomfaculty-index');
        Route::get('/virtual/room', [ClassroomController::class, 'virtual_class'])->name('virtual_class');
        Route::get('/virtual/room/fac', [ClassroomController::class, 'virtualfaculty_class'])->name('virtualfaculty_class');
        Route::get('/virtual/room/subject/{id}', [ClassroomController::class, 'virtual_subjectclass'])->name('virtual_subjectclass');
        Route::get('/virtual/room/subject/fac/{id}', [ClassroomController::class, 'virtual_facultysubjectclass'])->name('virtual_facultysubjectclass');

        Route::post('/virtual/room/subject/fac/upload/topics', [ClassroomUploadTopicController::class, 'storeTopics'])->name('storeTopics');
        Route::get('/virtual/room/subject/fac/upload/topics/show/{id}', [ClassroomUploadTopicController::class, 'showTopics'])->name('showTopics');
        Route::get('/view-storage-file/{filename}', [ClassroomUploadTopicController::class, 'viewFile'])->name('viewFile');
    });
});