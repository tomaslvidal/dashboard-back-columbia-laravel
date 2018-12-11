<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysMadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys_made', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('RESTRICT');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->unique(['survey_id', 'user_id']);
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys_made');
    }
}
