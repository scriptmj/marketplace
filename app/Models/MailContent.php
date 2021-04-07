<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient',
        'sender',
        'chat',
        'item',
        'sent',
        'notification',
    ];
    
    public function getRecipient(){
        return $this->belongsTo('App\Models\User', 'recipient', 'id');
    }

    public function getItem(){
        return $this->belongsTo('App\Models\Item', 'item', 'id');
    }
    
    public function getNotification(){
        return $this->belongsTo('App\Models\Notification', 'notification', 'id');
    }

    public function getSender(){
        return $this->belongsTo('App\Models\User', 'sender', 'id');
    }
    
    public function getChat(){
        return $this->belongsTo('App\Models\ChatMessage', 'chat', 'id');
    }

}