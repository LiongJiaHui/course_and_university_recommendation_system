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
            'course_honour_name' => 'required',
            'tuition_fees' => 'required|numeric',
            'credit_hours' => 'required|numeric', 
            'duration' => 'required|numeric', 
            'minimum_grade' => 'required|numeric|max:4.0', 
            'specific_subjects' => 'nullable',
            'merit_mark' => 'nullable|numeric|max: 100.00', 
            'english_requirement_skill' => 'required|numeric|min:1.0|max:5.0', 
            'ranking_qs_no_start_by_subject' => 'nullable|numeric', 
            'ranking_qs_no_end_by_subject' => 'nullable|numeric', 
            'ranking_qs_year_by_subject' => 'nullable|numeric', 
            'ranking_the_no_start_by_subject' => 'nullable|numeric', 
            'ranking_the_no_end_by_subject' => 'nullable|numeric', 
            'ranking_the_year_by_subject' => 'nullable|numeric', 
            'course_qualification' => 'required', 
            'course_website' => 'required', 
            'course_id' => 'required', 
            'university_id' => 'required', 
            'admin_id' => 'required'
        ]);

        if ($validated_data['specific_subjects'] == null) {
            $validated_data['specific_subjects'] = "";
        }

        $course->update($validated_data);

        return redirect()->route('course.list')->with('success', 'Course updated successfully.');
    }

    //delete
    public function destroy ($id) {
        $course = CourseDetail::findOrFail($id);
        $course->delete();
        return redirect()->route('course.list')->with('success', 'Course deleted successfully.');
    }
    
    // create
    public function create () {
        $categories = Course::all();
        $admins = Admin::all();
        $universities = University::all();
        return view('Administrator.Course.create', compact('categories', 'admins', 'universities'));
    }

    // store
    public function store (Request $request) {
        $validated_data = $request->validate([
            'course_honour_name' => 'required',
            'tuition_fees' => 'required|numeric',
            'credit_hours' => 'required|numeric', 
            'duration' => 'required|numeric', 
            'minimum_grade' => 'required|numeric|max:4.0', 
            'specific_subjects' => 'nullable',
            'merit_mark' => 'nullable|numeric|max: 100.00', 
            'english_requirement_skill' => 'required|numeric|min:1.0|max:5.0', 
            'ranking_qs_no_start_by_subject' => 'nullable|numeric', 
            'ranking_qs_no_end_by_subject' => 'nullable|numeric', 
            'ranking_qs_year_by_subject' => 'nullable|numeric', 
            'ranking_the_no_start_by_subject' => 'nullable|numeric', 
            'ranking_the_no_end_by_subject' => 'nullable|numeric', 
            'ranking_the_year_by_subject' => 'nullable|numeric', 
            'course_qualification' => 'required', 
            'course_website' => 'required', 
            'course_id' => 'required', 
            'university_id' => 'required', 
            'admin_id' => 'required'
        ]);

        if ($validated_data['specific_subjects'] == null) {
            $validated_data['specific_subjects'] = "";
        }

        CourseDetail::create($validated_data);

        return redirect()->route('course.list')->with('success', 'Course create successfully. ');
    }
}
