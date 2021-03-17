<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shortDescription',
        'longDescription'
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

    public function advertiser(){
        return $this->belongsTo('App\Models\Advertiser');
    }
}
