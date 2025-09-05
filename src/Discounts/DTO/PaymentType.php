<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Discounts\DTO;

enum PaymentType: string
{
    case Cash = 'cash';
    case Card = 'card';
    case Certificate = 'cert';
}
