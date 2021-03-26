<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id', 'message'];

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
