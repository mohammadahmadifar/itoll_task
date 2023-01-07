<?php

namespace App\Models\Order;

use App\Models\User\Driver;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\SpatialBuilder;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'location_receive' => Point::class,
        'location_delivery' => Point::class,
    ];

    /**
     * @param $query
     * @return SpatialBuilder
     */
    public function newEloquentBuilder($query): SpatialBuilder
    {
        return new SpatialBuilder($query);
    }

    const STATUS_NEW = 'new';
    const STATUS_RECEIVED = 'received';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCEL = 'cancel';

    public static array $statuses = [
        self::STATUS_NEW,
        self::STATUS_RECEIVED,
        self::STATUS_DELIVERED,
        self::STATUS_CANCEL,
    ];

    protected $fillable = [
        'location_receive',
        'address_receive',
        'location_delivery',
        'address_delivery',
        'driver_id',
        'status',
        'name_sender',
        'mobile_sender',
        'name_delivery',
        'mobile_delivery',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function driverLocation():HasOne
    {
        return $this->hasOne(Driver::class,'id','driver_id');
    }
}
