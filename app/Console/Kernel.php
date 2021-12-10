<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Api\NotificationController;
use App\User;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\GeneralNotification',
        'App\Console\Commands\AchievementNotification',
        'App\Console\Commands\DiaryNotification',
        'App\Console\Commands\MissionNotification',


        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('achievement-notification')->dailyAt('9:00');  
        // $schedule->command('diary-notification')->dailyAt('16:00');     
        $schedule->command('general-notification')->dailyAt('10:00'); 
        // $schedule->command('mission-notification')->dailyAt('18:00');

        $users=User::where('status','!=',2)
                ->where('role', 2)
                ->get();

        foreach ($users as  $user) {

            $diary_remainder_time = ($user->notification!=null && $user->notification->diary_remainder_time!=null) ? $user->notification->diary_remainder_time : '18:30';
            $mission_remainder_time = ($user->notification!=null && $user->notification->mission_remainder_time!=null) ? $user->notification->mission_remainder_time : '8:00';
            $schedule->command('diary-notification',[$user->id])->timezone('Asia/Kolkata')->dailyAt($diary_remainder_time); 
            $schedule->command('mission-notification',[$user->id])->timezone('Asia/Kolkata')->dailyAt($mission_remainder_time);     
        }



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
