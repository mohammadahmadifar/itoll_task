<?php

namespace App\Listeners;

use App\Models\Order\Order;
use App\Models\User\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use MatanYadaev\EloquentSpatial\Objects\Point;

class UpdateLocationListener
{

    /**
     * @param $event
     * @return void
     */
    public function handle($event): void
    {
        $user = Auth::user()->id;
        Driver::updateOrCreate(
            ['user_id' => $user],
            ['location' => new Point($event->res['longitude'], $event->res['latitude']), 'user_id' => $user]
        );
        $orders = Order::query()
            ->where(['status' => Order::STATUS_RECEIVED, 'driver_id' => $user])
            ->whereNotNull('url_webhook')
            ->with('driverLocation')
            ->get();

        foreach ($orders as $order) {
            Http::post($order->url_webhook, [
                'id' => $order->id,
                'status' => $order->status,
                'location_longitude' => $order->driverLocation->location->longitude,
                'location_latitude' => $order->driverLocation->location->latitude,
            ]);
        }
    }
}
