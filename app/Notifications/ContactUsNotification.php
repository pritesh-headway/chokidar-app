<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsNotification extends Notification
{
    use Queueable;

    protected $contactUsData;

    /**
     * Create a new notification instance.
     */
    public function __construct($contactUsData)
    {
        $this->contactUsData = $contactUsData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('New contact us submission received.')
            ->line('Name: ' . $this->contactUsData['full_name'])
            ->line('Email: ' . $this->contactUsData['email'])
            ->line('Phone: ' . $this->contactUsData['phone_number'])
            ->line('Comments: ' . $this->contactUsData['comments'])
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'society_name' => $this->contactUsData['society_name'],
            'country' => $this->contactUsData['country'],
            'city' => $this->contactUsData['city'],
            'full_name' => $this->contactUsData['full_name'],
            'email' => $this->contactUsData['email'],
            'phone_number' => $this->contactUsData['phone_number'],
            'comments' => $this->contactUsData['comments'],
        ];
    }
}
