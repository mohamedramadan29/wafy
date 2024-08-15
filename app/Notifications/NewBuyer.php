<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBuyer extends Notification
{
    use Queueable;

    public $seller_id, $seller_name;
    public $buyer_id, $buyer_name;
    public $transaction_id, $transaction_title, $transaction_slug;

    public function __construct($seller_id, $seller_name, $buyer_id, $buyer_name, $transaction_id, $transaction_title, $transaction_slug)
    {
        $this->seller_id = $seller_id;
        $this->seller_name = $seller_name;
        $this->buyer_id = $buyer_id;
        $this->buyer_name = $buyer_name;
        $this->transaction_id = $transaction_id;
        $this->transaction_title = $transaction_title;
        $this->transaction_slug = $transaction_slug;
    }
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'seller_id' => $this->seller_id,
            'seller_name' => $this->seller_name,
            'buyer_id' => $this->buyer_id,
            'buyer_name' => $this->buyer_name,
            'transaction_id' => $this->transaction_id,
            'transaction_title' => $this->transaction_title,
            'transaction_slug' => $this->transaction_slug,
            'title' => '   لديك طلب شراء من     '
        ];
    }
}
