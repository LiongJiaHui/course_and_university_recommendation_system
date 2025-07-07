<?php

use Illuminate\Support\Facades\Route;

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
    return view('student.StudentPreferences');
})->name('studentpreferences');


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
