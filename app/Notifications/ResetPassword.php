<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Username for user.
     *
     * @var string
     */
    public $username;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('info@droitpourlepraticien.ch', 'Droit pour le praticien')
            ->subject('Droit pour le praticien | Réinitialisation de mot de passe')
            ->greeting('Bonjour,')
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.
réinitialiser le mot de passe')
            ->action('Réinitialiser le mot de passe', url('password/reset', $this->token))
            ->line('Ce lien de réinitialisation du mot de passe expirera dans 60 minutes. Si vous n\'avez pas demandé de réinitialisation de mot de passe aucune autre action n\'est requise.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
