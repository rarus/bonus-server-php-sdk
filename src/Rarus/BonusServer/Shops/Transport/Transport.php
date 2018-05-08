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

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/shop?schedules=true',
            RequestMethodInterface::METHOD_GET
        );

        $shopCollection = new BonusServer\Shops\DTO\ShopCollection();
        foreach ((array)$requestResult['shops'] as $shop) {
            $shopCollection->attach(BonusServer\Shops\DTO\Fabric::initShopFromServerResponse($shop));
        }
        $this->log->debug('rarus.bonus.server.shop.transport.list.end', [
            'itemsCount' => $shopCollection->count(),
        ]);

        return $shopCollection;
    }

    /**
     * @param BonusServer\Shops\DTO\Shop $newShop
     *
     * @return BonusServer\Shops\DTO\Shop
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function add(BonusServer\Shops\DTO\Shop $newShop): BonusServer\Shops\DTO\Shop
    {
        $this->log->debug('rarus.bonus.server.shop.transport.add.start', [
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/shop/add',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Shops\Formatters\Shop::toArrayForCreateNewShop($newShop)
        );
        // вычитываем магазин
        $shop = $this->getById($requestResult['id']);

        $this->log->debug('rarus.bonus.server.shop.transport.add.finish', [
            'id' => $shop->getId(),
            'name' => $shop->getName(),
        ]);

        return $shop;
    }

    /**
     * @param string $shopId
     *
     * @return BonusServer\Shops\DTO\Shop
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getById(string $shopId): BonusServer\Shops\DTO\Shop
    {
        $this->log->debug('rarus.bonus.server.shop.transport.getById.start', [
            'id' => $shopId,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s', $shopId),
            RequestMethodInterface::METHOD_GET
        );

        $shop = BonusServer\Shops\DTO\Fabric::initShopFromServerResponse($requestResult['shop']);

        $this->log->debug('rarus.bonus.server.shop.transport.getById.finish', [
            'shopId' => $shop->getId(),
        ]);

        return $shop;
    }

    /**
     * удаление магазина
     *
     * @param BonusServer\Shops\DTO\Shop $shop
     *
     * @return void
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function delete(BonusServer\Shops\DTO\Shop $shop): void
    {
        $this->log->debug('rarus.bonus.server.shop.transport.delete.start', [
            'id' => $shop->getId(),
        ]);

        $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s/delete', $shop->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug('rarus.bonus.server.shop.transport.delete.finish');
    }

    /**
     * изменение магазина
     *
     * @param BonusServer\Shops\DTO\Shop $shop
     *
     * @return BonusServer\Shops\DTO\Shop
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function update(BonusServer\Shops\DTO\Shop $shop): BonusServer\Shops\DTO\Shop
    {
        $this->log->debug('rarus.bonus.server.shop.transport.update.start', [
            'id' => $shop->getId(),
        ]);

        $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s', $shop->getId()),
            RequestMethodInterface::METHOD_POST,
            BonusServer\Shops\Formatters\Shop::toArrayForUpdateShop($shop)
        );

        // вычитываем магазин
        $updatedShop = $this->getById($shop->getId());

        $this->log->debug('rarus.bonus.server.shop.transport.update.finish', [
            'id' => $updatedShop->getId(),
            'name' => $updatedShop->getName(),
        ]);

        return $updatedShop;
    }
}