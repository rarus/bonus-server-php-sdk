<?php

namespace RarusBonus\Tests\Integration\Cards;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use RarusBonus\Cards\DTO\CardDto;
use RarusBonus\Client;
use RarusBonus\Exceptions\ApiClientException;
use RarusBonus\Exceptions\NetworkException;
use RarusBonus\Exceptions\UnknownException;
use TestEnvironmentManager;

class CardsTransportTest extends TestCase
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
        $card = $this->client->cards()->getCardById($userId);
        $this->assertInstanceOf(CardDto::class, $card);
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_card_by_barcode(): void
    {
        $barcode = '1000000001';
        $card = $this->client->cards()->getCardByBarCode($barcode);
        $this->assertInstanceOf(CardDto::class, $card);
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
