<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

enum PromoCodePeriodType: string
{
    case Absolute = 'absolute';
    case Relative = 'relative';
}
