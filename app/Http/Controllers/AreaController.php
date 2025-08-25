<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Area;

class AreaController extends Controller
{
    public function getPostCodes($area_name){
        $postcodes = Area::where('area_name', $area_name)
                     ->pluck('postcode'); // multiple postcodes
    return response()->json($postcodes);
    }
}
