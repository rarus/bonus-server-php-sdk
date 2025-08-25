<?php

namespace RarusBonus\Users\DTO;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'undefined';
}
