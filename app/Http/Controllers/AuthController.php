<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Statistics;
use App\Utils\Roles;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'googleLogin', 'facebookLogin']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        if (!User::where('email', $request->email)->where('google_id', null)->where('facebook_id', null)->first()) {
            // $user = User::create([
            //     'username' => explode('@', $request->email)[0],
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            //     'role' => Roles::user_role
            // ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'token' => $token,
                'type' => 'bearer',
            ]);

    }

    public function googleLogin(Request $request, $token)
    {
        $googleUser = Socialite::driver('google')->userFromToken($token);
 
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'email' => $googleUser->email,
                'username' => explode('@', $googleUser->email)[0],
                'role' => Roles::user_role
            ]);

            Statistics::create([
                'user_id' => $user->id,
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
        }
     
        $token = Auth::login($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }

    public function facebookLogin(Request $request, $token)
    {
        $facebookUser = Socialite::driver('facebook')->userFromToken($token);
 
        $user = User::where('facebook_id', $facebookUser->id)->first();

        if (!$user) {
            $user = User::create([
                'name' => $facebookUser->name,
                'facebook_id' => $facebookUser->id,
                'email' => $facebookUser->email,
                'username' => explode('@', $facebookUser->email)[0],
                'role' => Roles::user_role
            ]);

            Statistics::create([
                'user_id' => $user->id,
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
        }
     
        $token = Auth::login($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }

    public function me() {
        $user = Auth::user();

        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    // public function register(Request $request){
    //     $request->validate([
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6',
    //     ]);



    //     $token = Auth::login($user);
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'User created successfully',
    //         'user' => $user,
    //         'authorisation' => [
    //             'token' => $token,
    //             'type' => 'bearer',
    //         ]
    //     ]);
    // }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
