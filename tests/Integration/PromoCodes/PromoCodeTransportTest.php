<?php

declare(strict_types=1);

namespace Integration\PromoCodes;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\PromoСodes\DTO\HoldPromoCodeDto;
use Rarus\LMS\SDK\PromoСodes\DTO\HoldPromoCodeExpiresDto;
use Rarus\LMS\SDK\PromoСodes\DTO\HoldPromoCodePeriod;
use Rarus\LMS\SDK\PromoСodes\DTO\HoldPromoCodeState;
use TestEnvironmentManager;

final class PromoCodeTransportTest extends TestCase
{
    private Client $client;

    public function test_get_promo_code(): void
    {
        $code = '101';
        $promoCodeDto = $this->client->promoCodes()->getPromoCode($code);
        $this->assertEquals($promoCodeDto->code, '101');
    }

    public function test_get_hold_promo_code(): void
    {
        $newHoldPromoCode = new HoldPromoCodeDto(
            cardId: 1,
            code: '1051',
            description: 'test',
            expires: new HoldPromoCodeExpiresDto(
                date: new \DateTimeImmutable('+20 day'),
                period: HoldPromoCodePeriod::Date,
                value: null
            ),
        );

        $holdPromoCodeId = $this->client->promoCodes()->createHoldPromoCode($newHoldPromoCode);
        $holdPromoCode = $this->client->promoCodes()->getHoldPromoCode($holdPromoCodeId);

        $this->assertEquals($holdPromoCode->description, $newHoldPromoCode->description);
    }

    public function test_delete_hold_bonus(): void
    {
        $newHoldPromoCode = new HoldPromoCodeDto(
            cardId: 1,
            code: '1041',
            description: 'test',
            expires: new HoldPromoCodeExpiresDto(
                date: new \DateTimeImmutable('+20 day'),
                period: HoldPromoCodePeriod::Date,
                value: null
            ),
        );

        $holdPromoCodeId = $this->client->promoCodes()->createHoldPromoCode($newHoldPromoCode);
        $this->client->promoCodes()->deleteHoldPromoCode($holdPromoCodeId);

        $holdPromoCode = $this->client->promoCodes()->getHoldPromoCode($holdPromoCodeId);
        $this->assertEquals($holdPromoCode->state, HoldPromoCodeState::Cancelled);
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
