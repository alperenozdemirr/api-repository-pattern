<?php
namespace App\Enums;

use Spatie\Enum\Enum;
class UserType extends Enum
{
    const ADMIN = 'admin';
    const USER = 'user';

    public static function toValues(): array
    {
        return[
            self::ADMIN => strtolower('Admin'),
            self::USER => strtolower('User'),
        ];
    }
}
?>
