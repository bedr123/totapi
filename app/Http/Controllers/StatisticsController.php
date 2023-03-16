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
            'overall_played' => $request->overall['gamesPlayed'],
            'overall_win_percentage' => $request->overall['winPercentage'],
            'overall_current_streak' => $request->overall['currentStreak'],
            'overall_max_streak' => $request->overall['maxStreak'],
            'overall_guess_ditribution' => $request->overall['guesses'],
            'overall_average_guesses' => $request->overall['averageGuesses'],
            'overall_games_won' => $request->overall['gamesWon'],
            'overall_lost_in_a_row' => $request->overall['lostInARow'],
            'overall_played_this_month' => $request->overall['playedThisMonth'],
            'overall_played_last_month' => $request->overall['playedLastMonth'],
            'monthly_played' => $request->monthly['gamesPlayed'],
            'monthly_win_percentage' => $request->monthly['winPercentage'],
            'monthly_current_streak' => $request->monthly['currentStreak'],
            'monthly_max_streak' => $request->monthly['maxStreak'],
            'monthly_guess_ditribution' => $request->monthly['guesses'],
            'monthly_average_guesses' => $request->monthly['averageGuesses'],
            'monthly_games_won' => $request->monthly['gamesWon'],
            'monthly_lost_in_a_row' => $request->monthly['lostInARow'],
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
        $users = User::join('statistics', 'users.id', '=', 'statistics.user_id')->orderBy('statistics.overall_games_won', 'desc')->orderBy('statistics.overall_current_streak', 'desc')->select('users.*')->take(5)->get();

        return UserResource::collection($users);
    }
}
