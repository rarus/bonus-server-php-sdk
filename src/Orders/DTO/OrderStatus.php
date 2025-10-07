<?php

namespace Rarus\LMS\SDK\Orders\DTO;

enum OrderStatus: string
{
    case New = 'new';
    case Processing = 'processing';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
}
