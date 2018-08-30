<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport\Role\Organization;

use Rarus\BonusServer;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Transactions\DTO\SalesHistory\HistoryItemCollection;
use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Transactions\Transport
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param \DateTime|null             $dateFrom
     * @param \DateTime|null             $dateTo
     * @param null|Pagination            $pagination
     *
     * @return BonusServer\Transactions\DTO\SalesHistory\HistoryItemCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getSalesHistoryByCard(BonusServer\Cards\DTO\Card $card, ?\DateTime $dateFrom = null, ?\DateTime $dateTo = null, ?Pagination $pagination = null): BonusServer\Transactions\DTO\SalesHistory\HistoryItemCollection
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getSalesHistoryByCard.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $queryString = '';
        if (null !== $pagination) {
            $queryString .= sprintf('&%s', BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination));
        } elseif (null !== $dateFrom) {
            $queryString .= sprintf('&date_from=%s', $dateFrom->getTimestamp());
        } elseif (null !== $dateTo) {
            $queryString .= sprintf('&date_to=%s', $dateTo->getTimestamp());
        }
        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('/organization/sale_info?card_id=%s%s', $card->getCardId()->getId(), $queryString),
            RequestMethodInterface::METHOD_GET
        );

        $historySalesCollection = new HistoryItemCollection();
        foreach ($requestResult['sales'] as $arSaleItem) {
            $historySalesCollection->attach(BonusServer\Transactions\DTO\SalesHistory\Fabric::initHistoryItemFromServerResponse(
                $this->getDefaultCurrency(),
                $arSaleItem
            ));
        }
        $historySalesCollection->rewind();

        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getSalesHistoryByCard.finish', [
            'operationItemsCount' => $historySalesCollection->count(),
        ]);

        return $historySalesCollection;
    }

    /**
     * @param BonusServer\Cards\DTO\Card $card
     * @param \DateTime|null             $dateFrom
     * @param \DateTime|null             $dateTo
     * @param null|Pagination            $pagination
     *
     * @return BonusServer\Transactions\DTO\Points\PointTransactionCollection
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getTransactionsByCard(BonusServer\Cards\DTO\Card $card, ?\DateTime $dateFrom = null, ?\DateTime $dateTo = null, ?Pagination $pagination = null): BonusServer\Transactions\DTO\Points\PointTransactionCollection
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getTransactionsByCard.start', [
            'cardId' => $card->getCardId()->getId(),
        ]);

        $trxCollection = new BonusServer\Transactions\DTO\Points\PointTransactionCollection();
        try {
            $queryString = '';
            if ($pagination !== null) {
                $queryString .= sprintf('&%s', BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination));
            } elseif ($dateFrom !== null) {
                $queryString .= sprintf('&date_from=%s', $dateFrom->getTimestamp());
            } elseif ($dateTo !== null) {
                $queryString .= sprintf('&date_to=%s', $dateTo->getTimestamp());
            }
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/transaction?card_id=%s%s', $card->getCardId()->getId(), $queryString),
                RequestMethodInterface::METHOD_GET
            );
            foreach ((array)$requestResult['transactions'] as $arTrx) {
                $trxCollection->attach(BonusServer\Transactions\DTO\Points\Fabric::initPointTransactionFromServerResponse(
                    $this->getDefaultCurrency(),
                    $arTrx,
                    $this->apiClient->getTimezone()
                ));
            }
            $trxCollection->rewind();
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если транзакции не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getTransactionsByCard.finish', [
            'operationItemsCount' => $trxCollection->count(),
        ]);

        return $trxCollection;
    }

    /**
     * @param BonusServer\Transactions\DTO\Sale $saleTransaction
     *
     * @return BonusServer\Transactions\DTO\FinalScore\FinalScore
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addSaleTransaction(BonusServer\Transactions\DTO\Sale $saleTransaction): BonusServer\Transactions\DTO\FinalScore\FinalScore
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.addSaleTransaction.start', [
            'cardId' => $saleTransaction->getCardId()->getId(),
            'shopId' => $saleTransaction->getShopId()->getId(),
            'doc_id' => $saleTransaction->getDocument()->getId(),
            'kkm_id' => $saleTransaction->getCashRegister()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/process_bonus',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Transactions\Formatters\Sale::toArray($saleTransaction)
        );

        $finalScore = BonusServer\Transactions\DTO\FinalScore\Fabric::initFinalScoreFromServerResponse($this->getDefaultCurrency(), $requestResult);

        $this->log->debug('rarus.bonus.server.transactions.transport.addSaleTransaction.start', [
            'bonus_earned' => $finalScore->getBonusEarned()->getAmount(),
            'bonus_spent' => $finalScore->getBonusSpent()->getAmount(),
            'card_accum' => $finalScore->getCardAccumulationAmount()->getAmount(),
        ]);

        return $finalScore;
    }

    /**
     * @param BonusServer\Transactions\DTO\Refund $refundTransaction
     *
     * @return BonusServer\Transactions\DTO\FinalScore\FinalScore
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addRefundTransaction(BonusServer\Transactions\DTO\Refund $refundTransaction): BonusServer\Transactions\DTO\FinalScore\FinalScore
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.addRefundTransaction.start', [
            'cardId' => $refundTransaction->getCardId()->getId(),
            'shopId' => $refundTransaction->getShopId()->getId(),
            'doc_id' => $refundTransaction->getDocument()->getId(),
            'kkm_id' => $refundTransaction->getCashRegister()->getId(),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/process_bonus',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Transactions\Formatters\Refund::toArray($refundTransaction)
        );

        $finalScore = BonusServer\Transactions\DTO\FinalScore\Fabric::initFinalScoreFromServerResponse($this->getDefaultCurrency(), $requestResult);

        $this->log->debug('rarus.bonus.server.transactions.transport.addRefundTransaction.start', [
            'bonus_earned' => $finalScore->getBonusEarned()->getAmount(),
            'bonus_spent' => $finalScore->getBonusSpent()->getAmount(),
            'card_accum' => $finalScore->getCardAccumulationAmount()->getAmount(),
        ]);

        return $finalScore;
    }
}