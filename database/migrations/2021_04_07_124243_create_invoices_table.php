<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item_id');
            $table->float('price');
            $table->timestamp('deadline')->nullable();
            $table->boolean('paid')->default(false);
            $table->timestamp('paid_on')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->boolean('item_promotion')->default(false);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
