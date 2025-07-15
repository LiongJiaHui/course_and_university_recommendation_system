<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;
use App\Http\Controllers\AreaController;

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

// Main Page route
Route::get('/', function () {
    return view('MainPage');
});

// Student Information route
Route::get('/studentinformation', function () {
    return view('student.StudentInformation');
})->name('studentinformation');

// Subject Information route
Route::get('/subjectinformation', function () {
    return view('student.SubjectInformation');
})->name('subjectinformation');

// Student Preferences route
Route::get('/studentpreferences', function () {
    return view('student.Preferences');
})->name('studentpreferences');

// State and Area routes
Route::get('/get-areas/{state_id}', [StateController::class, 'getAreas']);
Route::get('/get-postcodes/{area_name}', [AreaController::class, 'getPostCodes']);
Route::get('/studentinformation', [StateController::class, 'passState']);


// Administrator section
Route::get('/adminLogin', function () {
    return view('Administrator.LoginPage');
})->name('adminLogin');

Route::get('/adminMenu', function(){
    return view('Administrator.MenuSection');
})->name('adminMenu');

// University section
Route::get('/adminUniversityList', function () {
    return view('Administrator.University.UniversityList');
})->name('adminUniversityList');


// Course Section


// Course Category Section


// Administrator Management Section
