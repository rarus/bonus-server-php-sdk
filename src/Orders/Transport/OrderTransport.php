<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Orders\Transport;

use Fig\Http\Message\RequestMethodInterface;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Orders\DTO\OrderDto;
use Rarus\LMS\SDK\Orders\DTO\OrderStatus;
use Rarus\LMS\SDK\Transport\BaseTransport;

final class OrderTransport extends BaseTransport
{
    /**
     * Добавить заказ
     *
     * @return int order_id
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function addOrder(OrderDto $orderDto): int
    {
        return $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            'web-flow/order',
            $orderDto->toArray()
        );
    }

    /**
     * Получить заказ
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function getOrderById(int $id): OrderDto
    {
        $result = $this->transport->request(
            RequestMethodInterface::METHOD_GET,
            sprintf('web-flow/order/%s', $id),
        );

        return OrderDto::fromArray($result, $this->getDefaultCurrency(), $this->getDateTimeZone());
    }

    /**
     * Обновить заказ
     * @throws ApiClientException
     * @throws InvalidArgumentException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function updateOrder(OrderDto $orderDto): void
    {
        if ($orderDto->id === null) {
            throw new InvalidArgumentException('Order id is required');
        }

        $this->transport->request(
            RequestMethodInterface::METHOD_PUT,
            sprintf('web-flow/order/%s', $orderDto->id),
            $orderDto->toArray()
        );
    }

    /**
     * Изменить статус заказа
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function updateStatus(int $id, OrderStatus $orderStatus): void
    {
        $this->transport->request(
            RequestMethodInterface::METHOD_POST,
            sprintf('web-flow/order/%s/status', $id),
            ['status' => $orderStatus->value]
        );
    }

    /**
     * Удалить заказ
     *
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function deleteOrder(int $id): void
    {
        $this->transport->request(
            RequestMethodInterface::METHOD_DELETE,
            sprintf('web-flow/order/%s', $id),
        );
    }
}
