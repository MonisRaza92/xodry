<?php

namespace App\Constants;

class PickupStatus
{
    const ORDER_PLACED    = 'Order Placed';
    const PICKUP_PENDING  = 'Pickup Pending';
    const PICKED_UP       = 'Picked Up';
    const DELIVERED       = 'Delivered';
    const CANCELLED       = 'Cancelled';

    public static function all()
    {
        return [
            self::ORDER_PLACED,
            self::PICKUP_PENDING,
            self::PICKED_UP,
            self::DELIVERED,
            self::CANCELLED,
        ];
    }
}
