<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\Role\User;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Users\Transport\Role\User
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * @return BonusServer\Users\DTO\PersonalInfo\PersonalInfo
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function current(): BonusServer\Users\DTO\PersonalInfo\PersonalInfo
    {
        $this->log->debug('rarus.bonus.server.users.transport.current.start', [
            'role' => 'user',
        ]);

        // получили юзера
        $requestResult = $this->apiClient->executeApiRequest(
            '/user',
            RequestMethodInterface::METHOD_GET
        );

        $userPersonalInfo = BonusServer\Users\DTO\PersonalInfo\Fabric::initFromServerResponse($requestResult['user'], $this->apiClient->getTimezone());

        $this->log->debug('rarus.bonus.server.users.transport.current.start', [
            'role' => 'user',
            'name' => $userPersonalInfo->getName(),
            'phone' => $userPersonalInfo->getPhone(),
            'email' => $userPersonalInfo->getEmail(),
        ]);

        return $userPersonalInfo;
    }
}