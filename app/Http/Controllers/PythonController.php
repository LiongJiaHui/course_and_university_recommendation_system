<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\CourseDetail;
use App\Models\University;
use App\Models\Course;
use App\Models\Area;
use App\Models\State;

class PythonController extends Controller
{

    public function storeStudentInfo(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state' => 'required', 
        ]);
        session(['student_info' => $validated]);
        return redirect('subjectinformations');
    }

    public function storeSubjectInfo (Request $request) {
        $subjectArray = [];

        for ($i = 1; $i <= 5; $i++) {
            $subject = $request->input("subject{$i}");
            $marks = $request->input("subject{$i}marks");

            if ($subject && $marks !== null) {
                $subjectArray[] = [
                    'name' => $subject, 
                    'marks' => $marks
                ];
            }
        }

        $subjectData = [
            'subjects' => $subjectArray, 
            'MUETmarks' => $request->input('MUETmarks'), 
            'cocuriculummarks' => $request->input('cocuriculummarks'),
        ];

        session(['subject_info' => $subjectData]);
        return redirect('studentpreferences');
    }

    public function submitAll(Request $request)
    {
        $validatedPreferences = $request->validate([
            'unitype' => 'required|string',
            'preference' => 'array', // ensure it's an array
            'preference.*' => 'string',
            'location' => 'nullable|array',
            'location.*' => 'string',
            'area_of_interest' => 'nullable|array',
            'area_of_interest.*' => 'string',
            'tuition_fees_start' => 'nullable|numeric',
            'tuition_fees_end' => 'nullable|numeric',
        ]);
        $studentInfo = session('student_info');
        $subjectInfo = session('subject_info');
        // dd($request->path());

        $finalPayload = array_merge($studentInfo, $subjectInfo, $validatedPreferences);

        // dd($finalPayload);

        // Send to Python
        $response = Http::post('http://127.0.0.1:5000/final_submit', $finalPayload);

        // dd($response->body());

        if ($response->successful()) {
            $recommendations = json_decode(trim($response->body()), true);

            // dd($recommendations);

            return view('student.RecommendationList', [
                'data' => $recommendations
            ]);
        }

        return back()->withErrors('Failed to get recommendations from Python.');
    }

    public function getRecommendationsFromAPI()
    {
        $response = Http::get('http://127.0.0.1:5000/get-data');

        if ($response->failed()) {
            return "Error fetching data from Python API.";
        }

        $data = $response->json();

        return view('student.RecommendationList', [
            'data' => $data,
        ]);
    }

    public function showDetails($id) {
        $course = CourseDetail::with(['university', 'course'])->findOrFail($id);
        $university = University::findOrFail($course->university_id);
        $state = State::findOrFail($university->state_id);
        $area = Area::findOrFail($university->area_id);
        $category = Course::findOrFail($course->course_id);

        return view('student.ShowCourseDetails', ['course' => $course, 'university' => $university, 'area' => $area, 'state' => $state, 'category' => $category]);
    }


}


