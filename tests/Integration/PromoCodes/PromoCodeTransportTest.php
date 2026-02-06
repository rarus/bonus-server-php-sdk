<?php

declare(strict_types=1);

namespace Integration\PromoCodes;

use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\PromoCodes\DTO\HoldPromoCodeDto;
use Rarus\LMS\SDK\PromoCodes\DTO\HoldPromoCodeExpiresDto;
use Rarus\LMS\SDK\PromoCodes\DTO\HoldPromoCodePeriod;
use Rarus\LMS\SDK\PromoCodes\DTO\HoldPromoCodeState;
use TestEnvironmentManager;

final class PromoCodeTransportTest extends TestCase
{
    private Client $client;

    public function test_get_promo_code(): void
    {
        $code = 'MULTY-001';
        $promoCodeDto = $this->client->promoCodes()->getPromoCode($code);
        $this->assertEquals($promoCodeDto->code, 'MULTY-001');
    }

    public function test_get_hold_promo_code(): void
    {
        $holdPromoCodeDto = new HoldPromoCodeDto(
            cardId: 1,
            code: 'MULTY-001',
            description: 'test',
            expires: new HoldPromoCodeExpiresDto(
                date: new DateTimeImmutable('+20 day'),
                period: HoldPromoCodePeriod::Date
            ),
        );

        $holdPromoCodeId = $this->client->promoCodes()->createHoldPromoCode($holdPromoCodeDto);
        $holdPromoCode = $this->client->promoCodes()->getHoldPromoCode($holdPromoCodeId);

        $this->assertEquals($holdPromoCode->description, $holdPromoCodeDto->description);
    }

    public function test_delete_hold_bonus(): void
    {
        $holdPromoCodeDto = new HoldPromoCodeDto(
            cardId: 1,
            code: 'MULTY-001',
            description: 'test',
            expires: new HoldPromoCodeExpiresDto(
                date: new DateTimeImmutable('+20 day'),
                period: HoldPromoCodePeriod::Date
            ),
        );

        $holdPromoCodeId = $this->client->promoCodes()->createHoldPromoCode($holdPromoCodeDto);
        $this->client->promoCodes()->deleteHoldPromoCode($holdPromoCodeId);

        $holdPromoCode = $this->client->promoCodes()->getHoldPromoCode($holdPromoCodeId);
        $this->assertEquals($holdPromoCode->state, HoldPromoCodeState::Cancelled);
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
