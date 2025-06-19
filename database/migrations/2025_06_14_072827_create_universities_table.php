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
            $table->unsignedInteger('ranking_qs');
            $table->unsignedInteger('ranking_the');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('state_name')->onDelete('cascade');
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
