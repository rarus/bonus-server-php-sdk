<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

enum CertificateStatusType: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Expired = 'expired';
    case Used = 'used';
    case Canceled = 'canceled';
    case ToActivate = 'to_activate';
}
