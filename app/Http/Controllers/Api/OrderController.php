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

/**
 * @OA\Info(
 *    title="Order Microservice API",
 *    version="1.0.0",
 * )
 */
class OrderController extends Controller
{


    /**
     * Display a listing of the resource.
     * @param ListOrdersRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     ** path="/api/orders",
     *   tags={"Orders"},
     *   summary="List orders",
     *   operationId="list_orders",
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="date_from",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="date_to",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *)
     **/
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
        ], 201);
    }


    /**
     * Store a newly created resource in database.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     ** path="/api/orders/new",
     *   tags={"Orders"},
     *   summary="Create new order",
     *   operationId="create_order",
     *
     *  @OA\Parameter(
     *      name="customer_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="customer_email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="shipping",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="invoice_address_title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="invoice_zip_code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="invoice_city",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="invoice_address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="shipping_address_title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="shipping_zip_code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="shipping_city",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="shipping_address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="cart",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      ),
     *
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *)
     **/
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
                ], 404);
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
        ], 201);
    }


    /**
     * Update the specified resource in database.
     *
     * @param UpdateOrderRequest $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     ** path="/api/orders/update",
     *   tags={"Orders"},
     *   summary="Update the given orders status",
     *   operationId="update_order",
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *)
     **/
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
            ], 404);
        }

        if ($order->status->name == $status){
            return response()->json([
                'status' => 0,
                'message' => 'Order is already set to ' . $status,
            ], 400);
        }

        $order->status = $status;
        $order->save();

        return response()->json([
            'status' => 1,
            'message' => 'Succesful status change',
        ], 201);
    }
}
