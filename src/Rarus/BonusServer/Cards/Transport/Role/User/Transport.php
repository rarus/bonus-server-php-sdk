<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\Role\User;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Cards\Transport\Role\User
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
        $this->log->debug('rarus.bonus.server.cards.transport.list.start', [
            'role' => 'user',
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/user/card/get_list',
            RequestMethodInterface::METHOD_GET
        );

        $cardCollection = new BonusServer\Cards\DTO\CardCollection();
        foreach ((array)$requestResult['cards'] as $card) {
            $cardCollection->attach(BonusServer\Cards\DTO\Fabric::initCardFromServerResponse($card, $this->getDefaultCurrency(), $this->apiClient->getTimezone()));
        }

        $this->log->debug('rarus.bonus.server.cards.transport.list.finish', [
            'itemsCount' => $cardCollection->count(),
        ]);

        return $cardCollection;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param int                        $lastTransactionsCount
     *
     * @return BonusServer\Cards\DTO\Balance\Balance
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getBalanceInfo(BonusServer\Cards\DTO\Card $card, int $lastTransactionsCount): BonusServer\Cards\DTO\Balance\Balance
    {
        $this->log->debug('rarus.bonus.server.cards.transport.getBalanceInfo.start', [
            'role' => 'user',
            'cardId' => $card->getCardId()->getId(),
            'lastTransactionsCount' => $lastTransactionsCount,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/user/card/%s/balance_info?last_transactions=%s',
                $card->getCardId()->getId(),
                $lastTransactionsCount
            ),
            RequestMethodInterface::METHOD_GET
        );

        $balance = BonusServer\Cards\DTO\Balance\Fabric::initFromServerResponse($this->getDefaultCurrency(), $requestResult);

        $this->log->debug('rarus.bonus.server.cards.transport.getBalanceInfo.finish', [
            'cardId' => $card->getCardId()->getId(),
            'availableBalance' => $balance->getAvailable()->getAmount(),
            'totalBalance' => $balance->getTotal()->getAmount(),
        ]);

        return $balance;
    }
}