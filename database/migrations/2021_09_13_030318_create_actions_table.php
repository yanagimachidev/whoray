<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('objective_id');
            $table->foreign('objective_id')->references('id')->on('objectives');
            $table->unsignedBigInteger('key_result_id');
            $table->foreign('key_result_id')->references('id')->on('key_results');
            $table->string('name');
            $table->string('status')->default('積み上げ中');
            $table->string('unit');
            $table->unsignedInteger('experience')->default(0);
            $table->unsignedBigInteger('count')->default(0);
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
        Schema::dropIfExists('actions');
    }
}
