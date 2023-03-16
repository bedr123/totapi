<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'overall_played' => $this->overall_played,
            'overall_win_percentage' => $this->overall_win_percentage,
            'overall_current_streak' => $this->overall_current_streak,
            'overall_max_streak' => $this->overall_max_streak,
            'overall_guess_ditribution' => $this->overall_guess_ditribution,
            'overall_average_guesses' => $this->overall_average_guesses,
            'overall_games_won' => $this->overall_games_won,
            'overall_lost_in_a_row' => $this->overall_lost_in_a_row,
            'overall_played_this_month' => boolval($this->overall_played_this_month),
            'overall_played_last_month' => boolval($this->overall_played_last_month),
            'monthly_played' => $this->monthly_played,
            'monthly_win_percentage' => $this->monthly_win_percentage,
            'monthly_current_streak' => $this->monthly_current_streak,
            'monthly_max_streak' => $this->monthly_max_streak,
            'monthly_guess_ditribution' => $this->monthly_guess_ditribution,
            'monthly_average_guesses' => $this->monthly_average_guesses,
            'monthly_games_won' => $this->monthly_games_won,
            'monthly_lost_in_a_row' => $this->monthly_lost_in_a_row
        ];
    }
}
