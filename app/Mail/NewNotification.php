<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailContent;
use App\Models\User;
use App\Models\Item;
use App\Models\Notification;

class NewNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MailContent $mailContent)
    {
        $this->mailContent = $mailContent;
        // $this->recipient = User::find($mailContent->recipient);
        // $this->notification = Notification::find($mailContent->notification);
        // $this->item = Item::find($mailContent->item);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newnotificationmail')
            ->with([
                'mailContent' => $this->mailContent,
                //  'recipient' => $this->recipient, 
                //  'notification' => $this->notification, 
                //  'item' => $this->item,
                ]);
    }
}
