<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\Organization;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
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
     * @param BonusServer\Shops\DTO\ShopId                                     $shopId
     * @param BonusServer\Cards\DTO\Card                                       $card
     * @param null|BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection $chequeRowCollection
     *
     * @return BonusServer\Cards\DTO\Balance\PaymentBalance
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getPaymentBalance(BonusServer\Shops\DTO\ShopId $shopId, BonusServer\Cards\DTO\Card $card, ?BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection $chequeRowCollection = null): BonusServer\Cards\DTO\Balance\PaymentBalance
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getPaymentBalance.start', [
            'shopId' => $shopId->getId(),
            'cardId' => $card->getCardId()->getId(),
            'cardBarcode' => $card->getBarcode()->getCode(),
        ]);

        // есть ли табличная часть чека?
        if ($chequeRowCollection === null) {
            $chequeRowCollection = new BonusServer\Transactions\DTO\ChequeRows\ChequeRowCollection();
        }
        $arChequeRows = [];
        foreach ($chequeRowCollection as $chequeRow) {
            $arChequeRows[] = BonusServer\Transactions\Formatters\ChequeRow::toArray($chequeRow);
        }

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/balance', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST, [
                'card_barcode' => $card->getBarcode()->getCode(),
                'shop_id' => $shopId->getId(),
                'cheque_items' => $arChequeRows,
            ]
        );

        $paymentBalance = BonusServer\Cards\DTO\Balance\Fabric::initPaymentBalanceFromServerResponse($this->getDefaultCurrency(), $requestResult);

        $this->log->debug('rarus.bonus.server.cards.transport.organization.getPaymentBalance.finish', [
            'shopId' => $shopId->getId(),
            'cardId' => $card->getCardId()->getId(),
            'paymentBalance' => $paymentBalance->getPaymentBalance()->getAmount(),
            'availableBalance' => $paymentBalance->getAvailableBalance()->getAmount(),
        ]);

        return $paymentBalance;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param int                        $lastTransactions
     *
     * @return BonusServer\Cards\DTO\AccountStatement\AccountStatement
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getAccountStatement(BonusServer\Cards\DTO\Card $card, int $lastTransactions = 0): BonusServer\Cards\DTO\AccountStatement\AccountStatement
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getAccountStatement.start', [
            'cardId' => $card->getCardId()->getId(),
            'lastTransactions' => $lastTransactions,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/balance_info?last_transactions=%s', $card->getCardId()->getId(), $lastTransactions),
            RequestMethodInterface::METHOD_GET
        );

        $accountStatement = BonusServer\Cards\DTO\AccountStatement\Fabric::initFromServerResponse($this->getDefaultCurrency(), $requestResult, $this->apiClient->getTimezone());
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getAccountStatement.finish', [
            'availableBalance' => $accountStatement->getBalance()->getAvailable()->getAmount(),
            'totalBalance' => $accountStatement->getBalance()->getTotal()->getAmount(),
        ]);

        return $accountStatement;
    }

    /**
     * @param BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return BonusServer\Cards\Transport\DTO\PaginationResponse
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function list(BonusServer\Transport\DTO\Pagination $pagination): BonusServer\Cards\Transport\DTO\PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.list.start', [
            'pageSize' => $pagination->getPageSize(),
            'pageNumber' => $pagination->getPageNumber(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card?calculate_count=true%s', BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)),
            RequestMethodInterface::METHOD_GET
        );

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        foreach ((array)$requestResult['cards'] as $card) {
            $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency(), $this->apiClient->getTimezone()));
        }

        $paginationResponse = new BonusServer\Cards\Transport\DTO\PaginationResponse(
            $cardCollection,
            BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse((array)$requestResult['pagination'])
        );

        $this->log->debug('rarus.bonus.server.cards.transport.organization.list.finish', [
            'itemsCount' => $cardCollection->count(),
        ]);

        return $paginationResponse;
    }

    /**
     * получение списка карт по конкретному пользователю
     *
     * @param BonusServer\Users\DTO\User                $user
     * @param null|BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return BonusServer\Cards\DTO\CardCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByUser(BonusServer\Users\DTO\User $user, ?BonusServer\Transport\DTO\Pagination $pagination = null): BonusServer\Cards\DTO\CardCollection
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByUser.start', [
            'userId' => $user->getUserId()->getId(),
            'phone' => $user->getPhone(),
        ]);

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/card?%s&calculate_count=true&user_id=%s',
                    BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination),
                    $user->getUserId()->getId()
                ),
                RequestMethodInterface::METHOD_GET
            );
            foreach ((array)$requestResult['cards'] as $card) {
                $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency(), $this->apiClient->getTimezone()));
            }
            $cardCollection->rewind();
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если карты не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByUser.finish', [
            'itemsCount' => $cardCollection->count(),
        ]);

        return $cardCollection;
    }

    /**
     * добавление новой карты и установка её начального баланса
     *
     * @param BonusServer\Cards\DTO\Card $newCard
     * @param Money|null                 $initialBalance
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addNewCard(BonusServer\Cards\DTO\Card $newCard, ?Money $initialBalance = null): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.addNewCard.start', [
            'code' => $newCard->getCode(),
            'barcode' => $newCard->getBarcode()->getCode(),
            'initialBalance' => [
                'amount ' => $initialBalance === null ? null : $initialBalance->getAmount(),
                'currency' => $initialBalance === null ? null : $initialBalance->getCurrency()->getCode(),
            ],
        ]);

        if ($initialBalance instanceof Money) {
            $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
            $arNewCard = array_merge(
                BonusServer\Cards\Formatters\Card::toArrayForCreateNewCard($newCard),
                [
                    'balance' => (float)$decimalFormatter->format($initialBalance),
                ]
            );
        } else {
            $arNewCard = array_merge(
                BonusServer\Cards\Formatters\Card::toArrayForCreateNewCard($newCard),
                [
                    'balance' => 0,
                ]
            );
        }
        // добавили карту
        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/card/add',
            RequestMethodInterface::METHOD_POST,
            $arNewCard
        );
        // вычитываем карту с сервера
        $card = $this->getByCardId(new BonusServer\Cards\DTO\CardId($requestResult['id']));

        $this->log->debug('rarus.bonus.server.cards.transport.organization.addNewCard.finish', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode()->getCode(),
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByCardId.start', [
            'cardId' => $cardId->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s', $cardId->getId()),
            RequestMethodInterface::METHOD_GET
        );

        $card = BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($requestResult['card'], $this->getDefaultCurrency(), $this->apiClient->getTimezone());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByCardId.finish', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode()->getCode(),
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.activate.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/activate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $activatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.activate.finish', [
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.deactivate.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/deactivate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $deactivatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.deactivate.finish', [
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.update.start', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode()->getCode(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            BonusServer\Cards\Formatters\Card::toArrayForUpdateCard($card)
        );

        $updatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.update.finish', [
            'cardId' => $updatedCard->getCardId()->getId(),
            'code' => $updatedCard->getCode(),
            'barcode' => $updatedCard->getBarcode()->getCode(),
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.delete.start', [
            'cardId' => $card->getCardId()->getId(),
            'isIgnorePositiveBalance' => $isIgnorePositiveBalance,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/delete', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $this->log->debug('rarus.bonus.server.cards.transport.organization.delete.finish', [
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.block.start', [
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

        $this->log->debug('rarus.bonus.server.cards.transport.organization.block.finish', [
            'cardId' => $blockedCard->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
            'blockedDescription' => $card->getCardStatus()->getBlockedDescription(),
            'code' => $blockedCard->getCode(),
            'barcode' => $blockedCard->getBarcode()->getCode(),
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.unblock.start', [
            'cardId' => $card->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/unblock', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST
        );

        $unblockedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.unblock.finish', [
            'cardId' => $unblockedCard->getCardId()->getId(),
            'isBlocked' => $card->getCardStatus()->isBlocked(),
            'blockedDescription' => $card->getCardStatus()->getBlockedDescription(),
            'code' => $unblockedCard->getCode(),
            'barcode' => $unblockedCard->getBarcode()->getCode(),
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.setAccumulationAmount.start', [
            'cardId' => $card->getCardId()->getId(),
            'accumSaleAmount' => $card->getAccumSaleAmount()->getAmount(),
            'sumValue' => $sum->getAmount(),
            'sumCurrency' => $sum->getCurrency()->getCode(),
        ]);

        $decimalFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/accumulate', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            [
                'reset' => false,
                'sum' => (float)$decimalFormatter->format($sum),
            ]
        );

        $this->log->debug('rarus.bonus.server.cards.transport.organization.setAccumulationAmount.finish');
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.isCardCanLevelUp.start', [
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

        $this->log->debug('rarus.bonus.server.cards.transport.organization.isCardCanLevelUp.finish', [
            'cardId' => $card->getCardId()->getId(),
            'isCardCanLevelUp' => $isCardCanLevelUp,
        ]);

        return $isCardCanLevelUp;
    }

    /**
     * повышение уровня карты
     *
     * если уровень карты повышен успешно, то возвращается null
     * если же сервер не смог произвести повышение уровня карты, то возвращается объект содержащий описание
     * что требуется для повышения уровня карты
     *
     * @param BonusServer\Cards\DTO\Card $card
     *
     * @return null|BonusServer\Cards\DTO\Level\LevelDescription
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function levelUp(BonusServer\Cards\DTO\Card $card): ?BonusServer\Cards\DTO\Level\LevelDescription
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.levelUp.start', [
            'cardId' => $card->getCardId()->getId(),
            'cardLevelId' => $card->getCardLevelId()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card/%s/levelup', $card->getCardId()->getId()),
            RequestMethodInterface::METHOD_POST,
            [
                'check' => false,
            ]
        );

        $levelDescription = null;
        if (array_key_exists('level_up', $requestResult)) {
            // уровень карты успешно повышен
            $this->log->info('rarus.bonus.server.cards.transport.organization.levelUp.success', [
                'result' => $requestResult,
            ]);

        } else {
            // уровень карты не повышен
            $this->log->warning('rarus.bonus.server.cards.transport.organization.levelUp.failure', [
                'result' => $requestResult,
            ]);
            $levelDescription = BonusServer\Cards\DTO\Level\Fabric::initLevelDescriptionFromServerResponse($requestResult['next_level_up'], $this->getDefaultCurrency());
        }

        return $levelDescription;
    }

    /**
     * @param BonusServer\Cards\DTO\Barcode\Barcode $cardBarcode
     *
     * @return BonusServer\Cards\DTO\Card
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getByBarcode(BonusServer\Cards\DTO\Barcode\Barcode $cardBarcode): BonusServer\Cards\DTO\Card
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByBarcode.start', [
            'cardBarcode' => $cardBarcode->getCode(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/card?page=1&per_page=1&calculate_count=false&barcode=%s', $cardBarcode->getCode()),
            RequestMethodInterface::METHOD_GET
        );

        $card = BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($requestResult['cards'][0], $this->getDefaultCurrency(), $this->apiClient->getTimezone());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByBarcode.finish', [
            'cardId' => $card->getCardId()->getId(),
            'code' => $card->getCode(),
            'barcode' => $card->getBarcode()->getCode(),
        ]);

        return $card;
    }

    /**
     * получение коллекции уровней карт
     *
     * @param null|BonusServer\Transport\DTO\Pagination $pagination
     *
     * @return BonusServer\Cards\DTO\Level\LevelCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getCardLevelList(?BonusServer\Transport\DTO\Pagination $pagination = null): BonusServer\Cards\DTO\Level\LevelCollection
    {
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getCardLevelList.start');

        $cardLevelCollection = new BonusServer\Cards\DTO\Level\LevelCollection();
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/card_level?%s&calculate_count=true',
                    BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination)
                ),
                RequestMethodInterface::METHOD_GET
            );
            foreach ((array)$requestResult['card_level'] as $cardLevel) {
                $cardLevelCollection->attach(BonusServer\Cards\DTO\Level\Fabric::initFromServerResponse($cardLevel, $this->getDefaultCurrency()));
            }
            $cardLevelCollection->rewind();
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если уровни кард не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        $this->log->debug('rarus.bonus.server.cards.transport.organization.getCardLevelList.finish', [
            'itemsCount' => $cardLevelCollection->count(),
        ]);

        return $cardLevelCollection;
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.getByFilter.start', [
            'cardFilterQuery' => BonusServer\Cards\Formatters\CardFilter::toUrlArguments($cardFilter),
        ]);

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/card/?%s', BonusServer\Cards\Formatters\CardFilter::toUrlArguments($cardFilter)),
                RequestMethodInterface::METHOD_GET
            );

            foreach ((array)$requestResult['cards'] as $card) {
                $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency(), $this->apiClient->getTimezone()));
            }

            $this->log->debug('rarus.bonus.server.cards.transport.organization.getByFilter.finish', [
                'itemsCount' => $cardCollection->count(),
            ]);
            $cardCollection->rewind();
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если карты по фильтру не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.attachToUser.start', [
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
        $this->log->debug('rarus.bonus.server.cards.transport.organization.attachToUser.attachResult', [
            'attachResult' => $requestResult,
        ]);

        // перечитываем карту с обновлённой привзякой
        $updatedCard = $this->getByCardId($card->getCardId());

        $this->log->debug('rarus.bonus.server.cards.transport.organization.attachToUser.finish', [
            'cardId' => $card->getCardId()->getId(),
            'cardCode' => $card->getCode(),
            'cardUserId' => $updatedCard->getUserId() === null ? null : $updatedCard->getUserId()->getId(),
        ]);

        return $updatedCard;
    }
}