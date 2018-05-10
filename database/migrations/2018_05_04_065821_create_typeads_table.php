<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typeads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid');
            $table->string('img');
            $table->string('title');
            $table->tinyInteger("type");
            $table->string('href');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('typeads');
    }
}
