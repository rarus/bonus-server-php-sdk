<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transport\Formatters;

use Rarus\BonusServer;

/**
 * Class Pagination.
 */
class Pagination
{
    public static function toRequestUri(?BonusServer\Transport\DTO\Pagination $pagination): string
    {
        if (null !== $pagination) {
            return sprintf('&page=%s&per_page=%s', $pagination->getPageNumber(), $pagination->getPageSize());
        }

        return '';
    }
}
