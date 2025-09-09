<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoСodes\DTO;

enum PromoCodePeriodType: string
{
    case Absolute = 'absolute';
    case Relative = 'relative';
}
