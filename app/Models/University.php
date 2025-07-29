<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $table = "universities";

    protected $fillable = [
        "uni_name", 
        "uni_address", 
        "campus",
        "website",
        "uni_type",
        "contact_no",
        "ranking_qs_no_start",
        "ranking_qs_no_end", 
        "ranking_qs_year", 
        "ranking_the_no_start", 
        "ranking_the_no_end",
        "ranking_the_year", 
        "admin_id",
        "state_id", 
        "area_id", 
    ];

    // relationship
    public function state() {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function coursedetails() {
        return $this->hasMany(CourseDetail::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class,  'admin_id');
    }
}
