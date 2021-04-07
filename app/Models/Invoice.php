<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user', 'price', 'deadline', 'paid', 'paid_on', 'item'];

    public function getUser(){
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    public function getItem(){
        return $this->belongsTo('App\Models\Item', 'item', 'id');
    }
}
