<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Documents\DTO\DocumentDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class DocumentTransport extends BaseTransport
{
    /**
     * Выполняет расчет скидок для документа
     *
     * @param  DocumentDto  $documentDto  Document request
     * @return array<string, mixed>
     *
     * @throws UnknownException
     * @throws ApiClientException
     * @throws NetworkException
     */
    public function calculate(DocumentDto $documentDto): array
    {
        return $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/calculate',
            $documentDto->toArray()
        );
    }

    /**
     * Фиксирует покупку товаров и услуг клиентом в сервисе При фиксации не рассчитываются скидки, но выполняются начисления и списания бонусных баллов.
     * Предрассчитанные скидки могут быть переданы для фиксации.
     * При необходимости может перерасчитать бонусные скидки, если передан параметр recalc-bonus.
     *
     * @return array<string, mixed>
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function purchase(
        DocumentDto $documentDto,
        bool $recalcBonus = false,
        bool $noCommit = false
    ): array {
        return $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            sprintf('web-flow/document/purchase?recalc-bonus=%s&no-commit=%s', $recalcBonus, $noCommit),
            $documentDto->toArray()
        );
    }

    /**
     * Фиксирует возврат товаров и услуг клиентом в сервисе При фиксации не рассчитываются скидки, выполняются обратные начисления и списания бонусных баллов, пропорционально возвращаемым товарам.
     *
     * @return array<string, mixed>
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function refund(
        DocumentDto $documentDto,
        bool $noCommit = false
    ): array {
        return $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            sprintf('web-flow/document/refund?no-commit=%s', $noCommit),
            $documentDto->toArray()
        );
    }
}
