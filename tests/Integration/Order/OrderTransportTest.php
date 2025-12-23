<?php

declare(strict_types=1);

namespace Integration\Order;

use Exception;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Documents\DTO\SaleItemDto;
use Rarus\LMS\SDK\Orders\DTO\Factory;
use Rarus\LMS\SDK\Orders\DTO\OrderDto;
use Rarus\LMS\SDK\Orders\DTO\OrderStatus;
use Rarus\LMS\SDK\Utils\MoneyParser;
use TestEnvironmentManager;

final class OrderTransportTest extends TestCase
{
    private Client $client;

    public function test_order(): void
    {
        date_default_timezone_set('Europe/Moscow');
        $saleItemDto = new SaleItemDto(
            productId: 'id-1',
            productName: 'name-1',
            price: MoneyParser::parse('1000', new Currency('RUB')),
            quantity: 1,
        );
        $products = [$saleItemDto];
        $orderDto = new OrderDto(
            docNumber: '1', // номер заказа
            shopId: '1',
            items: $products,
            bonusDiscount: MoneyParser::parse('100', new Currency('RUB')),
            cardId: 2,
        );
        $orderId = $this->client->orders()->addOrder($orderDto);

        $orderDto = $this->client->orders()->getOrderById($orderId);
        $this->assertEquals($orderId, $orderDto->id);

        $updateOrderDto = Factory::fromDto($orderDto);
        $newDocNumber = '234';
        $updateOrderDto = $updateOrderDto->withDocNumber($newDocNumber)->build();
        $this->client->orders()->updateOrder($updateOrderDto);

        $orderDto = $this->client->orders()->getOrderById($orderId);
        $this->assertEquals($updateOrderDto->docNumber, $orderDto->docNumber);

        $newStatus = OrderStatus::Processing;
        $this->client->orders()->updateStatus($orderId, $newStatus);
        $orderDto = $this->client->orders()->getOrderById($orderId);
        $this->assertEquals($newStatus->value, $orderDto->orderStatus?->value);

        $newStatus = OrderStatus::New;
        $this->client->orders()->updateStatus($orderId, $newStatus);
        $orderDto = $this->client->orders()->getOrderById($orderId);
        $this->assertEquals($newStatus->value, $orderDto->orderStatus?->value);

        $this->client->orders()->deleteOrder($orderId);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = TestEnvironmentManager::getInstance();
    }
}
