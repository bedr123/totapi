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
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('monthly_played');
            $table->dropColumn('monthly_win_percentage');
            $table->dropColumn('monthly_current_streak');
            $table->dropColumn('monthly_max_streak');
            $table->dropColumn('monthly_guess_ditribution');
            $table->dropColumn('monthly_average_guesses');
            $table->dropColumn('monthly_games_won');
            $table->dropColumn('monthly_lost_in_a_row');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
