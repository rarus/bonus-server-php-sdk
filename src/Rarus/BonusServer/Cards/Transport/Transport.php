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

    /**
     * @param BonusServer\Cards\DTO\Card $newCard
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addNewCard(BonusServer\Cards\DTO\Card $newCard): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.addNewCard.start');

        // добавили карту
        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/card/add',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Cards\Formatters\Card::toArrayForCreateNewCard($newCard)
        );
        // вычитываем карту с сервера
        $card = $this->getByCardId(new BonusServer\Cards\DTO\CardId($requestResult['id']));

        $this->log->debug('rarus.bonus.server.cards.transport.addNewCard.finish', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode(),
        ]);

        return $card;
    }

    /**
     * @param BonusServer\Cards\DTO\CardId $cardId
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByCardId(BonusServer\Cards\DTO\CardId $cardId): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.getByCardId.start', [
            'cardId' => $cardId->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s', $cardId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $card = BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($requestResult['card']);

        $this->log->debug('rarus.bonus.server.cards.transport.getByCardId.start', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode(),
        ]);

        return $card;
    }
}