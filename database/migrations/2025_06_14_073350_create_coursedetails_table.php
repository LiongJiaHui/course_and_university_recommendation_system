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
            $table->unsignedInteger('merit_mark')->nullable();


            $table->unsignedInteger('english_requirement_skill');

            // If ranking number is 1, ranking_the_no_start is 1, but ranking_the_no_end is Null. 

            // If the ranking number is 200-400.ranking_the_no_start is 200, and ranking_the_no_end is 400.  
            $table->unsignedInteger('ranking_qs_no_start_by_subject')->nullable();
            $table->unsignedInteger('ranking_qs_no_end_by_subject')->nullable();
            $table->year('ranking_qs_year_by_subject')->nullable();

            // If ranking number is 1, ranking_the_no_start is 1, but ranking_the_no_end is Null. 

            // If the ranking number is 200-400.ranking_the_no_start is 200, and ranking_the_no_end is 400.  
            $table->unsignedInteger('ranking_the_no_start_by_subject')->nullable();
            $table->unsignedInteger('ranking_the_no_end_by_subject')->nullable();
            $table->year('ranking_the_year_by_subject')->nullable();


            $table->boolean('course_qualification'); // true for qualified, false for not qualified
            $table->string('course_website');
            $table->foreignId('course_id')->constrained('courses')->onDelete('set null');
            $table->foreignId('university_id')->constrained('universities')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('set null');
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
