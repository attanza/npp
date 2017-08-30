<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
use Mail;
use App\Mail\orders\OrderDelivery;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function listing(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
          'query' => 'max:50'
        ]);
        $query = e($request->input('query'));
        if ($query != '') {
            $orders = Order::with('product')->where('order_no', 'LIKE', "%$query%")
            ->orWhere('qty', 'LIKE', "%$query%")
            ->paginate($request->paginate);
        } else {
            $orders = Order::with('product')->paginate($request->paginate);
        }
        $response = [
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem()
            ],
            'orders' => $orders
        ];

        return response()->json($response, 200);
    }

    public function show($order_no)
    {
        // Find Order and Return with Error message if not found
        $order = Order::where('order_no', $order_no)->first();
        if (count($order) == 0) {
            return redirect()->route('orders.index')->withError('Nomor Order tidak ditemukan');
        }
        $status = $this->getOrderStatus();
        return view('admin.orders.show')->with([
          'order' => $order,
          'status' => collect($status)
        ]);
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $this->validate($request, [
          'status' => 'required|integer'
        ]);

        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        if ($request->has('send_mail') && $order->status == 2) {
            $this->deliveryMail($order);
            return redirect()->back()->withSuccess('Email telah dikirmkan kepada pemesan');
        }
        return redirect()->back()->withSuccess('Perubahan disimpan');
    }

    private function getOrderStatus()
    {
        $statusNames = [
          'Order Baru', 'Pengiriman', 'Selesai', 'Batal'
        ];
        $i = 1;
        $data = [];
        $status = [];
        foreach ($statusNames as $name) {
            $data = [
              'id' => $i++,
              'name' => $name
            ];
            array_push($status, $data);
        }
        return $status;
    }

    private function deliveryMail($order)
    {
        Mail::to($order->email)
          ->send(new OrderDelivery($order, $order->product));
    }
}
