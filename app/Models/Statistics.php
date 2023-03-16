<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory;

    protected $table = 'statistics';

    protected $fillable = [
        'user_id',
        'overall_played',
        'overall_win_percentage',
        'overall_current_streak',
        'overall_max_streak',
        'overall_guess_ditribution',
        'overall_average_guesses',
        'overall_games_won',
        'overall_lost_in_a_row',
        'overall_played_this_month',
        'overall_played_last_month',
        'monthly_played',
        'monthly_win_percentage',
        'monthly_current_streak',
        'monthly_max_streak',
        'monthly_guess_ditribution',
        'monthly_average_guesses',
        'monthly_games_won',
        'monthly_lost_in_a_row'
    ];

    protected $casts = [
        'overall_guess_ditribution' => 'array',
        'monthly_guess_ditribution' => 'array'
    ];
}
