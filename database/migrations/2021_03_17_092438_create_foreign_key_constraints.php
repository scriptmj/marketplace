<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        // Schema::table('', function (Blueprint $table) {
        //     $table->foreignId('')->constrained();
        // });
        // Schema::table('', function (Blueprint $table) {
        //     $table->foreignId('')->constrained();
        // });
        // Schema::table('', function (Blueprint $table) {
        //     $table->foreignId('')->constrained();
        // });
        // Schema::table('', function (Blueprint $table) {
        //     $table->foreignId('')->constrained();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function(Blueprint $table){
            $table->dropForeign('user_id');
        });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
        // Schema::table('', function(Blueprint $table){
        //     $table->dropForeign('');
        // });
    }
}
