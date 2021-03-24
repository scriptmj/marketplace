<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'items_offers';

    protected $fillable = [
        'price', 'user_id', 'item_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }

    public function isHighestOffer(){
        $highestOffer = Offer::where('item_id', $this->item_id)->max('price');
        
        return $highestOffer == $this->price;
    }
}
