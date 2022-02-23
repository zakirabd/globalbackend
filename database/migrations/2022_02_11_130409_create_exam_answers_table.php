<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_child_question_id');
            $table->foreign('exam_child_question_id')->on('exam_child_questions')->references('id')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('is_correct')->nullable();
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
        Schema::dropIfExists('exam_answers');
    }
}
