<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseDetail;
use App\Models\University;
use App\Models\Course;
use App\Models\Admin;

class CourseDetailController extends Controller
{
    // index
    public function index (Request $request) {
        $query = CourseDetail::query();

        // searching 
        if($request->has('search')) {
            $search = $request->input('search');
            $query->where('course_honour_name', 'LIKE', "%{$search}%")
                  ->orWhere();
        }

        $courses = $query->paginate(25);

        return view('Administrator.Course.CourseList', compact('courses'));
    }
    
    // show 
    public function show ($id) {
        $course = CourseDetail::with(['university', 'admin', 'course'])->findOrFail($id);

        if(!$course) {
            return abort(404, "Course not found. ");
        }

        return view('Administrator.Course.CourseDetails', ['course' => $course]);
    }

    // edit
    public function edit ($id) {
        $course = CourseDetail::findOrFail($id);
        $universities = University::all();
        $categories = Course::all();
        $admins = Admin::all();
        return view('Administrator.Course.update', compact('course', 'universities', 'categories', 'admins'));
    }

    // update
    public function update (Request $request, $id) {
        $course = CourseDetail::findOrFail($id);

        $validated_data = $request->validate([

        ]);

        return redirect()->route('course.list')->with('success', 'Course updated successfully.');
    }

    //delete
    public function destroy ($id) {
        $course = CourseDetail::findOrFail($id);
        $course->delete();
        return redirect()->route()->with('success', 'Course deleted successfully.');
    }
    
    // create
    public function create () {
        return view('Administrator.Course.create');
    }

    // store
    public function store (Request $request) {
        $validated_data = $request->validate([

        ]);

        CourseDetail::create($validated_data);

        return redirect()->route('course.list')->with('success', 'Course create successfully. ');
    }
}
