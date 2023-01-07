<?php

namespace App\Http\Controllers\Order;

use App\Events\UpdateLocationEvent;
use App\Exceptions\CantAssignOrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\LocationOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
     * @param int $id
     * @param LocationOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    public function assign(int $id, LocationOrderRequest $request): OrderResource|JsonResponse
    {
        DB::beginTransaction();
        try {
            $order = Order::query()->where('id', $id)->whereNull('driver_id')->lockForUpdate()->first();
            if (!$order)
                throw new CantAssignOrderException();
            $order->update(['driver_id' => $request->user()->id, 'status' => Order::STATUS_RECEIVED]);
            DB::commit();
            event(new UpdateLocationEvent($request->validated()));

            return new OrderResource($order);
        } catch (\Throwable $t) {
            DB::rollBack();
            return response()->json(
                ['massage' => __('messages.assign_failed')],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @param Order $order
     * @param LocationOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    public function delivered(Order $order, LocationOrderRequest $request): OrderResource|JsonResponse
    {
        if ((int)$order->driver_id !== (int)$request->user()->id)
            return response()->json(['massage' => __('messages.not_for_you_order_driver')]);
        $order->update(['status' => Order::STATUS_DELIVERED]);
        event(new UpdateLocationEvent($request->validated()));

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

    /**
     * @return AnonymousResourceCollection
     */
    public function newOrder(): AnonymousResourceCollection
    {
        return OrderResource::collection(
            Order::query()->where('status', Order::STATUS_NEW)->paginate()
        );
    }


    /**
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function show(Order $order): OrderResource|JsonResponse
    {
        if ($order->status === Order::STATUS_DELIVERED)
            return response()->json(['massage' => __('messages.order_delivered')]);
        return new OrderResource(Order::query()->where('id', $order->id)->with('driverLocation')->first());
    }
}
