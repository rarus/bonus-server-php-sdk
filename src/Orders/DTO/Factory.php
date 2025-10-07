<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Orders\DTO;

use DateTimeImmutable;
use Money\Money;
use Rarus\LMS\SDK\Documents\DTO\CertificatePaymentDto;
use Rarus\LMS\SDK\Documents\DTO\HoldBonusDto;
use Rarus\LMS\SDK\Documents\DTO\HoldCertificateDto;
use Rarus\LMS\SDK\Documents\DTO\PaymentDto;
use Rarus\LMS\SDK\Documents\DTO\SaleItemDto;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\RuntimeException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;
use TypeError;

/**
 * @method self withOrderNumber(string $orderNumber)
 * @method self withDocNumber(string $docNumber)
 * @method self withRegisterId(string $registerId)
 * @method self withShopId(string $shopId)
 * @method self withItems(array<SaleItemDto> $items)
 * @method self withLocalDate(?DateTimeImmutable $localDate)
 * @method self withBonusDiscount(?Money $bonusDiscount)
 * @method self withCardId(?int $cardId)
 * @method self withCertificatePayment(?array<CertificatePaymentDto> $certificatePayment)
 * @method self withDate(?DateTimeImmutable $date)
 * @method self withHoldBonuses(?array<HoldBonusDto> $holdBonuses)
 * @method self withHoldCertificates(?array<HoldCertificateDto> $holdCertificates)
 * @method self withHoldPromoId(?int $holdPromoId)
 * @method self withPayment(?array<PaymentDto> $payment)
 * @method self withPromo(?string $promo)
 * @method self withSaleChannelId(?string $saleChannelId)
 * @method self withPurchaseId(?string $purchaseId)
 * @method self withId(?int $id)
 * @method self withOrderStatus(?OrderStatus $orderStatus)
 *
 * @see OrderDto
 */
final class Factory
{
    /** @var array<string> */
    private array $properties = [];

    /**
     * Creates a Factory instance from an existing UserDto
     */
    public static function fromDto(OrderDto $orderDto): self
    {
        $factory = self::create();
        $reflectionClass = new ReflectionClass($orderDto);
        foreach ($reflectionClass->getProperties() as $property) {
            $name = $property->getName();
            $factory->properties[$name] = $property->getValue($orderDto);
        }

        return $factory;
    }

    public static function create(): self
    {
        return new self;
    }

    /**
     * @param array<mixed> $arguments
     *
     * @throws InvalidArgumentException
     */
    public function __call(string $name, array $arguments): self
    {
        if (!str_starts_with($name, 'with')) {
            throw new InvalidArgumentException(sprintf('Method %s does not exist', $name));
        }

        $prop = lcfirst(substr($name, 4));
        $value = $arguments[0] ?? null;

        $new = clone $this;
        $new->properties[$prop] = $value;

        return $new;
    }

    /**
     * @throws RuntimeException
     */
    public function build(): OrderDto
    {
        $reflectionClass = new ReflectionClass(OrderDto::class);
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            throw new RuntimeException('OrderDto has no constructor');
        }

        $args = [];
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (!array_key_exists($name, $this->properties)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $args[$name] = $parameter->getDefaultValue();
                } else {
                    throw new RuntimeException(sprintf("Missing value for required property '%s'", $name));
                }
            } else {
                $value = $this->properties[$name];
                $type = $parameter->getType();
                if ($type && !$this->validateType($value, $type)) {
                    throw new TypeError(sprintf("Invalid type for property '%s'", $name));
                }

                $args[$name] = $value;
            }
        }

        return new OrderDto(...$args);
    }

    private function validateType(mixed $value, ReflectionType $reflectionType): bool
    {
        if ($reflectionType instanceof ReflectionNamedType) {
            $typeName = $reflectionType->getName();
            if ($value === null && $reflectionType->allowsNull()) {
                return true;
            }

            return match ($typeName) {
                'int' => is_int($value),
                'float' => is_float($value),
                'string' => is_string($value),
                'bool' => is_bool($value),
                'array' => is_array($value),
                default => $value instanceof $typeName
            };
        }

        return true;
    }
}
