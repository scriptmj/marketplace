<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Create4pp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path('sql\4pp.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('postcode_id')->references('id')->on('4pp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('4pp');
    }
}
