<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    function home(){
        $items = Item::get();
        return view('item.overview', ['items' => $items]);
    }

    function viewItem(Item $item){
        $item->times_viewed++;
        $item->update();
        return view('item.view', ['item' =>$item]);
    }

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
        return redirect(route('view.item', ['item' => $item]));
    }

    function validateItem(){
        return request()->validate([
            'item_name' => 'required|string|min:2',
            'short_description' => 'required|string|min:2',
            'long_description' => 'required|string|min:2',
            'minimum_bid' => 'integer',
        ]);
    }

    function validateImageFile(){
        return request()->validate([
            'image' => 'required','file','image',
        ]);
    }
}
