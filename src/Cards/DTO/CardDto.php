<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Cards\DTO;

use DateTimeZone;
use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Users\DTO\UserDto;
use Rarus\LMS\SDK\Utils\MoneyParser;

final readonly class CardDto
{
    /**
     * @param  array<string>  $permissions
     * @param  array<string>  $typeCards
     * @param  array<CardDto>  $otherCardsOnAccount
     */
    public function __construct(
        public int $id,
        public string $externalId,
        public string $account,
        public ?CardLevelDto $cardLevel,
        public array $permissions,
        public ?UserDto $client,
        public ?TransactionDto $transactions,
        public array $typeCards,
        public string $name,
        public string $barcode,
        public ?string $magneticCode,
        public bool $isPhysical,
        public bool $blocked,
        public ?int $dateBlocked,
        public CardState $state,
        public ?int $dateState,
        public ?int $dateActivated,
        public Money $balance,
        public ?int $balanceDate,
        public Money $turnover,
        public ?SalesDto $sales,
        /** @var CardDto[] */
        public array $otherCardsOnAccount,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'external_id' => $this->externalId,
            'account' => $this->account,
            'card_level' => $this->cardLevel?->toArray(),
            'permissions' => $this->permissions,
            'client' => $this->client?->toArray(),
            'transactions' => $this->transactions?->toArray(),
            'type_cards' => $this->typeCards,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'magnetic_code' => $this->magneticCode,
            'is_physical' => $this->isPhysical,
            'blocked' => $this->blocked,
            'date_blocked' => $this->dateBlocked,
            'state' => $this->state->value,
            'date_state' => $this->dateState,
            'date_activated' => $this->dateActivated,
            'balance' => MoneyParser::toString($this->balance),
            'balance_date' => $this->balanceDate,
            'turnover' => MoneyParser::toString($this->turnover),
            'sales' => $this->sales?->toArray(),
            'other_cards_on_account' => array_map(fn (CardDto $cardDto): array => $cardDto->toArray(), $this->otherCardsOnAccount),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            (int) $data['id'],
            (string) $data['external_id'],
            (string) $data['account'],
            isset($data['card_level']) ? CardLevelDto::fromArray($data['card_level']) : null,
            $data['permissions'] ?? [],
            isset($data['client']) ? UserDto::fromArray($data['client'], $currency, $dateTimeZone) : null,
            ! empty($data['transactions']['first']) && ! empty($data['transactions']['last']) ? TransactionDto::fromArray(
                $data['transactions'],
                $dateTimeZone
            ) : null,
            $data['type_cards'] ?? [],
            (string) $data['name'],
            (string) $data['barcode'],
            $data['magnetic_code'] ?? null,
            (bool) $data['is_physical'],
            (bool) $data['blocked'],
            $data['date_blocked'] ?? null,
            CardState::from((string) $data['state']),
            $data['date_state'] ?? null,
            $data['date_activated'] ?? null,
            MoneyParser::parse($data['balance'] ?? 0.0, $currency),
            $data['balance_date'] ?? null,
            MoneyParser::parse($data['turnover'] ?? 0.0, $currency),
            ! empty($data['sales']['first']) && ! empty($data['sales']['last']) ? SalesDto::fromArray(
                $data['sales'],
                $dateTimeZone
            ) : null,
            array_map(fn (array $c): \Rarus\LMS\SDK\Cards\DTO\CardDto => CardDto::fromArray($c, $currency, $dateTimeZone),
                $data['other_cards_on_account'] ?? []),
        );
    }
}
