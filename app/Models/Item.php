<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'short_description',
        'long_description',
        'image',
        'user_id',
        'minimum_bid',
    ];

    public function highestBid(){
        $allOffers = Offer::where('item_id', $this->id)->get();
        if($allOffers->isNotEmpty()){
            $sortedOffers = $allOffers->sortByDesc('price');
            $priceFormatted = "€" . $sortedOffers->first()->price;
            return $priceFormatted;
        } else {
            return "No offers";
        }
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getImageAttribute($value){
        if(Str::contains($value, 'https')){
            return $value;
        } else {
            return asset('storage/'.$value);
        }
    }
}
