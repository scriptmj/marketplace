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

    public function highestBidFormatted(){
        $highestBid = $this->getHighestBid();
        if($highestBid != null){
            $priceFormatted = "€" . number_format($highestBid->price, 2);
            return $priceFormatted;
        } else {
            return "No offers";
        }
    }

    public function getHighestBidNumeric(){
        $highestBid = $this->getHighestBid();
        if($highestBid != null){
            return $highestBid->price;
        } else {
            return 0;
        }
    }

    public function getHighestBid(){
        $allOffers = Offer::where('item_id', $this->id)->get();
        if($allOffers->isNotEmpty()){
            $sortedOffers = $allOffers->sortByDesc('price');
            return $sortedOffers->first();
        } else {
            return null;
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

    public function offers(){
        return $this->hasMany('App\Models\Offer');
    }

    public function offersOrdered(){
        return Offer::where('item_id', $this->id)->orderBy('price', 'DESC')->get();
    }

    public function isSold(){
        return $this->sold ? "Yes" : "No";
    }

    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }
}
