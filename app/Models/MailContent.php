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
}