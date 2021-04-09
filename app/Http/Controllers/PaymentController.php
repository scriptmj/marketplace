<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Item;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function getInvoices(){
        $invoices = Invoice::where('user_id', Auth::user()->id)->paginate(10);
        return view('user.invoices', ['invoices' => $invoices]);
    }

    public function payInvoice(Invoice $invoice){
        return view('user.pay', ['invoice' => $invoice]);
    }
    
    public function storePayment(Invoice $invoice){
        if(!$invoice->paid){
            $payment = new Payment();
            $payment->invoice_id = $invoice->id;
            $payment->price = $invoice->price;
            $payment->payment_time = Carbon::now();
            $payment->save();
            $invoice->paid = true;
            $invoice->paid_on = $payment->payment_time;
            $invoice->payment_id = $payment->id;
            $invoice->update();
            if($invoice->item_promotion){
                $invoice->item->promoted = true;
                $invoice->item->promoted_until = Carbon::now()->addMonthNoOverflow();
                $invoice->item->update();
            }
            return redirect(route('home'));
        }
    }

    public function promote(Item $item){
        if($item->promoted){
            return redirect(route('item.view', $item));
        }
        $invoice = new Invoice();
        $invoice->user_id = $item->user->id;
        $invoice->price = 10;
        $invoice->item_id = $item->id;
        $invoice->item_promotion = true;
        $invoice->save();
        return redirect(route('payment.invoice', $invoice));
    }
}