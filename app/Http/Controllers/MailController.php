<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\MailContent;
use App\Models\User;
use App\Models\Item;
use App\Models\ChatMessage;
use App\Mail\NewMessage;
use App\Mail\NewNotification;

class MailController extends Controller
{
    public function sendMailNewMessage(MailContent $mailContent){
        $message = new NewMessage($mailContent);
        Mail::to($message->recipient->email)->send($message);
        $mailContent->sent = true;
        $mailContent->update();
    }

    public function sendMailNewNotification(MailContent $mailContent){
        $message = new NewNotification($mailContent);
        Mail::to($message->recipient->email)->send($message);
        $mailContent->sent = true;
        $mailContent->update();
    }
}

