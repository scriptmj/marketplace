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
        return view('profile.profile', ['user' => $user]);
    }

    public function viewItemsPosted(){
        $items = Item::where('user_id', Auth::user()->id)->get();
        //dd($items);
        return view('user.itemsposted', ['items' => $items]);
    }

    public function viewProfileItemsSold(User $user){
        if(Auth::user() == $user){
            return redirect(route('user.itemsposted'));
        } else {
            $items = Item::where('user_id', $user->id)
                ->where('sold', true)
                ->get();
            return view('profile.solditems', ['items' => $items]);
        }
    }

    public function viewProfileItemsPosted(User $user){
        if(Auth::user() == $user){
            return redirect(route('user.itemsposted'));
        } else {
            $items = Item::where('user_id', $user->id)->get();
            return view('profile.itemsposted', ['items' => $items]);
        }
    }

    public function viewBids(){
        $offers = Offer::where('user_id', Auth::user()->id)->get();
        return view('user.bids', ['offers' => $offers]);
    }

    public function cancelBid(Offer $offer){
        if(Auth::user()->isBidOwner($offer)){
            return view('item.cancelbid', ['offer' => $offer, 'item' => $offer->item]);
        } else {
            return view('error', ['error' => 'You cannot cancel someone else\'s bid']);
        }
    }

    public function destroyBid(Offer $offer){
        if(Auth::user()->isBidOwner($offer)){
            $offer->delete();
            return redirect(route('user.bids'));
        } else {
            return view('error', ['error' => 'You cannot cancel someone else\'s bid']);
        }
    }

    public function notifications(){
        $this->markNotificationsAsRead(Auth::user()->notifications);
        return view('user.notifications', ['notifications' => Auth::user()->notifications]);
    }

    private function markNotificationsAsRead($notifications){
        foreach($notifications as $notification){
            $notification->read = true;
            $notification->update();
        }
    }
}
