<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyMadeAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_made_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_made_id')->unsigned();
            $table->foreign('survey_made_id')->references('id')->on('survey_mades')->onDelete('cascade');
            $table->integer('survey_field_id')->unsigned();
            $table->foreign('survey_field_id')->references('id')->on('survey_fields');
            $table->integer('survey_option_id')->unsigned()->nullable();
            $table->foreign('survey_option_id')->references('id')->on('survey_options')->onDelete('cascade');
            $table->string('survey_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_made_answers');
    }
}
