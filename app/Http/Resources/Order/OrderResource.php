<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\User\AnalystResource;
use App\Http\Resources\User\DriverResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property array $location_receive
 * @property string $address_receive
 * @property array $location_delivery
 * @property string $address_delivery
 * @property string $status
 * @property string $name_sender
 * @property string $mobile_sender
 * @property string $name_delivery
 * @property string $mobile_delivery
 * @property mixed $driver
 * @property mixed $user
 */
class OrderResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'location_receive' => $this->location_receive,
            'address_receive' => $this->address_receive,
            'location_delivery' => $this->location_delivery,
            'address_delivery' => $this->address_delivery,
            'status' => $this->status,
            'driver' => new UserResource($this->driver),
            'user' =>  new UserResource($this->user),
            'name_sender' => $this->name_sender,
            'mobile_sender' => $this->mobile_sender,
            'name_delivery' => $this->name_delivery,
            'mobile_delivery' => $this->mobile_delivery,
            'location' => $this->whenLoaded(
                'driverLocation',
                function () {
                    return new DriverResource($this->driverLocation);
                }
            ),
        ];
    }
}
