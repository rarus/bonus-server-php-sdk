<?php

namespace Rarus\LMS\SDK\Users\DTO\UserProperty;

enum UserPropertyType: string
{
    case String = 'string';
    case Int = 'int';
    case Bool = 'bool';
    case DateTime = 'datetime';
}
