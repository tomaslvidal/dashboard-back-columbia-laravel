<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyMadeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_made_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_made_id')->unsigned();
            $table->foreign('survey_made_id')->references('id')->on('surveys_made')->onDelete('cascade');
            $table->integer('survey_field_id')->unsigned();
            $table->foreign('survey_field_id')->references('id')->on('survey_fields');
            $table->unique(['survey_made_id', 'survey_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_made_fields');
    }
}
