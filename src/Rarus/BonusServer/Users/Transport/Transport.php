<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport;

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
            BonusServer\Users\Formatters\User::toArrayForCreateNewUser($newUser)
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

        $user = BonusServer\Users\DTO\Fabric::initUserFromServerResponse($requestResult['user']);

        $this->log->debug('rarus.bonus.server.users.transport.getByUserId.start', [
            'id' => $user->getUserId()->getId(),
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
        ]);

        return $user;
    }
}