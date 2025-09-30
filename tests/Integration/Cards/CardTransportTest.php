<?php

namespace Rarus\LMS\SDK\Tests\Integration\Cards;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use TestEnvironmentManager;

class CardTransportTest extends TestCase
{
    private Client $client;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_card_by_id(): void
    {
        $userId = 1;
        $cardDto = $this->client->cards()->getCardById($userId);
        $this->assertInstanceOf(CardDto::class, $cardDto);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_card_by_barcode(): void
    {
        $barcode = '1000000001';
        $cardDto = $this->client->cards()->getCardByBarCode($barcode);
        $this->assertInstanceOf(CardDto::class, $cardDto);
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
