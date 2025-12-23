<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

enum DiscountType: string
{
    case Discount = 'discount';
    case Payment = 'payment';
    case Bonus = 'bonus';
    case Gift = 'gift';
    case External = 'external';
    case Referrer = 'referrer';
}
