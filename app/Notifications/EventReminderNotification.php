<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class EventReminderNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $start = Carbon::parse($this->event->start_date . ' ' . $this->event->start_time);
        $end   = Carbon::parse($this->event->end_date . ' ' . $this->event->end_time);

        $ics = "BEGIN:VCALENDAR
            VERSION:2.0
            BEGIN:VEVENT
            SUMMARY:{$this->event->title}
            DTSTART:" . $start->format('Ymd\THis') . "
            DTEND:" . $end->format('Ymd\THis') . "
            DESCRIPTION:{$this->event->description}
            URL:" . url('/events/' . $this->event->id) . "
            END:VEVENT
            END:VCALENDAR";

        return (new MailMessage)
            ->subject('Reminder: Event in 7 Days')
            ->line("Event: {$this->event->title}")
            ->line("Date: {$this->event->start_date} at {$this->event->start_time}")
            ->action('View Event', url('/events/' . $this->event->id))
            ->line('Add this event to your calendar:')
            ->attachData($ics, 'event.ics', [
                'mime' => 'text/calendar',
            ])
            ->line('Thank you!');
    }
}
