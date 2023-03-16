<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Statistics;

class CalendarCrown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:crown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time = Carbon::now();

        if ($time->day == 1) {
            Statistics::where('overall_played_this_month', true)->update([
                'overall_played_last_month' => true
            ]);
            info('calendar ');
        }

        return Command::SUCCESS;
    }
}
