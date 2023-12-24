<?php
namespace App\Enums;

use Spatie\Enum\Enum;
class ShipmentStatus extends Enum
{
    const ORDER_RECEIVED = 'Order Received';
    const BEING_PROCESSED = 'Being Processed';
    const SHIPPED = 'Shipped';
    const DELIVERED = 'Delivered';
    const CANCELLED = 'Cancelled';


    public static function toValues(): array
    {
        return[
            self::ORDER_RECEIVED => strtolower('order received'),
            self::BEING_PROCESSED => strtolower('being processed'),
            self::SHIPPED => strtolower('shipped'),
            self::DELIVERED => strtolower('delivered'),
            self::CANCELLED => strtolower('cancelled'),
        ];
    }
}
?>
