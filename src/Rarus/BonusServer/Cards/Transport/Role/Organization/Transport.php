<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\Organization;

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
            $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency()));
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

        $card = BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($requestResult['card'], $this->getDefaultCurrency());

        $this->log->debug('rarus.bonus.server.cards.transport.getByCardId.start', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode(),
        ]);

        return $card;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function activate(BonusServer\Cards\DTO\Card $card): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.activate.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/activate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $activatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.activate.finish', [
            'cardId' => $card->getCardId()->getId(),
            'isActive' => $card->getCardStatus()->isActive(),
        ]);

        return $activatedCard;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function deactivate(BonusServer\Cards\DTO\Card $card): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.deactivate.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/deactivate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $deactivatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.deactivate.finish', [
            'cardId' => $card->getCardId()->getId(),
            'isActive' => $card->getCardStatus()->isActive(),
        ]);

        return $deactivatedCard;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function update(BonusServer\Cards\DTO\Card $card): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.update.start', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            BonusServer\Cards\Formatters\Card::toArrayForUpdateCard($card)
        );

        $updatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.update.finish', [
            'cardId' => $updatedCard->getCardId()->getId(),
            'code' => $updatedCard->getCode(),
            'barcode' => $updatedCard->getBarcode(),
        ]);

        return $updatedCard;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param bool                       $isIgnorePositiveBalance Если установлен то при удалении выполняется проверка наличия баллов на карте. В случае наличия удаление не производится
     *
     * @return void
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function delete(BonusServer\Cards\DTO\Card $card, bool $isIgnorePositiveBalance = false): void
    {
        $this->log->debug('rarus.bonus.server.cards.transport.delete.start', [
            'cardId' => $card->getCardId()->getId(),
            'isIgnorePositiveBalance' => $isIgnorePositiveBalance,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/delete', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug('rarus.bonus.server.cards.transport.delete.finish', [
            'cardId' => $card->getCardId()->getId(),
            'isIgnorePositiveBalance' => $isIgnorePositiveBalance,
        ]);
    }

    /**
     * Блокировка карты
     * Заблокированные карты полностью недоступны для начисления и списания бонусов до момента разблокировки.
     *
     * @param BonusServer\Cards\DTO\Card $card
     * @param string                     $description
     * @param \DateTime                  $autoUnblockDate
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function block(BonusServer\Cards\DTO\Card $card, string $description, \DateTime $autoUnblockDate = null): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.block.start', [
            'cardId' => $card->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
            'description' => $description,
            'autoUnblockDate' => $autoUnblockDate !== null ? $autoUnblockDate->format(\DATE_ATOM) : null,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/block', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            [
                'description' => $description,
                'unblock_date' => $autoUnblockDate !== null ? $autoUnblockDate->getTimestamp() : 0,
            ]
        );

        $blockedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.block.finish', [
            'cardId' => $blockedCard->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
            'blockedDescription' => $card->getCardStatus()->getBlockedDescription(),
            'code' => $blockedCard->getCode(),
            'barcode' => $blockedCard->getBarcode(),
        ]);

        return $blockedCard;
    }

    /**
     * разблокировка карты
     *
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function unblock(BonusServer\Cards\DTO\Card $card): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.unblock.start', [
            'cardId' => $card->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/unblock', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $unblockedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.unblock.finish', [
            'cardId' => $unblockedCard->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
            'blockedDescription' => $card->getCardStatus()->getBlockedDescription(),
            'code' => $unblockedCard->getCode(),
            'barcode' => $unblockedCard->getBarcode(),
        ]);

        return $unblockedCard;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param \Money\Money               $sum
     *
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function setAccumulationAmount(BonusServer\Cards\DTO\Card $card, \Money\Money $sum): void
    {
        $this->log->debug('rarus.bonus.server.cards.transport.setAccumulationAmount.start', [
            'cardId' => $card->getCardId()->getId(),
            'accumSaleAmount' => $card->getAccumSaleAmount()->getAmount(),
            'sumValue' => $sum->getAmount(),
            'sumCurrency' => $sum->getCurrency()->getCode(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/accumulate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            [
                'reset' => false,
                'sum' => (int)$sum->getAmount(),
            ]
        );
        $this->log->debug('rarus.bonus.server.cards.transport.setAccumulationAmount.finish');
    }

    /**
     * может ли карта сделать апгрейд уровня
     *
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return bool
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function isCardCanLevelUp(BonusServer\Cards\DTO\Card $card): bool
    {
        $this->log->debug('rarus.bonus.server.cards.transport.isCardCanLevelUp.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/levelup', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            [
                'check' => true,
            ]
        );

        $isCardCanLevelUp = false;
        if (array_key_exists('next_level_up', $requestResult)) {
            $nextLevel = \Rarus\BonusServer\Cards\DTO\Level\Fabric::initFromServerResponse($requestResult['next_level_up'], $this->getDefaultCurrency());
            $isCardCanLevelUp = true;
        }

        $this->log->debug('rarus.bonus.server.cards.transport.isCardCanLevelUp.finish', [
            'cardId' => $card->getCardId()->getId(),
            'isCardCanLevelUp' => $isCardCanLevelUp,
        ]);

        return $isCardCanLevelUp;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function levelUp(BonusServer\Cards\DTO\Card $card): void
    {
        $this->log->debug('rarus.bonus.server.cards.transport.levelUp.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/levelup', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug('rarus.bonus.server.cards.transport.levelUp.finish', [
            'cardId' => $card->getCardId()->getId(),
        ]);
    }

    /**
     * @param BonusServer\Cards\DTO\CardFilter $cardFilter
     *
     * @return BonusServer\Cards\DTO\CardCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByFilter(BonusServer\Cards\DTO\CardFilter $cardFilter): BonusServer\Cards\DTO\CardCollection
    {
        $this->log->debug('rarus.bonus.server.cards.transport.getByFilter.start', [
            'cardFilterQuery' => BonusServer\Cards\Formatters\CardFilter::toUrlArguments($cardFilter),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/?%s', BonusServer\Cards\Formatters\CardFilter::toUrlArguments($cardFilter)),
            RequestMethodInterface::METHOD_GET
        );

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        foreach ((array)$requestResult['cards'] as $card) {
            $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency()));
        }

        $this->log->debug('rarus.bonus.server.cards.transport.getByFilter.finish', [
            'itemsCount' => $cardCollection->count(),
        ]);
        $cardCollection->rewind();

        return $cardCollection;
    }

    /**
     * привязка карты к пользователю
     *
     * @param BonusServer\Cards\DTO\Card $card
     * @param BonusServer\Users\DTO\User $user
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function attachToUser(BonusServer\Cards\DTO\Card $card, BonusServer\Users\DTO\User $user): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.attachToUser.start', [
            'cardId' => $card->getCardId()->getId(),
            'cardCode' => $card->getCode(),
            'userId' => $user->getUserId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/card/attach',
            RequestMethodInterface::METHOD_POST,
            [
                'user_id' => $user->getUserId()->getId(),
                'card_id' => $card->getCardId()->getId(),
            ]
        );
        $this->log->debug('rarus.bonus.server.cards.transport.attachToUser.attachResult', [
            'attachResult' => $requestResult,
        ]);

        // перечитываем карту с обновлённой привзякой
        $updatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.attachToUser.finish', [
            'cardId' => $card->getCardId()->getId(),
            'cardCode' => $card->getCode(),
            'cardUserId' => $updatedCard->getUserId() === null ? null : $updatedCard->getUserId()->getId(),
        ]);

        return $updatedCard;
    }
}