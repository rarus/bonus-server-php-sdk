<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\Transport\Role\Organization;

use Rarus\BonusServer\Discounts;
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
     * @param Discounts\DTO\Document $discountDocument
     *
     * @return null|Discounts\DTO\Estimate
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function calculateDiscounts(BonusServer\Discounts\DTO\Document $discountDocument): ?Discounts\DTO\Estimate
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.start', [
            'role' => 'organization',
        ]);

        $estimate = null;
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                '/organization/calculate_document',
                RequestMethodInterface::METHOD_POST,
                Discounts\Formatters\Document::toArray($discountDocument)
            );
            $estimate = Discounts\DTO\Fabric::initEstimateFromServerResponse($this->getDefaultCurrency(), $requestResult);
            $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.finish', [
                'documentItemsCount' => $estimate->getDocumentItems()->count(),
                'discountItemsCount' => $estimate->getDiscountItems()->count(),
            ]);
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если скидки не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        return $estimate;
    }

    /**
     * Метод вызывается для рассчёта скидки на товар для вывода на витрине. При вызове выполняется расчет суммовых и подарочных скидок.
     * Метод возвращает список примененных к строкам чека скидок и рассчитанный документ, производится рассчёт бонусных скидок
     *
     * @param Discounts\DTO\Document $discountDocument
     *
     * @return null|Discounts\DTO\Estimate
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function calculateDiscountsAndBonusDiscounts(BonusServer\Discounts\DTO\Document $discountDocument): ?Discounts\DTO\Estimate
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscountsAndBonusDiscounts.start', [
            'role' => 'organization',
        ]);
        $estimate = null;
        try {
            $requestResult = $this->apiClient->executeApiRequest(
                '/organization/calculate',
                RequestMethodInterface::METHOD_POST,
                Discounts\Formatters\Document::toArray($discountDocument)
            );

            $estimate = Discounts\DTO\Fabric::initEstimateFromServerResponse($this->getDefaultCurrency(), $requestResult);
            $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscountsAndBonusDiscounts.finish', [
                'documentItemsCount' => $estimate->getDocumentItems()->count(),
                'discountItemsCount' => $estimate->getDiscountItems()->count(),
            ]);
        } catch (BonusServer\Exceptions\ApiClientException $exception) {
            // если скидки не найдены, то сервер возврашает 404 статус выставив 114 код в данном случае мы его подавляем
            if ($exception->getCode() !== 114) {
                throw $exception;
            }
        }

        return $estimate;
    }
}
