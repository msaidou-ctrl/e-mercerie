<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Jobs\SendWebPush;
// use Illuminate\Notifications\Messages\MailMessage; // 🔕 Mail désactivé
use App\Models\User;

class MerchantFirstSupply extends Notification
{
    use Queueable;

    protected $merchant;

    public function __construct(User $merchant)
    {
        $this->merchant = $merchant;
    }

    public function via($notifiable)
    {
        // On conserve la base (database). Le mail reste désactivé — on utilisera web-push.
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'merchant_id' => $this->merchant->id,
            'merchant_name' => $this->merchant->display_business_name,
            'message' => "La mercerie {$this->merchant->display_business_name} a ajouté sa première fourniture.",
        ];
    }

    public function toMail($notifiable)
    {
        // Mail volontairement commenté : l'envoi d'email est désactivé pour ce type
        // return (new MailMessage)
        //             ->subject('Nouvelle mercerie active')
        //             ->line("La mercerie {$this->merchant->display_business_name} a ajouté sa première fourniture.")
        //             ->action('Voir mercerie', url(route('merceries.show', $this->merchant->id, false)));
    }

    /**
     * Envoie une notification Web Push via la job SendWebPush
     */
    public function sendWebPushNotification($notifiable)
    {
        $payload = [
            'title' => 'Nouvelle mercerie active',
            'body' => "La mercerie {$this->merchant->display_business_name} a ajouté sa première fourniture.",
            'url' => route('merceries.show', $this->merchant->id),
            'icon' => '/icon.png',
            'data' => ['merchant_id' => $this->merchant->id],
        ];

        // Dispatch la job pour envoyer les notifications push
        SendWebPush::dispatch($payload, $notifiable->id);
    }
}
