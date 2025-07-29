<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable =
    [
        'course_category', 
        'course_aspect',
        'course_detail_id', 
        'admin_id',
    ];

    // relationship
    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function coursedetail() {
        return $this->hasMany(CourseDetail::class, 'course_detail_id');
    }
}
