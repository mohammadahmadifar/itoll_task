<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property array $location
 * @property string $updated_at
 */
class DriverResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request):array
    {
        return [
            'location' => $this->location,
        ];
    }
}
