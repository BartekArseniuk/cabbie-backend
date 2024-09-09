<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('isDriver');
            $table->string('carType');
            $table->string('taxiRegistry')->nullable();
            $table->string('jobStatus');
            $table->string('startTime');
            $table->string('weeklyHours');
            $table->string('foundVia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
}
