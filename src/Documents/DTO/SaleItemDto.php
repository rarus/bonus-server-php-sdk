<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Documents\DTO;

use DateTimeZone;
use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class SaleItemDto
{
    /**
     * @param  array<CertificateDto>|null  $certificates
     * @param  array<DiscountDto>|null  $discounts
     */
    public function __construct(
        public string $productId,
        public string $productName,
        public Money $price,
        public int $quantity = 0,
        public ?string $barcode = null,
        public ?Money $bonusDiscount = null,
        public ?array $certificates = null,
        public ?Money $cost = null,
        public ?Money $discountBase = null,
        public ?array $discounts = null,
        public ?Money $externalDiscount = null,
        public ?string $featureId = null,
        public ?string $featureName = null,
        public ?bool $gift = false,
        public ?int $lineNumber = null,
        public ?Money $specPrice = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            productId: $data['product_id'],
            productName: $data['product_name'],
            price: MoneyParser::parse($data['price'], $currency),
            quantity: (int) $data['quantity'],
            barcode: $data['barcode'] ?? null,
            bonusDiscount: $data['bonus_discount'] ? MoneyParser::parse($data['bonus_discount'], $currency) : null,
            certificates: $data['certificates'] ? array_map(
                fn (array $c): CertificateDto => CertificateDto::fromArray($c, $currency),
                $data['certificates']
            ) : null,
            cost: $data['cost'] ? MoneyParser::parse($data['cost'], $currency) : null,
            discountBase: $data['discountBase'] ? MoneyParser::parse($data['discountBase'], $currency) : null,
            discounts: $data['discounts'] ? array_map(
                /**
                 * @throws ApiClientException
                 */ fn (array $d): DiscountDto => DiscountDto::fromArray($d, $currency, $dateTimeZone),
                $data['discounts']
            ) : null,
            externalDiscount: $data['externalDiscount'] ? MoneyParser::parse(
                $data['externalDiscount'],
                $currency
            ) : null,
            featureId: $data['featureId'] ?? null,
            featureName: $data['featureName'] ?? null,
            gift: $data['gift'] ?? false,
            lineNumber: $data['lineNumber'] ?? null,
            specPrice: $data['spec_price'] ? MoneyParser::parse($data['spec_price'], $currency) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'price' => MoneyParser::toString($this->price),
            'quantity' => $this->quantity,
            'barcode' => $this->barcode,
            'bonus_discount' => $this->bonusDiscount instanceof Money ? MoneyParser::toString($this->bonusDiscount) : null,
            'certificates' => $this->certificates !== null && $this->certificates !== [] ? array_map(
                fn (CertificateDto $certificateDto): array => $certificateDto->toArray(),
                $this->certificates
            ) : null,
            'cost' => $this->cost instanceof Money ? MoneyParser::toString($this->cost) : null,
            'discount_base' => $this->discountBase instanceof Money ? MoneyParser::toString($this->discountBase) : null,
            'discounts' => $this->discounts !== null && $this->discounts !== [] ? array_map(
                fn (DiscountDto $discountDto): array => $discountDto->toArray(),
                $this->discounts
            ) : null,
            'external_discount' => $this->externalDiscount instanceof Money ? MoneyParser::toString($this->externalDiscount) : null,
            'feature_id' => $this->featureId,
            'feature_name' => $this->featureName,
            'gift' => $this->gift,
            'line_number' => $this->lineNumber,
            'spec_price' => $this->specPrice instanceof Money ? MoneyParser::toString($this->specPrice) : null,
        ];
    }
}
