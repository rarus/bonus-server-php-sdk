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
            sprintf('/organization/user/%s?%s', $userId->getId(), 'with_additional_fields=true'),
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
     * @param BonusServer\Users\DTO\UserCollection   $usersCollection - ограничение в 500 штук пользователей
     *
     * @param BonusServer\Cards\DTO\UniqueField|null $uniqueField
     * @param bool                                   $duplicatesUpdate
     *
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function importNewUsers(BonusServer\Users\DTO\UserCollection $usersCollection, ?BonusServer\Cards\DTO\UniqueField $uniqueField = null, bool $duplicatesUpdate = false): void
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

        if (!$uniqueField) {
            $uniqueField = BonusServer\Cards\DTO\UniqueField::setId();
        }

        $body = [
            'unique_field' => $uniqueField->getCode(),
            'duplicates'   => $duplicatesUpdate ? 'update' : 'ignore',
            'users'        => $arNewUsers,
        ];

        $this->apiClient->executeApiRequest(
            '/organization/cardsandusers/upload',
            RequestMethodInterface::METHOD_POST,
            $body
        );

        $this->log->debug('rarus.bonus.server.users.transport.importNewUsers.finish');
    }
    /**
     * @param BonusServer\Users\DTO\UserFilter     $userFilter
     * @param BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return BonusServer\Users\Transport\DTO\PaginationResponse
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function list(BonusServer\Users\DTO\UserFilter $userFilter, BonusServer\Transport\DTO\Pagination $pagination): BonusServer\Users\Transport\DTO\PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.list.transport.organization.list.start', [
            'pageSize' => $pagination->getPageSize(),
            'pageNumber' => $pagination->getPageNumber(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                '/organization/user/?%s%s',
                BonusServer\Users\Formatters\UserFilter::toUrlArguments($userFilter),
                BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
            ),
            RequestMethodInterface::METHOD_GET
        );

        $userCollection = new BonusServer\Users\DTO\UserCollection();
        foreach ((array)$requestResult['users'] as $user) {
            $userCollection->attach(BonusServer\Users\DTO\Fabric::initUserFromServerResponse($user, $this->apiClient->getTimezone()));
        }

        $paginationResponse = new BonusServer\Users\Transport\DTO\PaginationResponse(
            $userCollection,
            BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse((array)$requestResult['pagination'])
        );

        $this->log->debug('rarus.bonus.server.list.transport.organization.list.finish', [
            'itemsCount' => $userCollection->count(),
        ]);

        return $paginationResponse;
    }

    /**
     * обновление пользователя
     * @param BonusServer\Users\DTO\User $user
     *
     * @return BonusServer\Users\DTO\User
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function update(BonusServer\Users\DTO\User $user): BonusServer\Users\DTO\User
    {
        $this->log->debug('rarus.bonus.server.users.transport.organization.update.start', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/user/%s', $user->getUserId()->getId()),
            RequestMethodInterface::METHOD_POST,
            BonusServer\Users\Formatters\User::toArrayForUpdateUser($user)
        );

        $updatedUser = $this->getByUserId($user->getUserId());

        $this->log->debug('rarus.bonus.server.users.transport.organization.update.finish', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        return $updatedUser;
    }

    /**
     * удаление пользователя
     * @param BonusServer\Users\DTO\User $user
     *
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function delete(BonusServer\Users\DTO\User $user): void
    {
        $this->log->debug('rarus.bonus.server.users.transport.organization.delete.start', [
            'userId' => $user->getUserId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/user/%s/delete', $user->getUserId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug('rarus.bonus.server.users.transport.organization.delete.finish', [
            'userId' => $user->getUserId()->getId(),
        ]);
    }
}
