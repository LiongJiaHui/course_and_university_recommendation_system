<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'admin_name',
        'password'
    ];

    protected $guard = 'admin';

    // Relationships
    public function university() {
        return $this->hasMany(University::class, 'uni_id');
    }

    public function course() {
        return $this->hasMany(Course::class, 'course_id');
    }

    public function coursedetail() {
        return $this->hasMany(CourseDetail::class, 'course_detail_id');
    }
    
}
