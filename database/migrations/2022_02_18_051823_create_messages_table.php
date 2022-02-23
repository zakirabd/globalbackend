<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_id');
            $table->foreign('to_id')->on('users')->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->on('users')->references('id')->onDelete('cascade');
            $table->string('message');
            $table->string('unread_status')->default('1');
            $table->string('new_status')->default('1');
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
        Schema::dropIfExists('messages');
    }
}
