<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoCodes\DTO;

enum PromoCodeStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Invalid = 'invalid';
    case Used = 'used';
    case Hold = 'hold';
}
