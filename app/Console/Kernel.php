<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //cleans all backups Monthly
        $schedule->call('\App\Http\Controllers\BookingController@completedBookings')->everyMinute();
        //cleans all backups Monthly
        $schedule->call('\App\Http\Controllers\BookingController@reminder')->everyMinute();
        //cleans all backups Monthly
        $schedule->call('\App\Http\Controllers\BackupController@destroy')->monthly();
        //makes all backups Daily
        $schedule->call('\App\Http\Controllers\BackupController@dbBackup')->daily();
        // Send reports weekly to company members
        $schedule->call('\App\Http\Controllers\CompanyController@sendReports')->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
