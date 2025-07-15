<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\State;

class StateController extends Controller
{
    public function getAreas($state_id){
        $areas = Area::where('state_id', $state_id)->select('area_name')
        ->distinct()
        ->pluck('area_name');

        return response()->json($areas);
    }

    public function passState(){
        $states = State::all();
        return view('student.StudentInformation', compact('states'));
    }
}
