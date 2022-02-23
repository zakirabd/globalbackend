<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->on('users')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->on('exams')->references('id')->onDelete('cascade');

            $table->string('over_all');
            $table->string('point');
            $table->string('status');
            $table->string('submit');
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
        Schema::dropIfExists('student_exams');
    }
}
