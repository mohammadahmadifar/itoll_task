<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\LocationOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MatanYadaev\EloquentSpatial\Objects\Point;

class OrderController extends Controller
{

    /**
     * @param CreateOrderRequest $request
     * @return OrderResource
     */
    public function store(CreateOrderRequest $request): OrderResource
    {
        $validated = $request->validated();
        $validated['location_receive'] = new Point($request->get('longitude_receive'), $request->get('latitude_receive'));
        $validated['location_delivery'] = new Point($request->get('longitude_delivery'), $request->get('latitude_delivery'));
        return new OrderResource($request->user()->orders()->create($validated)->fresh());
    }

    /**
     * @param Order $order
     * @param LocationOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    public function assign(Order $order, LocationOrderRequest $request): OrderResource|JsonResponse
    {
        if ($order->driver_id !== null)
            return response()->json(['massage' => __('messages.error_assign_drivers')]);
        $order->update(['driver_id' => $request->user()->id, 'status' => Order::STATUS_RECEIVED]);

        return new OrderResource($order);
    }

    /**
     * @param Order $order
     * @param LocationOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    public function delivered(Order $order, LocationOrderRequest $request): OrderResource|JsonResponse
    {
        if ((int) $order->driver_id !== (int) $request->user()->id)
            return response()->json(['massage' => __('messages.not_for_you_order_driver')]);
        $order->update(['status' => Order::STATUS_DELIVERED]);

        return new OrderResource($order);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return JsonResponse
     */
    public function cancel(Order $order, Request $request): JsonResponse
    {
        if ($order->status !== Order::STATUS_NEW)
            return response()->json(['massage' => __('messages.error_canceled')]);

        if ($order->user_id === $request->user()->id) {
            $order->update(['status', Order::STATUS_CANCEL]);

            return response()->json(['massage' => __('messages.success_canceled')]);
        }

        return response()->json(['massage' => __('messages.not_for_you_order')]);
    }
}
