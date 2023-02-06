<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Picture;

class CurrentPic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current:pic';

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
        $picture = Picture::where('is_current', true)->first();

        if ($picture) {
            $newPicture = Picture::where('id', '>', $picture->id)->first();

            if ($newPicture) {
                $picture->is_current = false;
                $picture->save();

                $newPicture->is_current = true;
                $newPicture->save();
            }
        }

        return Command::SUCCESS;
    }
}
