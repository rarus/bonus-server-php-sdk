<?php

declare(strict_types=1);

use Rarus\BonusServer\Users\DTO\Gender\Fabric;

require_once __DIR__ . '/init.php';

$newUser = \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
    'grishi-' . random_int(0, PHP_INT_MAX),
    'Михаил Гришин',
    '+7978 888 22 22',
    'grishi@rarus.ru',
    null,
    new \DateTime('06.06.1985')
);

$transport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$user = $transport->addNewUser($newUser);

var_dump(\Rarus\BonusServer\Users\Formatters\User::toArray($user));

$user->setName('Ивлев Андрей')
    ->setGender(Fabric::initFromServerResponse('male'));

$updatedUser = $transport->update($user);

var_dump($updatedUser);
