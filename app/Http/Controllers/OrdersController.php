<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrdersCustomerDetail;
use App\Models\OrdersInvoiceDetail;
use App\Models\OrdersProduct;
use App\Models\OrdersShippingAddress;
use Illuminate\Support\Facades\Route;

class OrdersController extends Controller {

    public static function routes() {
        Route::get('/orders', [self::class, 'getOrders']);
        Route::get('/orders/{uuid}', [self::class, 'getOrder']);
        Route::post('/orders', [self::class, 'createOrder']);
        Route::put('/orders/{uuid}', [self::class, 'updateOrder']);
        Route::delete('/orders/{uuid}', [self::class, 'deleteOrder']);
    }

    public function getOrders() {

        $response = response()->make();

        $query = Order::query();

        if (request()->query('deleted')) {
            $query->withTrashed();
            $query->whereNotNull('deleted_at');
        }

        if (request()->query('sku') !== null) {
            $query->whereHas('products', function ($query) {
                $query->where('sku', request()->query('sku'));
            });
        }

        if (request()->query('tax_id') !== null) {
            $query->whereHas('invoiceDetail', function ($query) {
                $query->where('tax_id', request()->query('tax_id'));
            });
        }

        if (request()->query('limit') !== null || request()->query('offset') !== null) {
            $response->header('X-Total-Count', $query->count());
        }

        if (request()->query('limit') !== null) {
            $query->limit(request()->query('limit'));
        }

        if (request()->query('offset') !== null) {
            $query->offset(request()->query('offset'));
        }

        return $response->setContent($query->get());
    }

    public function getOrder($uuid) {
        $query = Order::query();
        if (request()->query('deleted')) {
            $query->withTrashed();
        }
        $order = $query->where('uuid', $uuid)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return $order;
    }

    public function createOrder(StoreOrderRequest $request) {
        $order = new Order($request->all());
        $order->save();

        $customerDetail = new OrdersCustomerDetail($request->customer_detail);
        $customerDetail->order()->associate($order);
        $customerDetail->save();

        $invoiceDetail = new OrdersInvoiceDetail($request->invoice_detail);
        $invoiceDetail->order()->associate($order);
        $invoiceDetail->save();

        $shippingAddress = new OrdersShippingAddress($request->shipping_address);
        $shippingAddress->order()->associate($order);
        $shippingAddress->save();

        foreach ($request->products as $product) {
            $orderProduct = new OrdersProduct($product);
            $orderProduct->order()->associate($order);
            $orderProduct->save();
        }

        return response()->json($order->fresh(), 201);
    }

    public function updateOrder(StoreOrderRequest $request, $uuid) {
        $order = Order::query()->where('uuid', $uuid)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->fill($request->all());

        $order->customerDetail->update($request->customer_detail);
        $order->invoiceDetail->update($request->invoice_detail);
        $order->shippingAddress->update($request->shipping_address);
        $order->products->each->delete();
        foreach ($request->products as $product) {
            $orderProduct = new OrdersProduct($product);
            $orderProduct->order()->associate($order);
            $orderProduct->save();
        }

        $order->save();
        return $order->fresh();
    }

    public function deleteOrder($uuid) {
        $order = Order::query()->where('uuid', $uuid)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return $order;
    }
}
