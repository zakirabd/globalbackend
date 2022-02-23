<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamChildQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_child_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_parent_question_id');
            $table->foreign('exam_parent_question_id')->on('exam_parent_questions')->references('id')->onDelete('cascade');
            $table->string('title');
            $table->string('description', '2000')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('1');
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
        Schema::dropIfExists('exam_child_questions');
    }
}
