<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->integer('field_id')->unsigned();
            $table->foreign('field_id')->references('id')->on('survey_fields')->onDelete('cascade');
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
        Schema::dropIfExists('survey_options');
    }
}
