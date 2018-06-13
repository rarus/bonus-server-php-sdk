<?php
declare(strict_types=1);
require_once __DIR__ . '/init.php';

$userArray = [
    'name' => 'Михаил',
    'login' => 'grishi+1@rarus.ru',
    'phone' => '+7978 888 22 22',
    'email' => 'grishi@rarus.ru',
    'gender' => 'male',
    'birthdate' => '742262400',
];


$newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
    'grishi-' . random_int(0, PHP_INT_MAX),
    'Михаил Гришин',
    '+7978 888 22 22',
    'grishi@rarus.ru'
);

$transport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$user = $transport->addNewUser($newUser);

var_dump(\Rarus\BonusServer\Users\Formatters\User::toArray($user));