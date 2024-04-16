<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {

        $orders = OrderResource::collection(Order::all());

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function show($id)
    {

        $order = new OrderResource(Order::find($id));

        return response()->json([
            'order' => $order
        ]);
    }

    public function store(OrderRequest $request)
    {

        // Create a new Order instance with the validated data from the request, excluding the 'products' attribute
        $order = Order::create($request->safe()->except('products'));

        // Check if the order's service is empty
        if (empty($order->service)) {
            // If so, retrieve the products array from the request
            $products = $request->input('products');
            foreach ($products as $product) {
                // Extract the product ID and quantity from each product array
                $productId = $product['id'];
                $quantity = $product['quantity'];
                $order->products()->attach($productId, ['quantity' => $quantity]);
            }
        }
        $order = OrderResource::make($order);

        return response()->json([
            'order' => $order
        ]);
    }

    public function update($id, OrderRequest $request)
    {

        $order = Order::find($id);
        // Update the order with the validated data from the request, excluding the 'products' attribute
        $order->update($request->safe()->except('products'));

        // Check if the order's service is empty
        if (empty($order->service)) {
            // If so, retrieve the products array from the request
            $products = collect($request->input('products'))->mapWithKeys(function ($product){
                return [$product['id'] => ['quantity' => $product['quantity']]];
            })->toArray();

            $order->products()->sync($products);

        }

        $order->save();
        $order = OrderResource::make($order);

        return response()->json([
            'order' => $order
        ]);
    }

    public function destroy($id)
    {

        $order = Order::find($id);
        $order->delete();
        $orders = OrderResource::collection(Order::all());

        return response()->json([
            'order' => $orders
        ]);
    }

}
