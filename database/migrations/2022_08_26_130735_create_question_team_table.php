<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId("question_id")->nullable();
            $table->foreignId("team_id");
            $table->dateTime("started_at")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime("finished_at")->nullable();
            $table->integer("points")->default(0);
            $table->string("answer_given")->nullable();
            $table->json("scans")->nullable();
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
        Schema::dropIfExists('question_team');
    }
}
