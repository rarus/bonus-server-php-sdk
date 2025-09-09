<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\PromoСodes\DTO;

enum PromoCodeUsage: string
{
    case Reusable = 'reusable';
    case NonReusable = 'non_reusable';
}
