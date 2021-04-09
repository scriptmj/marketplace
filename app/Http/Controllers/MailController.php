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

    public function sendMail(MailContent $mailContent){
        if($mailContent->sent == false){
            if($mailContent->notification != null){
                $message = new NewNotification($mailContent);
                Mail::to($mailContent->getRecipient->email)->send($message);
                $mailContent->sent = true;
                $mailContent->update();
            } elseif($mailContent->chat != null){
                $message = new NewMessage($mailContent);
                Mail::to($mailContent->getRecipient->email)->send($message);
                $mailContent->sent = true;
                $mailContent->update();
            }
        }
    }
}
