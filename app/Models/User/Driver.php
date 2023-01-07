<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\SpatialBuilder;

class Driver extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = ['location' => Point::class];

    /**
     * @param $query
     * @return SpatialBuilder
     */
    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }

    /**
     * @var string[]
     */
    protected $fillable = ['location','user_id'];
}
