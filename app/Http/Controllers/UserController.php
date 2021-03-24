<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
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
}
