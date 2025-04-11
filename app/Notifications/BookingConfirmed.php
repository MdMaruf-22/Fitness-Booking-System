<?php
namespace App\Notifications;

use App\Models\FitnessClass;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmed extends Notification
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
                    ->line('Your booking is confirmed!')
                    ->line('Class: ' . $this->fitnessClass->title)
                    ->line('Start: ' . $this->fitnessClass->start_time)
                    ->action('View My Bookings', url('/my-bookings'))
                    ->line('Thanks for booking with us!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Booking confirmed for: ' . $this->fitnessClass->title,
        ];
    }
}
