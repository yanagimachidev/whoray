<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('objective_id');
            $table->foreign('objective_id')->references('id')->on('objectives');
            $table->unsignedBigInteger('key_result_id');
            $table->foreign('key_result_id')->references('id')->on('key_results');
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->date('action_date');
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
        Schema::dropIfExists('experiences');
    }
}
