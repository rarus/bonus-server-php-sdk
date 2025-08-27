<?php

namespace Rarus\LMS\SDK\Users\DTO;

enum UserStatus: string
{
    case NotConfirmed = 'not_confirmed';
    case Confirmed = 'confirmed';
}
