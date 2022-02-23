<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_enroll', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->on('users')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->on('users')->references('id')->onDelete('cascade');

            $table->string('lesson_mode')->nullable();
            $table->string('lesson_hour')->nullable();
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
        Schema::dropIfExists('teacher_enroll');
    }
}
