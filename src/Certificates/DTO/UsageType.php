<?php

namespace Rarus\LMS\SDK\Certificates\DTO;

enum UsageType: string
{
    case Reusable = 'reusable';
    case NonReusable = 'non_reusable';
}
