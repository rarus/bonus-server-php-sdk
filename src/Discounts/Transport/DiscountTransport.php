<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Discounts\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Discounts\DTO\DiscountCalculationDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class DiscountTransport extends BaseTransport
{
    /**
     * Calculate discounts for the given calculation request
     *
     * @param  DiscountCalculationDto  $discountCalculationDto  Discount calculation request
     * @return array<string, mixed>
     *
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function calculate(DiscountCalculationDto $discountCalculationDto): array
    {
        return $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/calculate',
            $discountCalculationDto->toArray()
        );
    }
}
