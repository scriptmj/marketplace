<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ItemController extends Controller
{
    //Overview
    function home(){
        $items = Item::where('sold', false)->orderBy('created_at', 'DESC')->get();
        return view('item.overview', ['items' => $items]);
    }

    //View each item
    function viewItem(Item $item){
        $item->times_viewed++;
        $item->update();
        return view('item.view', ['item' =>$item]);
    }

    //Create new item
    function create(){
        return view('item.create');
    }

    function store(){
        request()->merge(['user_id' => Auth::user()->id]);
        $this->validateItem();
        $this->validateImageFile();
        $item = new Item(request(['item_name', 'short_description', 'long_description', 'user_id', 'minimum_bid']));
        $item['image'] = request('image')->store('imagefiles');
        $item->save();
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
            //TODO: Minimum not validated
            //dd(request());
            $offer = new Offer();
            $offer->price = request('bid');
            $offer->user_id = Auth::user()->id;
            $offer->item_id = $item->id;
            $offer->save();
            return redirect(route('item.view', ['item' => $item]));
            //dd("Correct bid");
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
            return view('item.edit', ['item' => $item]);
        } else {
            return view('error', ['error' => "You do not own this item."]);
        }
    }

    function update(Item $item){
        if(Auth::user()->isOwner($item)){
            request()->merge(['user_id' => $item->user_id]);
            $item->update($this->validateItem());
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
            if($item->sold){
                return view('error', ['error' => "This item is already marked as sold."]); 
            }
            $item->sold = true;
            $item->marked_as_sold = Carbon::now();
            $item->update();
            return redirect(route('item.view', ['item' =>$item]));
        } else {
            return view('error', ['error' => "You do not own this item."]); 
        }
    }

    //Validators
    function validateItem(){
        return request()->validate([
            'item_name' => 'required|string|min:2',
            'short_description' => 'required|string|min:2',
            'long_description' => 'required|string|min:2',
            'minimum_bid' => 'numeric',
        ]);
    }

    function validateImageFile(){
        return request()->validate([
            'image' => 'required','file','image',
        ]);
    }

    function validateBid($validMinimum){
        return request()->validate([
            'bid' =>    'required|numeric|min:'.$validMinimum,
        ]);
    }
}

