<?php
namespace App\Notifications;

use App\Models\FitnessClass;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCancelled extends Notification
{
    use Queueable;

    public $fitnessClass;

    public function __construct(FitnessClass $fitnessClass)
    {
        $this->fitnessClass = $fitnessClass;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your booking has been cancelled.')
            ->line('Class: ' . $this->fitnessClass->title)
            ->line('Start: ' . $this->fitnessClass->start_time)
            ->action('View Other Classes', url('/available-classes'))
            ->line('We hope to see you in another class!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Booking cancelled for: ' . $this->fitnessClass->title,
        ];
    }
}
