<?php

namespace App\Enums;

Enum ArticleStatus: string
{
    case PUBLISHED = 'Published';
    case Draft = 'Draft';

    public static function getValues(): array
    {
        return [self::PUBLISHED->value, self::Draft->value];
}


}
