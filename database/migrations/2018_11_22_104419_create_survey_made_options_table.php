<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyMadeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_made_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_made_field_id')->unsigned();
            $table->foreign('survey_made_field_id')->references('id')->on('survey_made_fields')->onDelete('cascade');
            $table->integer('survey_option_id')->unsigned()->nullable();
            $table->foreign('survey_option_id')->references('id')->on('survey_options');
            $table->string('free_response');
            $table->unique(['survey_made_field_id', 'survey_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_made_options');
    }
}
