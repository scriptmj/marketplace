<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function viewProfile(User $user){
        return view('user.profile', ['user' => $user]);
    }

    public function viewItemsPosted(){
        $items = Item::where('user_id', Auth::user()->id)->get();
        //dd($items);
        return view('user.itemsposted', ['items' => $items]);
    }

    public function viewBids(){
        $offers = Offer::where('user_id', Auth::user()->id)->get();
        return view('user.bids', ['offers' => $offers]);
    }

    public function cancelBid(Offer $offer){
        return view('item.cancelbid', ['offer' => $offer, 'item' => $offer->item]);
    }

    public function destroyBid(Offer $offer){
        $offer->delete();
        return redirect(route('user.bids'));
    }
}
