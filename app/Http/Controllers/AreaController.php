<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Area;

class AreaController extends Controller
{
    public function getPostCodes($area_id){
        $postcode = Area::where('area_name', $area_id)
                ->pluck('postcode')
                ->unique();
        
        return response()->json($postcode);
    }
}
