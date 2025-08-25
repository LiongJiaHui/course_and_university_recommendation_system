<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;

    protected $table = 'coursedetails';

    protected $fillable = 
    [
        'course_honour_name', 
        'tuition_fees', 
        'credit_hours',
        'duration',
        'minimum_grade',
        'specific_subjects', 
        'merit_mark', 
        'english_requirement_skill', 
        'ranking_qs_no_start_by_subject', 
        'ranking_qs_no_end_by_subject', 
        'ranking_qs_year_by_subject', 
        'ranking_the_no_start_by_subject', 
        'ranking_the_no_end_by_subject', 
        'ranking_the_year_by_subject', 
        'course_qualification', 
        'course_website', 
        'university_id', 
        'course_id', 
        'admin_id'
    ];

    // relationship
    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function university() {
        return $this->belongsTo(University::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
