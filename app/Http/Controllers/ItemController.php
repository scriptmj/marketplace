<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    function home(){
        $items = Item::get();
        return view('item.overview', ['items' => $items]);
    }

    function viewItem(Item $item){
        return view('item.view', ['item' =>$item]);
    }
}
