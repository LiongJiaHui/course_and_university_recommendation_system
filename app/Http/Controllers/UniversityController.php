<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\CourseDetail;
use App\Models\State;
use App\Models\Area;

class UniversityController extends Controller
{
   // index
    public function index (Request $request) {
        $query = University::query();

        // searching section
        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search){
                $q->where('uni_name', 'LIKE', "%{$search}%")
                ->orWhere('campus', 'LIKE', "%{$search}%")
                ->orWhere('website', 'LIKE', "%{$search}%")
                ->orWhere('uni_type', 'LIKE', "%{$search}%");
            });

        }

        $universities = $query->paginate(25);

        return view('Administrator.University.UniversityList', compact('universities'));

    }
    
    // show 
    public function show ($id) {
        $university = University::with(['admin', 'state', 'area', 'coursedetails'])->findOrFail($id);


        if (!$university) {
            return abort(404, "University is not found");
        }

        return view('Administrator.University.UniversityDetails', compact('university'));
    }

    // edit
    public function edit ($id) {
        $university = University::findOrFail($id);
        $states = State::all();
        $areas = Area::all();
        $admins = Admin::all();
        return view('Administrator.University.update', compact('university'));
    }

    // update
    public function update (Request $request, $id) {
        $university = University::findOrFail($id);

        $validated_data = $request->validate([
            'uni_name' => 'required',
            'uni_address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state' => 'required',
            'campus' => 'required', 
            'website' => 'required',
            'uni_type' => 'required',
            'contact_no' => 'required',
            'ranking_qs_no_start' => 'required', 
            'ranking_qs_no_end' => 'required',
            'ranking_qs_year' => 'required',
            'ranking_the_no_start' => 'required',
            'ranking_the_no_end' => 'required',
            'ranking_the_year' => 'required',
            'admin' => 'required'
        ]);

        $university->update($validated_data);

        return redirect()->route('university.list')->with('success', 'University updated successfully.');
    }

    //delete
    public function destroy ($id) {
        $university = University::findOrFail($id);
        $university->delete();
        return redirect()->route('coursecategory.destroy')->with('success', 'Course category deleted successfully.');
    }
    
    // create
    public function create () {
        $states = State::all();
        $areas = Area::all();
        $admins = Admin::all();
        return view('Administrator.University.create');
    }

    // store
    public function store (Request $request) {
        $validated_data = $request->validate([
            'uni_name' => 'required',
            'uni_address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state' => 'required',
            'campus' => 'required', 
            'website' => 'required',
            'uni_type' => 'required',
            'contact_no' => 'required',
            'ranking_qs_no_start' => 'required', 
            'ranking_qs_no_end' => 'required',
            'ranking_qs_year' => 'required',
            'ranking_the_no_start' => 'required',
            'ranking_the_no_end' => 'required',
            'ranking_the_year' => 'required',
            'admin' => 'required'
        ]);

        University::create($validated_data);

        return redirect()->route('university.list')->with('success', 'University created successfully.');
    }
}
