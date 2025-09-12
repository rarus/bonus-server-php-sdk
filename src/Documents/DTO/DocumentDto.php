<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final readonly class DocumentDto
{
    /**
     * @param  array<CertificatePaymentDto>|null  $certificatePayment
     * @param  array<HoldBonusDto>|null  $holdBonuses
     * @param  array<SaleItemDto>  $items
     * @param  array<PaymentDto>|null  $payment
     */
    public function __construct(
        public string $docNumber,
        public string $registerId,
        public string $shopId,
        public array $items,
        public ?\DateTimeImmutable $localDate = new \DateTimeImmutable,
        public ?Money $bonusDiscount = null,
        public ?int $cardId = null,
        public ?array $certificatePayment = null,
        public ?\DateTimeImmutable $date = null,
        public ?array $holdBonuses = null,
        public ?int $holdPromoId = null,
        public ?string $id = null,
        public ?array $payment = null,
        public ?string $promo = null,
        public ?string $saleChannelId = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, \DateTimeZone $dateTimeZone): self
    {
        return new self(
            docNumber: $data['doc_number'],
            registerId: $data['register_id'],
            shopId: $data['shop_id'],
            items: array_map(
                fn (array $item) => SaleItemDto::fromArray($item, $currency, $dateTimeZone),
                $data['items']
            ),
            localDate: isset($data['local_date']) ? DateTimeParser::fromTimestamp(
                $data['local_date'],
                $dateTimeZone
            ) : null,
            bonusDiscount: isset($data['bonus_discount']) ? MoneyParser::parse(
                $data['bonus_discount'],
                $currency
            ) : null,
            cardId: $data['card_id'] ?? null,
            certificatePayment: isset($data['certificate_payment']) ? array_map(
                fn (array $c) => CertificatePaymentDto::fromArray($c, $currency),
                $data['certificate_payment']
            ) : null,
            date: isset($data['date']) ? DateTimeParser::fromTimestamp($data['date'], $dateTimeZone) : null,
            holdBonuses: isset($data['hold_bonuses']) ? array_map(
                fn (array $b) => HoldBonusDto::fromArray($b, $currency),
                $data['hold_bonuses']
            ) : null,
            holdPromoId: $data['hold_promo_id'] ?? null,
            id: $data['id'] ?? null,
            payment: isset($data['payment']) ? array_map(
                fn (array $p) => PaymentDto::fromArray($p, $currency),
                $data['payment']
            ) : null,
            promo: $data['promo'] ?? null,
            saleChannelId: $data['sale_channel_id'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'bonus_discount' => $this->bonusDiscount ? MoneyParser::toString($this->bonusDiscount) : 0,
            'card_id' => $this->cardId,
            'certificate_payment' => $this->certificatePayment ? array_map(
                fn (CertificatePaymentDto $c) => $c->toArray(),
                $this->certificatePayment
            ) : null,
            'date' => $this->date ? DateTimeParser::toTimestamp($this->date) : null,
            'doc_number' => $this->docNumber,
            'hold_bonuses' => $this->holdBonuses ? array_map(
                fn (HoldBonusDto $b) => $b->toArray(),
                $this->holdBonuses
            ) : null,
            'hold_promo_id' => $this->holdPromoId,
            'id' => $this->id,
            'items' => array_map(
                fn (SaleItemDto $i) => $i->toArray(),
                $this->items
            ),
            'local_date' => $this->localDate?->format(DATE_ATOM),
            'payment' => $this->payment ? array_map(
                fn (PaymentDto $p) => $p->toArray(),
                $this->payment
            ) : null,
            'promo' => $this->promo,
            'register_id' => $this->registerId,
            'sale_channel_id' => $this->saleChannelId,
            'shop_id' => $this->shopId,
        ];
    }
}
