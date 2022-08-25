<?php

namespace App\Http\Controllers\Api;

use App\Enum\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListOrdersRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ListOrdersRequest $request
     * @return JsonResponse
     */
    public function index(ListOrdersRequest $request)
    {
        // NOTE: validation is handled in ListOrdersRequest

        $data = $request->all();

        $orders = Order::select(['id', 'status', 'customer_name', 'created_at', 'total']);

        if (array_key_exists('id', $data)){
            $orders->where('id', '=', $data['id']);
        }
        if (array_key_exists('status', $data)){
            $orders->where('status', '=', $data['status']);
        }
        if (array_key_exists('date_from', $data)){
            $orders->where('created_at', '>=', $data['date_from']);
        }
        if (array_key_exists('date_to', $data)){
            $orders->where('created_at', '<=', $data['date_to']);
        }

        $orders = $orders->get();
        return response()->json([
            'status' => 1,
            'message' => 'Succesful listing',
            'orders_count' => $orders->count(),
            'orders' => $orders,
        ]);
    }

    /**
     * Store a newly created resource in database.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function create(StoreOrderRequest $request)
    {
        // NOTE: validation is handled in StoreOrderRequest

        DB::beginTransaction();

        $order = new Order($request->only(['customer_name', 'customer_email', 'shipping', 'invoice_address_title', 'invoice_zip_code', 'invoice_city', 'invoice_address', 'shipping_address_title', 'shipping_zip_code', 'shipping_city', 'shipping_address']));
        $order->save();

        $cart = $request->get('cart');
        $total = 0.0;

        foreach ($cart as $cartItem){
            list($productId, $quantity) = $cartItem;

            $product = Product::find($productId);
            if (!isset($product)){
                DB::rollback();

                return response()->json([
                    'status' => 0,
                    'message' => "Product with id ".$productId." does not exist!",
                ]);
            }

            $orderedProduct = new OrderedProduct();
            $orderedProduct->order_id = $order->id;
            $orderedProduct->product_id = $productId;
            $orderedProduct->quantity = $quantity;
            $orderedProduct->unit_price = $product->unit_price;
            $orderedProduct->save();

            $total += ($quantity * $product->unit_price);
        }

        $order->total = $total;
        $order->save();

        DB::commit();

        return response()->json([
            'status' => 1,
            'order_id' => $order->id
        ]);
    }

    /**
     * Update the specified resource in database.
     *
     * @param UpdateOrderRequest $request
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request)
    {
        // NOTE: validation is handled in UpdateOrderRequest

        $id = $request->post('id');
        $status = $request->post('status');

        $order = Order::find($id);

        if($order === null){
            return response()->json([
                'status' => 0,
                'message' => 'Order not found',
            ]);
        }

        if ($order->status->name == $status){
            return response()->json([
                'status' => 0,
                'message' => 'Order is already set to ' . $status,
            ]);
        }

        $order->status = $status;
        $order->save();

        return response()->json([
            'status' => 1,
            'message' => 'Succesful status change',
        ]);
    }
}
