<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Shops\Transport
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * получение списка карт
     *
     * @return BonusServer\Cards\DTO\CardCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function list(): BonusServer\Cards\DTO\CardCollection
    {
        $this->log->debug('rarus.bonus.server.cards.transport.list.start');

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/card',
            RequestMethodInterface::METHOD_GET
        );

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        foreach ((array)$requestResult['cards'] as $card) {
            $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card));
        }

        $this->log->debug('rarus.bonus.server.cards.transport.list.finish', [
            'itemsCount' => $cardCollection->count(),
        ]);

        return $cardCollection;
    }
}