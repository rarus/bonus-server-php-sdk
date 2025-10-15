<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

enum RefundStatus: string
{
    case Cancel = 'cancel';
    case Default = 'default';
}
