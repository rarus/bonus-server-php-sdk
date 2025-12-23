<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

enum HoldPromoCodePeriod: string
{
    case Date = 'date';
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';
}
