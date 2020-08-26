<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Transport\Role\Organization;

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
        $shopCollection->rewind();

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
        $shop = $this->getById(new BonusServer\Shops\DTO\ShopId($requestResult['id']));

        $this->log->debug('rarus.bonus.server.shop.transport.add.finish', [
            'id' => $shop->getShopId()->getId(),
            'name' => $shop->getName(),
        ]);

        return $shop;
    }

    /**
     * @param BonusServer\Shops\DTO\ShopId $shopId
     *
     * @return BonusServer\Shops\DTO\Shop
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getById(BonusServer\Shops\DTO\ShopId $shopId): BonusServer\Shops\DTO\Shop
    {
        $this->log->debug('rarus.bonus.server.shop.transport.getById.start', [
            'id' => $shopId->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s?schedules=true', $shopId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $shop = BonusServer\Shops\DTO\Fabric::initShopFromServerResponse($requestResult['shop']);

        $this->log->debug('rarus.bonus.server.shop.transport.getById.finish', [
            'shopId' => $shop->getShopId()->getId(),
        ]);

        return $shop;
    }

    /**
     * @param BonusServer\Shops\DTO\ShopId $shopId
     *
     * @return bool
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function isShopExistsWithId(BonusServer\Shops\DTO\ShopId $shopId): bool
    {
        $this->log->debug('rarus.bonus.server.shop.transport.isShopExistsWithId.start', [
            'id' => $shopId->getId(),
        ]);

        $isExists = false;
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/shop/%s', $shopId->getId()),
                RequestMethodInterface::METHOD_GET
            );
            BonusServer\Shops\DTO\Fabric::initShopFromServerResponse($requestResult['shop']);
            $isExists = true;
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если магазин не найден, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }
        $this->log->debug('rarus.bonus.server.shop.transport.isShopExistsWithId.finish', [
            'id' => $shopId->getId(),
            'isShopExists' => $isExists,
        ]);

        return $isExists;
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
            'id' => $shop->getShopId()->getId(),
        ]);

        $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s/delete', $shop->getShopId()->getId()),
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
            'id' => $shop->getShopId()->getId(),
        ]);

        $this->apiClient->executeApiRequest(
            sprintf('/organization/shop/%s', $shop->getShopId()->getId()),
            RequestMethodInterface::METHOD_POST,
            BonusServer\Shops\Formatters\Shop::toArrayForUpdateShop($shop)
        );

        // вычитываем магазин
        $updatedShop = $this->getById($shop->getShopId());

        $this->log->debug('rarus.bonus.server.shop.transport.update.finish', [
            'id' => $updatedShop->getShopId()->getId(),
            'name' => $updatedShop->getName(),
        ]);

        return $updatedShop;
    }
}
