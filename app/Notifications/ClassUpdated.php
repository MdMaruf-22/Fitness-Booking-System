<?php
namespace App\Notifications;

use App\Models\FitnessClass;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ClassUpdated extends Notification
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
            ->line('A class you booked has been updated.')
            ->line('New Start: ' . $this->fitnessClass->start_time)
            ->line('Title: ' . $this->fitnessClass->title)
            ->action('View Class', url('/my-bookings'))
            ->line('Thanks for staying updated!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Class updated: ' . $this->fitnessClass->title,
        ];
    }
}
