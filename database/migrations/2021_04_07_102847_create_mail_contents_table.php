<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('recipient');
            $table->unsignedBigInteger('sender')->nullable();
            $table->unsignedBigInteger('chat')->nullable();
            $table->unsignedBigInteger('item')->nullable();
            $table->unsignedBigInteger('notification')->nullable();
            $table->boolean('sent')->default(false);
        });

        Schema::table('mail_contents', function (Blueprint $table) {
            $table->foreign('recipient')->references('id')->on('users');
            $table->foreign('sender')->references('id')->on('users');
            $table->foreign('chat')->references('id')->on('chat_messages');
            $table->foreign('item')->references('id')->on('items');
            $table->foreign('notification')->references('id')->on('notifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_content');
    }
}
