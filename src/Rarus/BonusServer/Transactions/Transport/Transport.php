<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\Transport;

use Rarus\BonusServer;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package Rarus\BonusServer\Transactions\Transport
 */
class Transport extends BonusServer\Transport\AbstractTransport
{
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
}