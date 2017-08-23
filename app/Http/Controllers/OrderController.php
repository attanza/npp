<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderSubmitRequest;
use App\Jobs\NewOrderJob;
use Carbon\Carbon;
use Mail;
use App\Mail\orders\OrderCompleteToCustomer;
use App\Mail\orders\OrderCompleteToAdmin;

class OrderController extends Controller
{
    public function store(OrderSubmitRequest $request)
    {
        // check product availability
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        if (count($product) == 0) {
            return response()->json([
              'msg' => 'Mohon maaf produk sedang tidak tersedia.'
            ], 422);
        }

        if ($product->stock == 0) {
            return response()->json([
              'msg' => 'Mohon maaf produk sedang tidak tersedia.'
            ], 422);
        }
        $order_no = $product->code.'-'.time();
        $code = str_random(60);
        $order = Order::create([
          'order_no' => $order_no,
          'product_id' => $product_id,
          'name' => $request->name,
          'qty' => $request->qty,
          'phone' => $request->phone,
          'email' => $request->email,
          'address' => $request->address,
          'long' => $request->long,
          'lat' => $request->lat,
          'code' => $code,
        ]);
        dispatch(new NewOrderJob($order, $product));

        return response()->json([
          'msg' => 'Order akan segera kami proses, notifikasi pemesanan akan kami kirimkan via email'
        ], 200);
    }

    public function orderComplete($email, $code)
    {
        // find order
        $order = Order::where('code', $code)->where('email', $email)->first();
        if (count($order) == 0) {
            return redirect('/')->withError('Order tidak ditemukan');
        }
        if ($order->is_complete) {
            return redirect('/')->withSuccess('Order sudah diterima');
        }
        // update Order
        $order->is_complete = 1;
        $order->completed_at = Carbon::now();
        $order->status = 3;
        $order->save();
        // update Product Stock
        $product = $order->product;
        $product->stock = $product->stock - $order->qty;
        $product->save();
        $this->orderCompleteMail($order);
        return redirect('/')->withSuccess('Terimakasih atas verifikasi anda');
    }

    private function orderCompleteMail($order)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('slug', 'admin')->orWhere('slug', 'cs');
        })->get();

        Mail::to($order->email)
          ->send(new OrderCompleteToCustomer($order, $order->product));

        Mail::to($admins)
          ->send(new OrderCompleteToAdmin($order, $order->product));
    }
}
