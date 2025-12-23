<?php

namespace Rarus\LMS\SDK\Users\DTO\UserProperty;

enum UserPropertyType: string
{
    case String = 'string';
    case Float = 'number';
    case Bool = 'bool';
    case DateTime = 'date';
}
