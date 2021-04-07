<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MailContent;
use App\Models\User;
use App\Models\Item;
use App\Models\ChatMessage;

class NewMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MailContent $mailContent)
    {
        $this->recipient = User::find($mailContent->recipient);
        $this->sender = User::find($mailContent->sender);
        $this->chat = ChatMessage::find($mailContent->chat);
        $this->item = Item::find($mailContent->item);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newmessagemail')
            ->with([
                 'recipient' => $this->recipient, 
                 'sender' => $this->sender,
                 'chat' => $this->chat, 
                 'item' => $this->item
                ]);
    }
}
