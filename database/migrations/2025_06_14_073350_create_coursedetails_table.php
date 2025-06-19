<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursedetails', function (Blueprint $table) {
            $table->id();
            $table->string('course_honour_name');
            $table->unsignedInteger('tuition_fees');
            $table->unsignedInteger('credit_hours');
            $table->unsignedInteger('duration');
            $table->unsignedInteger('minimum_grade');
            $table->string('specific_subjects');
            $table->unsignedInteger('merit_mark');
            $table->unsignedInteger('english_requirement_skill');
            $table->unsignedInteger('ranking_qs_by_subject');
            $table->unsignedInteger('ranking_the_by_subject');
            $table->boolean('course_qualification'); // true for qualified, false for not qualified
            $table->string('course_website');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('university_id')->constrained('universities')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursedetails');
    }
}
