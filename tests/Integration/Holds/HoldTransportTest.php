<?php

declare(strict_types=1);

namespace Integration\Holds;

use DateTimeImmutable;
use Exception;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusDto;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusExpiresDto;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusPeriod;
use Rarus\LMS\SDK\Holds\DTO\HoldBonusState;
use Rarus\LMS\SDK\Utils\MoneyParser;
use TestEnvironmentManager;

final class HoldTransportTest extends TestCase
{
    private Client $client;

    public function test_get_hold_bonus(): void
    {
        $holdBonusDto = new HoldBonusDto(
            amount: MoneyParser::parse('1000', new Currency('RUB')),
            cardId: 2,
            description: 'test',
            expires: new HoldBonusExpiresDto(
                date: new DateTimeImmutable('+20 day'),
                period: HoldBonusPeriod::Date
            ),
        );

        $holdBonusId = $this->client->holds()->createHoldBonus($holdBonusDto);
        $holdBonus = $this->client->holds()->getHoldBonus($holdBonusId);

        $this->assertEquals($holdBonus->description, $holdBonusDto->description);
    }

    public function test_delete_hold_bonus(): void
    {
        $holdBonusDto = new HoldBonusDto(
            amount: MoneyParser::parse('1000', new Currency('RUB')),
            cardId: 2,
            description: 'test',
            expires: new HoldBonusExpiresDto(
                date: new DateTimeImmutable('+20 day'),
                period: HoldBonusPeriod::Date
            ),
        );

        $holdBonusId = $this->client->holds()->createHoldBonus($holdBonusDto);
        $this->client->holds()->deleteHoldBonus($holdBonusId);

        $holdBonus = $this->client->holds()->getHoldBonus($holdBonusId);
        $this->assertEquals($holdBonus->state, HoldBonusState::Cancelled);
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
