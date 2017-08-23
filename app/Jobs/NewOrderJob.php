<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Models\Order;
use App\Models\Product;
use Mail;
use App\Mail\orders\NewOrderToCustomer;
use App\Mail\orders\NewOrderToAdmin;

class NewOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        $product = $this->product;
        // Send email to customer
         Mail::to($order->email)->send(new NewOrderToCustomer($order, $product));
        //  send mail to admin and Cs
        $admins = User::whereHas('roles', function ($query) {
            $query->where('slug', 'admin')->orWhere('slug', 'cs');
        })->get();
        Mail::to($admins)->send(new NewOrderToAdmin($order, $product));
    }
}
