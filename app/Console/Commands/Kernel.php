<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Vérifier les stocks bas tous les jours à 8h00
        $schedule->command('stock:check')
            ->dailyAt('08:00')
            ->timezone('Africa/Djibouti')
            ->emailOutputOnFailure('admin@example.com'); // Optionnel

        // Vous pouvez aussi ajouter d'autres tâches planifiées
        // $schedule->command('inspire')->hourly();

        // Nettoyer les vieilles alertes (plus de 30 jours)
        $schedule->call(function () {
            \App\Models\Alerte::where('created_at', '<', now()->subDays(30))->delete();
        })->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}