<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Tests\Unit\Cards;

use PHPUnit\Framework\TestCase;
use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Cards\DTO\CardLevelDto;
use Rarus\LMS\SDK\Cards\DTO\SalesDto;
use Rarus\LMS\SDK\Cards\DTO\TransactionDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Users\DTO\UserDto;
use TestEnvironmentManager;

final class CardDtoTest extends TestCase
{
    /**
     * @throws ApiClientException
     */
    public function test_create_from_array_full(): void
    {
        $data = [
            'id' => 1,
            'external_id' => 'e42b7a41-7515-a9d3-42eb-7f066a94cc0c',
            'account' => '2d725644-28d1-4e25-56f4-12d215f60635',
            'card_level' => [
                'id' => 1,
                'name' => 'Уровень карты №1 Базовый',
            ],
            'permissions' => [],
            'client' => [
                'id' => 1,
                'name' => 'Александр',
                'phone' => '00000000001',
                'email' => 'test1@example.com',
                'birthday' => 31622400000,
                'gender' => 'male',
                'properties' => [],
            ],
            'transactions' => [
                'first' => '0001-01-01T00:00:00Z',
                'last' => '0001-01-01T00:00:00Z',
            ],
            'type_cards' => [],
            'name' => 'Card 1000000001',
            'barcode' => '1000000001',
            'magnetic_code' => null,
            'is_physical' => false,
            'blocked' => false,
            'date_blocked' => null,
            'state' => 'active',
            'date_state' => 1755786311533,
            'date_activated' => 1755786311533,
            'balance' => 50970.5,
            'balance_date' => 1755865357993,
            'turnover' => 122348.87,
            'sales' => [
                'first' => 1661647082000,
                'last' => 1751155395000,
            ],
            'other_cards_on_account' => [
                [
                    'id' => 2,
                    'external_id' => 'fb87f348-b804-8a1d-9f74-ec7b1bf6ead9',
                    'barcode' => '2000000001',
                    'magnetic_code' => null,
                    'state' => 'active',
                    'date_state' => 1755786311533,
                    'date_activated' => 1755786311533,
                    'is_physical' => false,
                    'blocked' => false,
                    'date_blocked' => null,
                    'type_cards' => [],
                    'card_level' => [
                        'id' => 2,
                        'name' => 'Уровень карты №2 Продвинутый',
                    ],
                    'balance' => 0,
                    'balance_date' => null,
                    'client' => [
                        'id' => 1,
                        'name' => 'Александр',
                        'phone' => '00000000001',
                        'email' => 'test1@example.com',
                    ],
                    'permissions' => [],
                ],
            ],
        ];

        $dateTimeZone = new \DateTimeZone(\TestEnvironmentManager::DEFAULT_TIMEZONE);
        $currency = TestEnvironmentManager::getDefaultCurrency();
        $dto = CardDto::createFromArray($data, $currency, $dateTimeZone);

        $this->assertSame(1, $dto->id);
        $this->assertSame('e42b7a41-7515-a9d3-42eb-7f066a94cc0c', $dto->externalId);
        $this->assertInstanceOf(CardLevelDto::class, $dto->cardLevel);
        $this->assertSame('Уровень карты №1 Базовый', $dto->cardLevel->name);
        $this->assertInstanceOf(UserDto::class, $dto->client);
        $this->assertSame('Александр', $dto->client->name);
        $this->assertInstanceOf(TransactionDto::class, $dto->transactions);
        $this->assertInstanceOf(SalesDto::class, $dto->sales);
        $this->assertCount(1, $dto->otherCardsOnAccount);
        $this->assertInstanceOf(CardDto::class, $dto->otherCardsOnAccount[0]);

        // Проверка обратного преобразования
        $arrayBack = $dto->toArray();
        $this->assertSame($data['id'], $arrayBack['id']);
        $this->assertSame($data['external_id'], $arrayBack['external_id']);
        $this->assertSame($data['client']['name'], $arrayBack['client']['name']);
        $this->assertSame($data['sales']['first'], $arrayBack['sales']['first']);
    }

    public function test_create_from_array_with_minimal_data(): void
    {
        $data = [
            'id' => 10,
            'external_id' => 'test-external',
            'account' => 'acc-1',
            'card_level' => null,
            'permissions' => [],
            'client' => null,
            'transactions' => null,
            'type_cards' => [],
            'name' => 'Test Card',
            'barcode' => 'BAR123',
            'magnetic_code' => null,
            'is_physical' => true,
            'blocked' => false,
            'date_blocked' => null,
            'state' => 'active',
            'date_state' => null,
            'date_activated' => null,
            'balance' => 0.0,
            'balance_date' => null,
            'turnover' => 0.0,
            'sales' => null,
            'other_cards_on_account' => [],
        ];

        $dateTimeZone = new \DateTimeZone(\TestEnvironmentManager::DEFAULT_TIMEZONE);
        $currency = TestEnvironmentManager::getDefaultCurrency();

        $dto = CardDto::createFromArray($data, $currency, $dateTimeZone);

        $this->assertSame(10, $dto->id);
        $this->assertSame('Test Card', $dto->name);
        $this->assertSame([], $dto->otherCardsOnAccount);
        $this->assertNull($dto->cardLevel);
        $this->assertNull($dto->client);

        $arrayBack = $dto->toArray();
        $this->assertSame('Test Card', $arrayBack['name']);
        $this->assertSame([], $arrayBack['other_cards_on_account']);
    }
}
