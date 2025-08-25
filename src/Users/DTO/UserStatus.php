<?php

namespace RarusBonus\Users\DTO;

enum UserStatus: string
{
    case NotConfirmed = 'not_confirmed';
    case Confirmed = 'confirmed';
}
