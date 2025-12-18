<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Certificates\DTO;

use DateTimeImmutable;
use DateTimeZone;
use Money\Currency;
use Money\Money;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;
use Rarus\LMS\SDK\Utils\MoneyParser;

final class CertificateStatusDto
{
    public function __construct(
        public ?Money $balance = null,
        public ?DateTimeImmutable $date = null,
        public ?Money $holded = null,
        public ?CertificateStatusType $status = CertificateStatusType::Active,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ApiClientException
     */
    public static function fromArray(array $data, Currency $currency, DateTimeZone $dateTimeZone): self
    {
        return new self(
            isset($data['balance']) ? MoneyParser::parse($data['balance'], $currency) : null,
            isset($data['date']) ? DateTimeParser::fromTimestamp($data['date'], $dateTimeZone) : null,
            isset($data['holded']) ? MoneyParser::parse($data['holded'], $currency) : null,
            isset($data['status']) ? CertificateStatusType::from($data['status']) : CertificateStatusType::Active,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'balance' => $this->balance instanceof Money ? MoneyParser::toString($this->balance) : null,
            'date' => $this->date?->format(DATE_ATOM),
            'holded' => $this->holded instanceof Money ? MoneyParser::toString($this->holded) : null,
            'status' => $this->status?->value,
        ];
    }
}
