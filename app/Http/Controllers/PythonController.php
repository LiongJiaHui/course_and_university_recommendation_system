<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return redirect('/subjectinformation');
    }

    public function storeSubjectInfo (Request $request) {
        $subjectData = $request->only([
            'subject1', 'subject1marks',
            'subject2', 'subject2marks',
            'subject3', 'subject3marks',
            'subject4', 'subject4marks',
            'subject5', 'subject5marks',
            'MUETmarks',
            'cocuriculummarks',
            'subjectCount',
        ]);

        session(['subject_info' => $subjectData]);
        return redirect('studentpreferences');
    }

    public function submitAll(Request $request)
    {
        $preferences = $request->all();
        $studentInfo = session('student_info');
        $subjectInfo = session('subject_info');

        $finalPayload = array_merge($studentInfo, $subjectInfo, $preferences);

        // Send to Python script via HTTP POST
        $response = Http::post('http://127.0.0.1:5000/final-submit', $finalPayload);

        // Clear session 
        session()->forget(['student_info', 'subject_info']);

        return redirect('/thank-you')->with('status', 'Submission completed.');
    }
}
