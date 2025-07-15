<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('uni_name');
            $table->string('uni_address');
            $table->string('campus');
            $table->string('website');
            $table->string('uni_type');
            $table->string('contact_no',20);
            $table->string('email');

            // If ranking number is 1, ranking_the_no_start is 1, but ranking_the_no_end is Null. 

            // If the ranking number is 200-400.ranking_the_no_start is 200, and ranking_the_no_end is 400.  
            $table->unsignedInteger('ranking_qs_no_start')->nullable();
            $table->unsignedInteger('ranking_qs_no_end')->nullable();
            
            $table->year('ranking_qs_year')->nullable();

            // If ranking number is 1, ranking_the_no_start is 1, but ranking_the_no_end is Null. 

            // If the ranking number is 200-400.ranking_the_no_start is 200, and ranking_the_no_end is 400.  
            $table->unsignedInteger('ranking_the_no_start')->nullable(); 
            $table->unsignedInteger('ranking_the_no_end')->nullable();

            $table->year('ranking_the_year')->nullable();

            $table->foreignId('admin_id')->constrained('admins')->onDelete('set null');
            $table->foreignId('state_id')->constrained('states')->onDelete('set null');
            $table->foreignId('area_id')->constrained('areas')->onDelete('set null');
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
        Schema::dropIfExists('universities');
    }
}
