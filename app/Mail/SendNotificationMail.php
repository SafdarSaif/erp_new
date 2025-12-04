<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class SendNotificationMail extends Mailable implements NotTenantAware
{
    use Queueable, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($this->notification->title)
                    ->view('emails.notification')
                    ->with([
                        'title' => $this->notification->title,
                        'description' => $this->notification->description,
                        'header' => $this->notification->header,
                    ]);
    }
}
