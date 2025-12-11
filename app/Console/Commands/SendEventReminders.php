<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\EventReminderNotification;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';
    protected $description = 'Send event reminders 7 days before event';

    public function handle()
    {
        $targetDate = Carbon::today()->addDays(7);

        $events = Event::whereDate('start_date', $targetDate)->get();

        foreach ($events as $event) {
            foreach (User::all() as $user) { 
                $user->notify(new EventReminderNotification($event));
            }
        }

        return Command::SUCCESS;
    }
}
