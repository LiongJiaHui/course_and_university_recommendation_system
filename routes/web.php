<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDetailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PythonController;

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
Route::post('/studentinformation', [PythonController::class, 'storeStudentInfo']);

// Subject Information route
Route::get('/subjectinformation', function () {
    return view('student.SubjectInformation');
})->name('subjectinformation');
Route::post('/subjectinformation', [PythonController::class, 'storeSubjectInfo']);

// Student Preferences route
Route::get('/studentpreferences', function () {
    return view('student.Preferences');
})->name('studentpreferences');
Route::post('/studentpreferences', [PythonController::class, 'submitAll']);

// State and Area routes
Route::get('/get-areas/{state_id}', [StateController::class, 'getAreas']);
Route::get('/get-postcodes/{area_name}', [AreaController::class, 'getPostCodes']);
Route::get('/studentinformation', [StateController::class, 'passState']);


// -----------------------------------------------------------------------------

// Administrator section
Route::get('/adminLogin', function () {
    return view('Administrator.LoginPage');
})->name('adminLogin');
Route::post('/adminLogin', [AdminController::class, 'login']);

Route::get('/adminMenu', function(){
    return view('Administrator.MenuSection');
})->name('adminMenu');


// University section
Route::get('/University', [UniversityController::class, 'index'])->name('university.list');

Route::get('/University/{id}', [UniversityController::class, 'show'])->name('university.show'); // show details

Route::get('/University/{id}/edit', [UniversityController::class, 'edit'])->name('university.edit'); //show edit form

Route::put('/University/{id}', [UniversityController::class, 'update'])->name('university.update'); // submit the edit version

Route::delete('/University/{id}', [UniversityController::class, 'destroy'])->name('university.destroy'); // delete the university

Route::get('/University/create', [UniversityController::class, 'create'])->name('university.create'); // show creation form

Route::post('/Universities', [UniversityController::class, 'store'])->name('university.store'); // store the data into the database





// Course Section
Route::get('/Course', [CourseDetailController::class, 'index'])->name('course.list'); //list

Route::get('/Course/{id}', [CourseDetailController::class, 'show'])->name('course.show'); // show details

Route::get('/Course/{id}/edit', [CourseDetailController::class, 'edit'])->name('course.edit'); //show edit form

Route::put('/Course/{id}', [CourseDetailController::class, 'update'])->name('course.update'); // submit the edit version

Route::delete('/Course/{id}', [CourseDetailController::class, 'destroy'])->name('course.destroy'); // delete the course details

Route::get('/Course/create', [CourseDetailController::class, 'create'])->name('course.create'); // show creation form

Route::post('/Courses', [CourseDetailController::class, 'store'])->name('course.store'); // store the data into the database




// Course Category Section
Route::get('/CourseCategory', [CourseController::class, 'index'])->name('coursecategory.list');

Route::get('/CourseCategory/{id}', [CourseController::class, 'show'])->name('coursecategory.show'); // show details

Route::get('/CourseCategory/{id}/edit', [CourseController::class, 'edit'])->name('coursecategory.edit'); //show edit form

Route::put('/CourseCategory/{id}', [CourseController::class, 'update'])->name('coursecategory.update'); // submit the edit version

Route::delete('/CourseCategory/{id}', [CourseController::class, 'destroy'])->name('coursecategory.destroy'); // delete the course category

Route::get('/CourseCategory/create', [CourseController::class, 'create'])->name('coursecategory.create'); // show creation form

Route::post('/CourseCategories', [CourseController::class, 'store'])->name('coursecategory.store'); // store the data into the database




// Administrator Management Section
Route::get('/Admin', [AdminController::class, 'index'])->name('admin.list'); //list

Route::get('/Admin/{id}', [AdminController::class, 'show'])->name('admin.show'); // show details

Route::get('/Admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit'); //show edit form

Route::put('/Admin/{id}', [AdminController::class, 'update'])->name('admin.update'); // submit the edit version

Route::delete('/Admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy'); // delete the admin

Route::get('/Admins/create', [AdminController::class, 'create'])->name('admin.create'); // show creation form

Route::post('/Admins', [AdminController::class, 'store'])->name('admin.store'); // store the data into the database