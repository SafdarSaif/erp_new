<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Mail\SendNotificationMail;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class SendNotificationJob implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notificationId;
    public $email;
    protected $tries = 5;
    public function __construct($notificationId, $email)
    {

        $this->notificationId = $notificationId;
        $this->email = $email;
    }

    public function handle()
    {
        try {

            // Load fresh notification from DB (queued jobs require this)
            $notification = Notification::find($this->notificationId);
            // dd(!$notification );
            if (!$notification) {
                \Log::error("Notification not found ID: {$this->notificationId}");
                return;
            }

            Mail::to($this->email)->send(
                new SendNotificationMail($notification)
            );
            \Log::info("Notification email sent to: {$this->email}");
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}
