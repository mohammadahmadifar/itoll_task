<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\Order\OrderResource;
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
}
