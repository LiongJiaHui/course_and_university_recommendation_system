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
        $validated = $request->validate([
            'subjectCount' => 'required|integer|min:4|max:5',
            'subject1' => 'required|string',
            'subject1marks' => 'required|numeric|between:0,4',
            'subject2' => 'required|string',
            'subject2marks' => 'required|numeric|between:0,4',
            'subject3' => 'required|string',
            'subject3marks' => 'required|numeric|between:0,4',
            'subject4' => 'required|string',
            'subject4marks' => 'required|numeric|between:0,4',
            'subject5' => 'nullable|string',
            'subject5marks' => 'nullable|numeric|between:0,4',
            'MUETmarks' => 'required|numeric|between:1,5',
            'cocuriculummarks' => 'required|integer|between:0,100',
        ]);

        $subjectCount = $request->input('subjectCount');
        $subjectArray = [];
        $actualCount = 0;

        for ($i = 1; $i <= 5; $i++) {
            $subjectNameKey = "subject{$i}";
            $subjectMarksKey = "subject{$i}marks";

            if ($request->filled($subjectNameKey) && $request->filled($subjectMarksKey)) {
                $actualCount++;
                $subjectArray[] = [
                    'name' => $request->input($subjectNameKey),
                    'marks' => $request->input($subjectMarksKey),
                ];
            }
        }

        if ($subjectCount != $actualCount) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'subjectCount' => ["Subject count ($subjectCount) does not match actual subjects provided ($actualCount)."],
            ]);
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

         // Handle missing session gracefully
        if (!$studentInfo || !$subjectInfo) {
            $recommendations = [];
            return view('student.RecommendationList', compact('recommendations'))->with('data', $recommendations);
        }

        $finalPayload = array_merge($studentInfo, $subjectInfo, $validatedPreferences);

        // dd($finalPayload);

        try {
            $response = Http::post('http://127.0.0.1:5000/final_submit', $finalPayload);

            if ($response->successful()) {
                $recommendations = json_decode(trim($response->body()), true);

                // Ensure it is an array
                if (!is_array($recommendations)) {
                    $recommendations = [];
                }
            } else {
                $recommendations = [];
            }

        } catch (\Exception $e) {
            // Catch network or HTTP errors
            $recommendations = [];
        }

        return view('student.RecommendationList', [
            'data' => $recommendations
        ]);
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


