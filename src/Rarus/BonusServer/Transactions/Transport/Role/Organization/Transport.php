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
            'dateFrom' => $dateFrom === null ? null : $dateFrom->format(\DATE_ATOM),
            'dateTo' => $dateTo === null ? null : $dateTo->format(\DATE_ATOM),
            'pagination' => $pagination === null ? null : [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);
        $historySalesCollection = new HistoryItemCollection();

        try {
            $queryString = '';
            if ($pagination !== null) {
                $queryString .= sprintf('&%s', BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination));
            }
            if ($dateFrom !== null) {
                $queryString .= sprintf('&date_from=%s', BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($dateFrom));
            }
            if ($dateTo !== null) {
                $queryString .= sprintf('&date_to=%s', BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($dateTo));
            }

            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/sale_info?card_id=%s%s', $card->getCardId()->getId(), $queryString),
                RequestMethodInterface::METHOD_GET
            );

            foreach ((array)$requestResult['sales'] as $arSaleItem) {
                $historySalesCollection->attach(BonusServer\Transactions\DTO\SalesHistory\Fabric::initHistoryItemFromServerResponse(
                    $this->getDefaultCurrency(),
                    $arSaleItem
                ));
            }
            $historySalesCollection->rewind();
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если транзакции не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }
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
     * @return BonusServer\Transactions\DTO\Points\Transactions\PaginationResponse
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function getTransactionsByCard(BonusServer\Cards\DTO\Card $card, ?\DateTime $dateFrom = null, ?\DateTime $dateTo = null, ?Pagination $pagination = null): BonusServer\Transactions\DTO\Points\Transactions\PaginationResponse
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getTransactionsByCard.start', [
            'cardId' => $card->getCardId()->getId(),
            'dateFrom' => $dateFrom === null ? null : $dateFrom->format(\DATE_ATOM),
            'dateTo' => $dateTo === null ? null : $dateTo->format(\DATE_ATOM),
            'pagination' => $pagination === null ? null : [
                'pageNumber' => $pagination->getPageNumber(),
                'pageSize' => $pagination->getPageSize(),
            ],
        ]);

        $trxCollection = new BonusServer\Transactions\DTO\Points\Transactions\TransactionCollection();
        $paginationResponse = new BonusServer\Transactions\DTO\Points\Transactions\PaginationResponse($trxCollection, new Pagination());
        $queryString = '';
        try {
            if ($pagination !== null) {
                $queryString .= sprintf('&%s', BonusServer\Transport\Formatters\Pagination::toRequestUri($pagination));
            }
            if ($dateFrom !== null) {
                $queryString .= sprintf('&date_from=%s', BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($dateFrom));
            }
            if ($dateTo !== null) {
                $queryString .= sprintf('&date_to=%s', BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($dateTo));
            }
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('/organization/transaction?card_id=%s%s', $card->getCardId()->getId(), $queryString),
                RequestMethodInterface::METHOD_GET
            );

            // формируем коллекцию транзакций
            foreach ((array)$requestResult['transactions'] as $arTrx) {
                $trxCollection->attach(BonusServer\Transactions\DTO\Points\Transactions\Fabric::initPointTransactionFromServerResponse(
                    $this->getDefaultCurrency(),
                    $arTrx,
                    $this->apiClient->getTimezone()
                ));
            }
            $trxCollection->rewind();

            $paginationResponse = new BonusServer\Transactions\DTO\Points\Transactions\PaginationResponse(
                $trxCollection,
                BonusServer\Transport\DTO\Fabric::initPaginationFromServerResponse($requestResult['pagination'])
            );
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если транзакции не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }
        $this->log->debug('rarus.bonus.server.transactions.transport.organization.getTransactionsByCard.finish', [
            'itemsCount' => $paginationResponse->getTransactionCollection()->count(),
        ]);

        return $paginationResponse;
    }

    /**
     * @param BonusServer\Transactions\DTO\Sale $saleTransaction
     * @param \DateTime|null                    $dateCalculate
     *
     * @return BonusServer\Transactions\DTO\FinalScore\FinalScore
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addSaleTransaction(BonusServer\Transactions\DTO\Sale $saleTransaction, ?\DateTime $dateCalculate = null): BonusServer\Transactions\DTO\FinalScore\FinalScore
    {
        $this->log->debug('rarus.bonus.server.transactions.transport.addSaleTransaction.start', [
            'cardId' => $saleTransaction->getCardId()->getId(),
            'shopId' => $saleTransaction->getShopId()->getId(),
            'doc_id' => $saleTransaction->getDocument()->getId(),
            'kkm_id' => $saleTransaction->getCashRegister()->getId(),
            'dateCalculate' => $dateCalculate === null ? null : $dateCalculate->format(\DATE_ATOM),
        ]);

        if ($dateCalculate === null) {
            $queryData = BonusServer\Transactions\Formatters\Sale::toArray($saleTransaction);
        } else {
            $queryData = array_merge(
                BonusServer\Transactions\Formatters\Sale::toArray($saleTransaction),
                ['date_calculate' => BonusServer\Util\DateTimeParser::convertToServerFormatTimestamp($dateCalculate)]
            );
        }

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/process_bonus',
            RequestMethodInterface::METHOD_POST,
            $queryData
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

    /**
     * @param BonusServer\Transactions\DTO\Manual $manual
     *
     * @return BonusServer\Transactions\DTO\Document\Document
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function addManualTransaction(BonusServer\Transactions\DTO\Manual $manual): BonusServer\Transactions\DTO\Document\Document
    {
        $this->log->debug(
            'rarus.bonus.server.transactions.transport.addManualTransaction.start',
            [
                'cardId' => $manual->getCardId()->getId(),
                'shopId' => $manual->getShopId()->getId(),
                'sum'    => $manual->getSum(),
                'doc_id' => $manual->getDocument()->getId(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/transaction/add',
            RequestMethodInterface::METHOD_POST,
            BonusServer\Transactions\Formatters\Manual::toArray($manual)
        );

        $document = BonusServer\Transactions\DTO\Document\Fabric::createNewInstance($requestResult['id'], 0);

        $this->log->debug(
            'rarus.bonus.server.transactions.transport.addManualTransaction.end',
            [
                'id' => $document->getId(),
            ]
        );

        return $document;
    }
}
