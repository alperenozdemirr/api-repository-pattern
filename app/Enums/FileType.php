<?php
namespace App\Enums;

use Spatie\Enum\Enum;
class FileType extends Enum
{
    const FILE = 'file';
    const IMAGE = 'image';

    public static function toValues(): array
    {
        return[
            self::FILE => strtolower('File'),
            self::IMAGE => strtolower('Image'),
        ];
    }
}
?>
