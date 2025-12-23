<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Orders\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Documents\DTO\CertificatePaymentDto;
use Rarus\LMS\SDK\Documents\DTO\HoldBonusDto;
use Rarus\LMS\SDK\Documents\DTO\HoldCertificateDto;
use Rarus\LMS\SDK\Documents\DTO\PaymentDto;
use Rarus\LMS\SDK\Documents\DTO\SaleItemDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final readonly class OrderDto
{
    /**
     * @param  array<SaleItemDto>  $items
     * @param  array<CertificatePaymentDto>|null  $certificatePayment
     * @param  array<HoldBonusDto>|null  $holdBonuses
     * @param  array<HoldCertificateDto>|null  $holdCertificates
     * @param  array<PaymentDto>|null  $payment
     */
    public function __construct(
        public string $docNumber,
        public string $shopId,
        public array $items,
        public ?DateTimeImmutable $localDate = new DateTimeImmutable,
        public ?Money $bonusDiscount = null,
        public ?int $cardId = null,
        public ?array $certificatePayment = null,
        public ?DateTimeImmutable $date = null,
        public ?array $holdBonuses = null, // только при получении
        public ?array $holdCertificates = null, // только при получении
        public ?int $holdPromoId = null, // только при получении
        public ?array $payment = null,
        public ?string $promo = null,
        public ?string $saleChannelId = null,
        public ?string $id = null, // только при получении
        public ?bool $paidInAccounting = false,
        public ?OrderStatus $orderStatus = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            docNumber: $data['doc_number'],
            shopId: $data['shop_id'],
            items: array_map(
                fn (array $item): SaleItemDto => SaleItemDto::fromArray($item, $currency, $dateTimeZone),
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
                fn (array $c): CertificatePaymentDto => CertificatePaymentDto::fromArray($c, $currency),
                $data['certificate_payment']
            ) : null,
            date: isset($data['date']) ? DateTimeParser::fromTimestamp($data['date'], $dateTimeZone) : null,
            holdBonuses: isset($data['hold_bonuses']) ? array_map(
                fn (array $b): HoldBonusDto => HoldBonusDto::fromArray($b, $currency),
                $data['hold_bonuses']
            ) : null,
            holdCertificates: isset($data['hold_certificates']) ? array_map(
                fn (array $b): HoldCertificateDto => HoldCertificateDto::fromArray($b, $currency),
                $data['hold_certificates']
            ) : null,
            holdPromoId: $data['hold_promo_id'] ?? null,
            payment: isset($data['payment']) ? array_map(
                fn (array $p): PaymentDto => PaymentDto::fromArray($p, $currency),
                $data['payment']
            ) : null,
            promo: $data['promo'] ?? null,
            saleChannelId: $data['sale_channel_id'] ?? null,
            id: $data['id'] ?? null,
            paidInAccounting: $data['paid_in_accounting'] ?? false,
            orderStatus: isset($data['status']) ? OrderStatus::from($data['status']) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'bonus_discount' => $this->bonusDiscount instanceof Money ? MoneyParser::toString($this->bonusDiscount) : 0,
            'card_id' => $this->cardId,
            'certificate_payment' => $this->certificatePayment !== null && $this->certificatePayment !== [] ? array_map(
                fn (CertificatePaymentDto $certificatePaymentDto): array => $certificatePaymentDto->toArray(),
                $this->certificatePayment
            ) : null,
            'date' => $this->date instanceof DateTimeImmutable ? DateTimeParser::toTimestamp($this->date) : null,
            'hold_bonuses' => $this->holdBonuses !== null && $this->holdBonuses !== [] ? array_map(
                fn (HoldBonusDto $holdBonusDto): array => $holdBonusDto->toArray(),
                $this->holdBonuses
            ) : null,
            'hold_certificates' => $this->holdCertificates !== null && $this->holdCertificates !== [] ? array_map(
                fn (HoldCertificateDto $holdCertificateDto): array => $holdCertificateDto->toArray(),
                $this->holdCertificates
            ) : null,
            'hold_promo_id' => $this->holdPromoId,
            'doc_number' => $this->docNumber,
            'items' => array_map(
                fn (SaleItemDto $saleItemDto): array => $saleItemDto->toArray(),
                $this->items
            ),
            'local_date' => $this->localDate?->format(DATE_ATOM),
            'payment' => $this->payment !== null && $this->payment !== [] ? array_map(
                fn (PaymentDto $paymentDto): array => $paymentDto->toArray(),
                $this->payment
            ) : null,
            'promo' => $this->promo,
            'sale_channel_id' => $this->saleChannelId,
            'shop_id' => $this->shopId,
            'id' => $this->id,
            'paid_in_accounting' => $this->paidInAccounting,
            'status' => $this->orderStatus?->value,
        ];
    }
}
