<?php

namespace App\Mail\orders;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Models\Product;

class OrderCompleteToCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function build()
    {
        $subject = 'Order #'.$this->order->order_no.' sudah diterima';
        return $this->subject($subject)->view('mails.orders.new_order_to_customer');
    }
}
