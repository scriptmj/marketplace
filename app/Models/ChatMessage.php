<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = ['to', 'from', 'item_ref', 'message'];

    public function item(){
        return $this->belongsTo('App\Models\Item', 'item_ref', 'id');
    }
    
    public function fromUser(){
        return $this->belongsTo('App\Models\User', 'from', 'id');
    }

    public function toUser(){
        return $this->belongsTo('App\Models\User', 'to', 'id');
    }
}
