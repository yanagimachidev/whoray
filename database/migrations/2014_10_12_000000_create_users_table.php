<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('profile_text')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('profile_mini_image')->nullable();
            $table->string('profile_bg_image')->nullable();
            $table->string('profile_bg_mini_image')->nullable();
            $table->string('experience')->nullable()->default(0);
            $table->string('study_experience')->nullable()->default(0);
            $table->string('bodymake_experience')->nullable()->default(0);
            $table->string('business_experience')->nullable()->default(0);
            $table->string('money_experience')->nullable()->default(0);
            $table->string('hobby_experience')->nullable()->default(0);
            $table->string('life_experience')->nullable()->default(0);
            $table->string('other_experience')->nullable()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
