<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Transport;

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
     * получение списка магазинов для организации
     *
     * @return BonusServer\Shops\DTO\ShopCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function list(): BonusServer\Shops\DTO\ShopCollection
    {
        $this->log->debug('rarus.bonus.server.shop.transport.list.start');
        $requestResult = $this->apiClient->executeApiRequest('/organization/shop?schedules=true', RequestMethodInterface::METHOD_GET);
        $shopCollection = new BonusServer\Shops\DTO\ShopCollection();
        foreach ((array)$requestResult['shops'] as $shop) {
            $shopCollection->attach(BonusServer\Shops\DTO\Fabric::initShopFromServerResponse($shop));
        }
        $this->log->debug('rarus.bonus.server.shop.list.end', [
            'itemsCount' => $shopCollection->count(),
        ]);

        return $shopCollection;
    }
}