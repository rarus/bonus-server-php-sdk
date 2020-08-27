<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\Role\Organization;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Users\Transport
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * @param BonusServer\Users\DTO\User $newUser
     *
     * @return BonusServer\Users\DTO\User
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addNewUser(BonusServer\Users\DTO\User $newUser): BonusServer\Users\DTO\User
    {
        $this->log->debug('rarus.bonus.server.users.transport.addNewUser.start');

        // добавили юзера
        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/user/new',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Users\Formatters\User::toArrayForCreateNewUser($newUser, $this->apiClient->getTimezone())
        );

        // вычитываем юзера с сервера
        $user = $this->getByUserId(new BonusServer\Users\DTO\UserId($requestResult['id']));

        $this->log->debug('rarus.bonus.server.users.transport.addNewUser.finish', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        return $user;
    }

    /**
     * @param BonusServer\Users\DTO\UserId $userId
     *
     * @return BonusServer\Users\DTO\User
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByUserId(BonusServer\Users\DTO\UserId $userId): BonusServer\Users\DTO\User
    {
        $this->log->debug('rarus.bonus.server.users.transport.getByUserId.start', [
            'id' => $userId->getId(),
        ]);

        // получили юзера
        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/user/%s', $userId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $user = BonusServer\Users\DTO\Fabric::initUserFromServerResponse($requestResult['user'], $this->apiClient->getTimezone());

        $this->log->debug('rarus.bonus.server.users.transport.getByUserId.start', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        return $user;
    }

    /**
     * @param BonusServer\Users\DTO\User $newUser
     *
     * @return BonusServer\Users\DTO\User
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addNewUserAndAttachFreeCard(BonusServer\Users\DTO\User $newUser): BonusServer\Users\DTO\User
    {
        $this->log->debug('rarus.bonus.server.users.transport.addNewUser.start');

        // добавили юзера
        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/user/new',
            RequestMethodInterface::METHOD_POST,
            array_merge(
                BonusServer\Users\Formatters\User::toArrayForCreateNewUser($newUser, $this->apiClient->getTimezone()),
                ['attach_free_card' => true]
            )
        );

        // вычитываем юзера с сервера
        $user = $this->getByUserId(new BonusServer\Users\DTO\UserId($requestResult['id']));

        $this->log->debug('rarus.bonus.server.users.transport.addNewUser.finish', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        return $user;
    }

    /**
     * пакетная загрузка пользователей, требование - уникальный логин, если найдены дубли, то они игнорируются
     *
     * @param BonusServer\Users\DTO\UserCollection $usersCollection - ограничение в 500 штук пользователей
     *
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function importNewUsers(BonusServer\Users\DTO\UserCollection $usersCollection): void
    {
        $this->log->debug('rarus.bonus.server.users.transport.importNewUsers.start', [
            'usersCount' => $usersCollection->count(),
        ]);

        $arNewUsers = [];
        $usersCollection->rewind();

        // собираем пакет из юзеров
        foreach ($usersCollection as $user) {
            $arNewUsers[] = BonusServer\Users\Formatters\User::toArrayForImportNewUser($user, $this->apiClient->getTimezone());
        }

        $this->apiClient->executeApiRequest(
            '/organization/user/upload',
            RequestMethodInterface::METHOD_POST,
            [
                'duplicates' => 'ignore',
                'users' => $arNewUsers,
            ]
        );

        $this->log->debug('rarus.bonus.server.users.transport.importNewUsers.finish');
    }
}
