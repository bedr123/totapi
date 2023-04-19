<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistics;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersCollection;
use Illuminate\Database\Query\Builder;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',  ['except' => ['getLeaderboard']]);
    }

    public function updateStatistics(Request $request)
    {
        $user = Auth::user();

        $user->statistics->update([
            'overall_played' => $request->gamesPlayed,
            'overall_win_percentage' => $request->winPercentage,
            'overall_current_streak' => $request->currentStreak,
            'overall_max_streak' => $request->maxStreak,
            'overall_guess_ditribution' => $request->guesses,
            'overall_average_guesses' => $request->averageGuesses,
            'overall_games_won' => $request->gamesWon,
            'overall_lost_in_a_row' => $request->lostInARow ? $request->lostInARow : 0,
            'overall_played_this_month' => $request->playedThisMonth ? $request->playedThisMonth : false,
            'overall_played_last_month' => $request->playedLastMonth ? $request->playedLastMonth : false,
        ]);

        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    public function resetMonthlyStatistics()
    {
        $user = Auth::user();

        $user->statistics->update([
            'monthly_average_guesses' => 0,
            'monthly_games_won' => 0,
            'monthly_played' => 0,
            'monthly_win_percentage' => 0,
            'monthly_current_streak' => 0,
            'monthly_max_streak' => 0,
            'monthly_lost_in_a_row' => 0,
            'monthly_guess_ditribution' => [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                'fail' => 0
            ]
        ]);

        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    public function getLeaderboard()
    {
        $users = User::join('statistics', 'users.id', '=', 'statistics.user_id')->orderBy('statistics.overall_current_streak', 'desc')->orderBy('statistics.overall_games_won', 'desc')->select('users.*')->take(5)->get();

        return UserResource::collection($users);
    }

    public function getLeader()
    {
        $user = User::join('statistics', 'users.id', '=', 'statistics.user_id')->orderBy('statistics.overall_max_streak', 'desc')->orderBy('statistics.overall_games_won', 'desc')->select('users.*')->first();

        return response()->json([
            'user' => new UserResource($user)
        ]);
    }
}
