<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\CourseDetail;
use App\Models\State;
use App\Models\Area;
use App\Models\Admin;

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

        if ($request->sort === 'qs') {
            $query->orderByRaw('ISNULL(ranking_qs_no_start), ranking_qs_no_start ASC');
        } elseif ($request->sort === 'the') {
            $query->orderByRaw('ISNULL(ranking_the_no_start), ranking_the_no_start ASC');
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
        return view('Administrator.University.update', compact('university', 'states', 'areas', 'admins'));
    }

    // update
    public function update (Request $request, $id) {
        $university = University::findOrFail($id);

        // dd($request);

        $validated_data = $request->validate([
            'uni_name' => 'required',
            'uni_address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state_id' => 'required',
            'campus' => 'required', 
            'website' => 'required',
            'uni_type' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email',
            'ranking_qs_no_start' => 'nullable', 
            'ranking_qs_no_end' => 'nullable',
            'ranking_qs_year' => 'nullable',
            'ranking_the_no_start' => 'nullable',
            'ranking_the_no_end' => 'nullable',
            'ranking_the_year' => 'nullable',
            'admin_id' => 'required'
        ]);

        // dd($validated_data);

        $area = Area::where('area_name', $validated_data['area'])
        ->where('postcode', $validated_data['postcode'])
        ->first();

        if (!$area) {
            return redirect()->back()->withErrors(['area_id' => 'Area ID not found for given area and postcode.']);
        }

        $university->update([
            'uni_name' => $validated_data['uni_name'], 
            'uni_address' => $validated_data['uni_address'], 
            'campus' => $validated_data['campus'], 
            'website' => $validated_data['website'],
            'uni_type' => $validated_data['uni_type'], 
            'contact_no' => $validated_data['contact_no'],
            'email' => $validated_data['email'], 
            'ranking_qs_no_start' => $validated_data['ranking_qs_no_start'], 
            'ranking_qs_no_end' => $validated_data['ranking_qs_no_end'],
            'ranking_qs_year' => $validated_data['ranking_qs_year'], 
            'ranking_the_no_start' => $validated_data['ranking_the_no_start'], 
            'ranking_the_no_end' => $validated_data['ranking_the_no_end'], 
            'ranking_the_year' => $validated_data['ranking_the_year'], 
            'admin_id' => $validated_data['admin_id'], 
            'state_id' => $validated_data['state_id'], 
            'area_id' => $area->id
        ]);

        return redirect()->route('university.list')->with('success', 'University updated successfully.');
    }

    //delete
    public function destroy ($id) {
        $university = University::findOrFail($id);
        $university->delete();
        return redirect()->route('university.list')->with('success', 'University deleted successfully.');
    }
    
    // create
    public function create () {
        $states = State::all();
        $areas = Area::all();
        $admins = Admin::all();
        return view('Administrator.University.create', compact('states', 'areas', 'admins'));
    }

    // store
    public function store (Request $request) {
        // dd($request);
        
        $validated_data = $request->validate([
            'uni_name' => 'required',
            'uni_address' => 'required',
            'postcode' => 'required', 
            'area' => 'required', 
            'state_id' => 'required',
            'campus' => 'required', 
            'website' => 'required',
            'uni_type' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email',
            'ranking_qs_no_start' => 'nullable', 
            'ranking_qs_no_end' => 'nullable',
            'ranking_qs_year' => 'nullable',
            'ranking_the_no_start' => 'nullable',
            'ranking_the_no_end' => 'nullable',
            'ranking_the_year' => 'nullable',
            'admin_id' => 'required'
        ]);

        // dd($validated_data);

        $area = Area::where('area_name', $validated_data['area'])
        ->where('postcode', $validated_data['postcode'])
        ->first();

        if (!$area) {
            return redirect()->back()->withErrors(['area_id' => 'Area ID not found for given area and postcode.']);
        }

        University::create([
            'uni_name' => $validated_data['uni_name'], 
            'uni_address' => $validated_data['uni_address'], 
            'campus' => $validated_data['campus'], 
            'website' => $validated_data['website'],
            'uni_type' => $validated_data['uni_type'], 
            'contact_no' => $validated_data['contact_no'],
            'email' => $validated_data['email'], 
            'ranking_qs_no_start' => $validated_data['ranking_qs_no_start'], 
            'ranking_qs_no_end' => $validated_data['ranking_qs_no_end'],
            'ranking_qs_year' => $validated_data['ranking_qs_year'], 
            'ranking_the_no_start' => $validated_data['ranking_the_no_start'], 
            'ranking_the_no_end' => $validated_data['ranking_the_no_end'], 
            'ranking_the_year' => $validated_data['ranking_the_year'], 
            'admin_id' => $validated_data['admin_id'], 
            'state_id' => $validated_data['state_id'], 
            'area_id' => $area->id
        ]);

        return redirect()->route('university.list')->with('success', 'University created successfully.');
    }
}
