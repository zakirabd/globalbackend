<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->string('title');
            $table->string('description', '2000')->nullable();
            $table->string('duration')->nullable();
            $table->string('cost')->nullable();
            $table->string('level')->nullable();
            $table->string('timing')->nullable();
            $table->string('image')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
