<?php
namespace App\Enums;

use Spatie\Enum\Enum;
class ContentType extends Enum
{
    const PRODUCT = 'product';
    const USER = 'user';

    public static function toValues(): array
    {
        return[
            self::USER => strtolower('user'),
        ];
    }
}
?>
