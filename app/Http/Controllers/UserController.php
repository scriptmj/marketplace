<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Offer;
use App\Models\ChatMessage;
use App\Models\MailContent;
use App\Models\Invoice;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{

    //View user profile
    public function viewProfile(User $user){
        return view('profile.profile', ['user' => $user]);
    }

    //View a logged in user's posted items, including sold ones.
    public function viewItemsPosted(){
        $items = Item::where('user_id', Auth::user()->id)->get();
        return view('user.itemsposted', ['items' => $items]);
    }

    //View another user's sold items
    public function viewProfileItemsSold(User $user){
        if(Auth::user() == $user){
            return redirect(route('user.itemsposted'));
        } else {
            $items = Item::where('user_id', $user->id)
                ->where('sold', true)
                ->orderBy('marked_as_sold', 'DESC')
                ->get();
            return view('profile.solditems', ['items' => $items]);
        }
    }

    //View another user's posted items which aren't sold yet
    public function viewProfileItemsPosted(User $user){
        if(Auth::user() == $user){
            return redirect(route('user.itemsposted'));
        } else {
            $items = Item::where('user_id', $user->id)->get();
            return view('profile.itemsposted', ['items' => $items]);
        }
    }

    //View bids on an item if the user is logged in and owns the item
    public function viewBids(){
        $offers = Offer::where('user_id', Auth::user()->id)->get();
        return view('user.bids', ['offers' => $offers]);
    }

    //Cancel your running bid
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

    //View your notifications
    public function notifications(){
        $this->markAsRead(Auth::user()->notifications, true);
        return view('user.notifications', ['notifications' => Auth::user()->notifications]);
    }

    //Compose a new message to a user
    public function composeMessage(User $user, Item $item){
        return view('user.composemessage', ['user' => $user, 'item' => $item]);
    }

    public function sendMessage(User $user, Item $item){
        $fromUser = Auth::user();
        $chat = new ChatMessage();
        $chat->to = $user->id;
        $chat->from = $fromUser->id;
        $chat->message = request('message');
        $chat->item_ref = $item->id;
        $chat->save();
        $this->prepareEmail($chat);
        return redirect(route('profile.view', $user));
    }
    //Sends an e-mail to the other user after sending a message to them
    private function prepareEmail($chat){
        $mailContent = new MailContent();
        $mailContent->recipient = $chat->to;
        $mailContent->sender = $chat->from;
        $mailContent->chat = $chat->id;
        $mailContent->item = $chat->item_ref;
        $mailContent->save();
        return redirect(route('mail.send', $mailContent));
    }
    
    //View your own messages by user interaction
    public function getMessages(){
        $userInteractions = Auth::user()->getAllUserInteractions();
        foreach($userInteractions as $user){
            $user->lastMessage = $user->getLastMessageByUser(Auth::user()->id, $user->id);
        }
        return view('user.messages', ['userInteractions' => $userInteractions]);
    }

    public function viewMessage(User $user){
        return view('user.viewmessagehistory', ['messages' => $this->getMessageHistoryByUser(Auth::user(), $user)]);
    }

    //View message history from one user
    private function getMessageHistoryByUser(User $LoggedUser, User $otherUser){
        $messages = new Collection();
        $fromLoggedUser = ChatMessage::where('from', $LoggedUser->id)->where('to', $otherUser->id)->orderBy('created_at', 'DESC')->get();
        $fromOtherUser = ChatMessage::where('from', $otherUser->id)->where('to', $LoggedUser->id)->orderBy('created_at', 'DESC')->get();
        foreach($fromLoggedUser as $message){
            $messages->push($message);
        }
        foreach($fromOtherUser as $message){
            if(!$message->read){
                $this->markAsRead($message, false);
            }
            $messages->push($message);
        }
        $sortedMessages = $messages->sortByDesc('created_at');
        return $sortedMessages;
    }

    //Marks item as read when user reads the message or notification
    private function markAsRead($item, $isCollection){
        if($isCollection){
            foreach($item as $i){
                if(!$i->read){
                    $i->read = true;
                    $i->update();
                }
            }
        } else {
            $item->read = true;
            $item->update();
        }
    }
}
