<?php

namespace App\Mail\orders;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Models\Product;

class OrderDelivery extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Order #'.$this->order->order_no.' sedang dalam pengiriman';
        return $this->subject($subject)->view('mails.orders.delivery_to_customer');
    }
}
