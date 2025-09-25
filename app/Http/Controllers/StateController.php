<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\State;

class StateController extends Controller
{
    public function getAreas($state_name){
        $state = State::where('state_name', $state_name)->first();
        if ($state) {
        // Return distinct area names only
        $areas = Area::where('state_id', $state->id)
                    ->distinct()
                    ->pluck('area_name');
        return response()->json($areas);
        }
        return response()->json([]);
    }

    public function passState(){
        $states = State::all();
        return view('student.StudentInformation', compact('states'));
    }

    public function passState_v2(){
        $states = State::all();
        return view('Administrator.University.create', compact('states'));
    }

     public function passState_v3(){
        $states = State::all();
        return view('Administrator.University.update', compact('states'));
    }

    public function getAreasById($stateId)
    {
        $areas = \App\Models\Area::where('state_id', $stateId)
            ->distinct()
            ->orderBy('area_name')
            ->pluck('area_name')
            ->values();

        return response()->json($areas);
    }
}
