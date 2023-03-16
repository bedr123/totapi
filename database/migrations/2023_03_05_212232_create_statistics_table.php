<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('overall_played');
            $table->integer('overall_win_percentage');
            $table->integer('overall_current_streak');
            $table->integer('overall_max_streak');
            $table->string('overall_guess_ditribution');
            $table->integer('monthly_played');
            $table->integer('monthly_win_percentage');
            $table->integer('monthly_current_streak');
            $table->integer('monthly_max_streak');
            $table->string('monthly_guess_ditribution');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('statistics');
    }
};
