<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('price');
        });

        Schema::table('items_offers', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('items_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_offers');
    }
}
