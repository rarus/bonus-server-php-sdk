<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport\Role\User;

use Rarus\BonusServer;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Transactions\Transport\Role\User
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param \DateTime|null             $dateFrom
     *
     * @return BonusServer\Transactions\DTO\Operations\OperationCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getSalesHistory(BonusServer\Cards\DTO\Card $card, ?\DateTime $dateFrom = null): BonusServer\Transactions\DTO\Operations\OperationCollection
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.getSalesHistory.start', [
            'cardId' => $card->getCardId()->getId(),
            'dateFrom' => $dateFrom === null ? null : $dateFrom->format(\DATE_ATOM),
        ]);

        if ($dateFrom === null) {
            $queryStr = sprintf('/user/sales_history?card_id=%s', $card->getCardId()->getId());
        } else {
            $queryStr = sprintf(
                '/user/sales_history?card_id=%s&from=%s',
                $card->getCardId()->getId(),
                $dateFrom->getTimestamp()
            );
        }
        $requestResult = $this->apiClient->executeApiRequest(
            $queryStr,
            RequestMethodInterface::METHOD_GET
        );

        $operationCollection = new BonusServer\Transactions\DTO\Operations\OperationCollection();
        foreach ($requestResult['history'] as $arHistoryItem) {
            $operationCollection->attach(
                BonusServer\Transactions\DTO\Operations\Fabric::initFinalScoreFromServerResponse(
                    $this->getDefaultCurrency(),
                    $arHistoryItem
                )
            );
        }
        $operationCollection->rewind();

        $this->log->debug('rarus.bonus.server.transactions.transport.getSalesHistory.finish', [
            'operationItemsCount' => $operationCollection->count(),
        ]);

        return $operationCollection;
    }
}
