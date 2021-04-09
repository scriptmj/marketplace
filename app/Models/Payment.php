<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'invoice_id', 'payment_time'];

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
}
