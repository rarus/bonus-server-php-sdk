<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoСodes\DTO;

enum HoldPromoCodeState: string
{
    case Active = 'active';
    case Used = 'used';
    case Expired = 'expired';
    case Cancelled = 'cancelled';
}
