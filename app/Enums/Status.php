<?php
namespace App\Enums;

use Spatie\Enum\Enum;
class Status extends Enum
{
    const ACTIVE = 'active';
    const PASSIVE = 'passive';

    public static function toValues(): array
    {
        return[
            self::ACTIVE => strtolower('Active'),
            self::PASSIVE => strtolower('Passive'),
        ];
    }
}
?>
