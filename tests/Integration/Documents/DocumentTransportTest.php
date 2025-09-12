<?php

declare(strict_types=1);

namespace Integration\Documents;

use Money\Currency;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Documents\DTO\DocumentDto;
use Rarus\LMS\SDK\Documents\DTO\SaleItemDto;
use Rarus\LMS\SDK\Utils\MoneyParser;
use TestEnvironmentManager;

final class DocumentTransportTest extends TestCase
{
    private Client $client;

    public function test_calculate(): void
    {
        date_default_timezone_set('Europe/Moscow');
        $product = new SaleItemDto(
            productId: 'id-1',
            productName: 'name-1',
            price: MoneyParser::parse('1000', new Currency('RUB')),
            quantity: 1,
        );
        $products = [$product];
        $documentDto = new DocumentDto(
            docNumber: '1234567890',
            registerId: '1234567890',
            shopId: '1',
            items: $products,
        );
        $result = $this->client->documents()->calculate($documentDto);
        $this->assertNotEmpty($result['items']);
    }

    public function test_purchase(): void
    {
        date_default_timezone_set('Europe/Moscow');
        $product = new SaleItemDto(
            productId: 'id-1',
            productName: 'name-1',
            price: MoneyParser::parse('1000', new Currency('RUB')),
            quantity: 1,
        );
        $products = [$product];
        $documentDto = new DocumentDto(
            docNumber: '1234567890',
            registerId: '1234567890',
            shopId: '1',
            items: $products,
        );
        $result = $this->client->documents()->purchase($documentDto);
        $this->assertNotEmpty($result['items']);
    }

    public function test_refund(): void
    {
        date_default_timezone_set('Europe/Moscow');
        $product = new SaleItemDto(
            productId: 'id-1',
            productName: 'name-1',
            price: MoneyParser::parse('1000', new Currency('RUB')),
            quantity: 1,
        );
        $products = [$product];
        $documentDto = new DocumentDto(
            docNumber: '1234567890',
            registerId: '1234567890',
            shopId: '1',
            items: $products,
        );
        $result = $this->client->documents()->refund($documentDto);
        $this->assertNotEmpty($result['items']);
    }

    /**
     * @throws \Exception
     * @throws InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = TestEnvironmentManager::getInstance();
    }
}
