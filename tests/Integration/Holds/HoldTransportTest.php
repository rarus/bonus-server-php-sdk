<?php

declare(strict_types=1);

namespace Integration\Holds;

use Money\Currency;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusDto;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusExpiresDto;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusPeriod;
use Rarus\LMS\SDK\Utils\MoneyParser;
use TestEnvironmentManager;

final class HoldTransportTest extends TestCase
{
    private Client $client;

    public function test_create_hold_bonus(): void
    {
        $newHoldBonus = new HoldBonusDto(
            amount: MoneyParser::parse('1000', new Currency('RUB')),
            cardId: 1,
            description: 'test',
            expires: new HoldBonusExpiresDto(
                date: new \DateTimeImmutable('+20 day'),
                period: HoldBonusPeriod::Date,
                value: null
            ),
            shopId: 1
        );

        $holdBonusId = $this->client->holds()->createHoldBonus($newHoldBonus);
        $this->assertIsInt($holdBonusId);
    }

    public function test_get_hold_bonus(): void
    {
        $newHoldBonus = new HoldBonusDto(
            amount: MoneyParser::parse('1000', new Currency('RUB')),
            cardId: 1,
            description: 'test',
            expires: new HoldBonusExpiresDto(
                date: new \DateTimeImmutable('+20 day'),
                period: HoldBonusPeriod::Date,
                value: null
            ),
            shopId: 1
        );

        $holdBonusId = $this->client->holds()->createHoldBonus($newHoldBonus);
        $holdBonus = $this->client->holds()->getHoldBonus($holdBonusId);

        $this->assertEquals($holdBonus->description, $newHoldBonus->description);;
    }

    public function test_delete_hold_bonus(): void
    {
        $newHoldBonus = new HoldBonusDto(
            amount: MoneyParser::parse('1000', new Currency('RUB')),
            cardId: 1,
            description: 'test',
            expires: new HoldBonusExpiresDto(
                date: new \DateTimeImmutable('+20 day'),
                period: HoldBonusPeriod::Date,
                value: null
            ),
            shopId: 1
        );

        $holdBonusId = $this->client->holds()->createHoldBonus($newHoldBonus);
        $this->assertIsInt($holdBonusId);

        $this->client->holds()->deleteHoldBonus($holdBonusId);
        try {
            $holdBonusId = $this->client->holds()->createHoldBonus($newHoldBonus);
        } catch (NetworkException $e) {
        } catch (ApiClientException $e) {
            $this->assertEquals($e->getCode(), 404);
        } catch (UnknownException $e) {
        }
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
