<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Offer;
use App\Models\Notification;
use App\Models\Category;
use App\Models\MailContent;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ItemController extends Controller
{
    //Overview
    function home(){
        $items = Item::where('sold', false)->orderBy('created_at', 'DESC')->paginate(10);
        $categories = Category::get();
        $view = View::make('item.overview', ['items' => $items, 'categories' => $categories]);
        $sections = $view->renderSections();
        if(request()->ajax()){
            return $sections['content'];
        } else {
            return $sections['page'];
        }
    }

    //View each item
    function viewItem(Item $item){
        $item->times_viewed++;
        $item->update();
        return view('item.view', ['item' =>$item]);
    }

    //Create new item
    function create(){
        $categories = Category::get();
        return view('item.create', ['categories' => $categories]);
    }

    function store(){
        request()->merge(['user_id' => Auth::user()->id]);
        $this->validateItem();
        $this->validateImageFile();
        $item = new Item(request(['item_name', 'short_description', 'long_description', 'user_id', 'minimum_bid']));
        $item['image'] = request('image')->store('imagefiles');
        $item->save();
        $item->categories()->attach(request('categories'));
        return redirect(route('item.view', ['item' => $item]));
    }

    //Make bid
    function makeBid(Item $item){
        if(Auth::user()->isOwner($item)){
            return view('error', ['error' => "You cannot bid on your own items."]);
        } elseif($item->sold){
            return view('error', ['error' => "Item is already sold."]); 
        } else {
            return view('item.makebid', ['item' => $item]);
        }
    }

    function storeBid(Item $item){
        if(Auth::user()->isOwner($item)){
            return view('error', ['error' => "You cannot bid on your own items."]);
        } elseif($item->sold){
            return view('error', ['error' => "Item is already sold."]); 
        } else {
            $highestBid = $item->getHighestBidNumeric();
            $validMinimum = $highestBid != 0 ? $highestBid + 0.1 : $item->minimum_bid + 0.1;
            $this->validateBid($validMinimum);
            $offer = new Offer();
            $offer->price = request('bid');
            $offer->user_id = Auth::user()->id;
            $offer->item_id = $item->id;
            $offer->save();
            $message = Auth::user()->name." has offered €".number_format($offer->price, 2)." for your ".$item->item_name.".";
            $this->notifyUser($item, $item->user, $message);
            return redirect(route('item.view', ['item' => $item]));
        }
    }

    //See bids
    function bids(Item $item){
        if(Auth::user()->isOwner($item)){
            return view('item.bids', ['item' => $item]);
        } else {
            return view('error', ['error' => "You do not own this item."]);
        }
    }

    // Edit and update an item.
    function edit(Item $item){
        if(Auth::user()->isOwner($item)){
            $categories = Category::get();
            return view('item.edit', ['item' => $item, 'categories' => $categories]);
        } else {
            return view('error', ['error' => "You do not own this item."]);
        }
    }

    function update(Item $item){
        if(Auth::user()->isOwner($item)){
            request()->merge(['user_id' => $item->user_id]);
            $item->update($this->validateItem());
            $item->categories()->sync(request('categories'));
            if(request('image') !== null){
                $this->validateImageFile();
                $item['image'] = request('image')->store('imagefiles');
            }
            return redirect(route('item.view', ['item' =>$item]));
        } else {
            return view('error');
        }
    }

    // Mark item as sold
    function sold(Item $item){
        if(Auth::user()->isOwner($item)){
            return view('item.sold', ['item' =>$item]);
        } else {
            return view('error', ['error' => "You do not own this item."]); 
        }
    }

    function updateSold(Item $item){
        if(Auth::user()->isOwner($item)){
            if($item->getHighestBid() == null){
                return view('error', ['error' => "This item has no bids. If you've sold this item outside of this site, please delete the item instead."]);
            }
            if($item->sold){
                return view('error', ['error' => "This item is already marked as sold."]); 
            }
            $this->checkPriceForTax($item);
            $this->handleNotifications($item);
            $item->sold = true;
            $item->marked_as_sold = Carbon::now();
            $item->update();
            return redirect(route('item.view', ['item' =>$item]));
        } else {
            return view('error', ['error' => "You do not own this item."]); 
        }
    }

    private function checkPriceForTax(Item $item){
        $winningBid = $item->getHighestBid();
        if($winningBid->price > 500){
            $invoice = new Invoice();
            $invoice->user = $item->user->id;
            $invoice->item = $item->id;
            $invoice->price = round($winningBid->price/20, 2);
            $invoice->deadline = Carbon::now()->addMonthNoOverflow();
            $invoice->save();
            $message = 
                "You have sold ".$item->item_name." for over €500, which means you owe the platform 5% of your earnings. 
                For this item this means a charge of €".$invoice->price." is due within 30 days of this notification.
                Please view and pay your invoice via the 'Invoice' menu.";
            $this->notifyUser($item, $item->user, $message);
        }
    }

    function handleNotifications(Item $item){
        $buyer = $item->getHighestBid()->user;
        $allOffers = $item->offers;
        $allBuyers = new Collection();
        foreach($allOffers as $offer){
            if($offer->user == $buyer){
                continue;
            } elseif($allBuyers->contains($offer->user)){
                continue;
            } else {
                $allBuyers->push($offer->user);
            }
        }
        $messageToBuyer = "You were the highest bidder on the ".$item->item_name." and the seller has accepted your offer. You can contact the seller for further details on shipping and payment, if they haven't already contacted you.";
        $messageToOtherBidders = "The item ".$item->item_name." that you bid on has been sold to the highest bidder. Unfortunately your bid was not high enough, better luck next time.";
        $this->notifyUser($item, $item->getHighestBid()->user, $messageToBuyer);
        foreach($allBuyers as $user){
            $this->notifyUser($item, $user, $messageToOtherBidders);
        }
    }

    function notifyUser(Item $item, User $user, $message){
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->item_id = $item->id;
        $notification->message = $message;
        $notification->save();
        $this->prepareEmail($notification);
    }

    private function prepareEmail($notification){
        $mailContent = new MailContent();
        $mailContent->recipient = $notification->user_id;
        $mailContent->notification = $notification->id;
        $mailContent->item = $notification->item_id;
        $mailContent->save();
        return redirect(route('mail.send', $mailContent));
    }

    //Searches items within range of the user's personal postcode and given distance in KM.
    function searchByDistance(){
        $this->validateDistance(); //Validates distance input to avoid SQL Injection.
        $distance = request('distanceKm');
        $postcodesWithinRange = Auth::user()->postcode->getPostcodesByDistance($distance); //Gets all postcodes (id) within range.
        $usersWithinRange = User::whereIn('postcode_id', $postcodesWithinRange)->get(); //Gets all users within this postcode range.
        $userIDs = new Collection();
        foreach($usersWithinRange as $user){
            $userIDs->push($user->id); //Creates new collection with only ID's of users within range for iteration.
        }
        $itemsWithinRange = null;
        if($usersWithinRange->count() == 1){ //Different query needed for amount of users within range. Gets the items posted by these users.
            $itemsWithinRange = Item::where('user_id', $userIDs)->orderByDESC('created_at')->paginate(10);
        } else if($usersWithinRange->count() > 1){
            $itemsWithinRange = Item::whereIn('user_id', $userIDs)->orderByDESC('created_at')->paginate(10);
        }
        $categories = Category::get();
        $view = View::make('item.overview', ['items' => $itemsWithinRange, 'categories' => $categories]);
        $sections = $view->renderSections();
        return $sections['page'];
    }

    function searchByKeyword(){
        $keyword = $this->validateKeyword()['keyword']; //Validated the keyword
        $items = Item::where('item_name', 'like', '%'.$keyword.'%')->paginate(10); //Searches all items that contain the given word or letters
        $categories = Category::get();
        $view = View::make('item.overview', ['items' => $items, 'categories' => $categories]);
        $sections = $view->renderSections();
        return $sections['page'];
    }

    //Validators
    function validateItem(){
        return request()->validate([
            'item_name' => 'required|string|min:2',
            'short_description' => 'required|string|min:2',
            'long_description' => 'required|string|min:2',
            'minimum_bid' => 'numeric',
            'categories' => 'exists:categories,id',
        ]);
    }

    function validateImageFile(){
        return request()->validate([
            'image' => 'required','file','image',
        ]);
    }

    function validateBid($validMinimum){
        return request()->validate([
            'bid' => 'required|numeric|min:'.$validMinimum,
        ]);
    }

    function validateDistance(){
        return request()->validate([
            'distanceKm' => 'required|numeric',
        ]);
    }
    function validateKeyword(){
        return request()->validate([
            'keyword' => 'required|string',
        ]);
    }
}

