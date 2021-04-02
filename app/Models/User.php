<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Item;
use App\Models\ChatMessage;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postcode_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function items(){
        return $this->hasMany('App\Models\Item');
    }

    public function offers(){
        return $this->hasMany('App\Models\Offer');
    }

    public function allMessages(){
        $messages = new Collection();
        $messages = $this->chatMessages;
        $allMessages = $messages->merge($this->chatMessagesSent->map(function ($item, $key){return $item;}));
        return $allMessages;
    }

    public function chatMessages(){
        return $this->hasMany('App\Models\ChatMessage', 'to');
    }

    public function chatMessagesSent(){
        return $this->hasMany('App\Models\ChatMessage', 'from');
    }

    public function getAllUserInteractions(){
        $messages = ChatMessage::where('to', $this->id)->orWhere('from', $this->id)->get();
        $collectionOfUsers = new Collection();
        foreach($messages as $message){
            if($message->fromUser->id != $this->id){
                if(!$collectionOfUsers->contains($message->fromUser)){
                    $collectionOfUsers->push($message->fromUser);
                    continue;
                }
                continue;
            } else {
                if(!$collectionOfUsers->contains($message->toUser)){
                    $collectionOfUsers->push($message->toUser);
                    continue;
                }
                continue;
            }
        }
        return $collectionOfUsers;
    }
    public function getLastMessageByUser($loggedUser, $otherUser){
        $messagesFrom = ChatMessage::where('to', $loggedUser)->where('from', $otherUser)->orderBy('created_at', 'DESC')->limit(1)->get();
        $messagesTo = ChatMessage::where('to', $otherUser)->where('from', $loggedUser)->orderBy('created_at', 'DESC')->limit(1)->get();
        $coll = collect([$messagesFrom->first(), $messagesTo->first()]);
        $sortedColl = $coll->sortByDesc('created_at');
        //dd($coll->sortByDesc('created_at'));
        return $sortedColl->first();
    }

    public function hasUnreadMessages(){
        return ChatMessage::where('to', $this->id)->where('read', false)->count() > 0;
    }

    public function notifications(){
        return $this->hasMany('App\Models\Notification');
    }

    public function hasUnreadNotification(){
        return Notification::where('user_id', $this->id)->where('read', false)->count() > 0;
    }

    public function isOwner(Item $item){
        return $this->id == $item->user_id;
    }

    public function isBidOwner(Offer $offer){
        return $this->id == $offer->user_id;
    }

    public function itemsSold(){
        return Item::where('user_id', $this->id)->where('sold', true)->count();
    }

    public function postcode(){
        return $this->belongsTo('App\Models\Postcode');
    }
}
