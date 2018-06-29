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
     * @return Discounts\DTO\Estimate
     * @throws BonusServer\Exceptions\ApiClientException
     * @throws BonusServer\Exceptions\NetworkException
     * @throws BonusServer\Exceptions\UnknownException
     */
    public function calculateDiscounts(BonusServer\Discounts\DTO\Document $discountDocument): Discounts\DTO\Estimate
    {
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.start', [
            'role' => 'organization',
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            '/organization/calculate_document',
            RequestMethodInterface::METHOD_POST,
            Discounts\Formatters\Document::toArray($discountDocument)
        );
        $estimate = Discounts\DTO\Fabric::initEstimateFromServerResponse($this->getDefaultCurrency(), $requestResult);
        $this->log->debug('rarus.bonus.server.Discounts.transport.calculateDiscounts.start', [
            'documentItemsCount' => $estimate->getDocumentItems()->count(),
            'discountItemsCount' => $estimate->getDiscountItems()->count(),
        ]);

        return $estimate;
    }
}