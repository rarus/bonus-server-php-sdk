<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Users\DTO;

use Rarus\LMS\SDK\Cards\DTO\CardDto;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Exceptions\RuntimeException;
use Rarus\LMS\SDK\Users\DTO\UserProperty\UserProperty;

/**
 * The Factory class provides an interface for creating and building objects
 * through a fluent API. It allows setting properties dynamically and validating
 * types at runtime. This class is particularly useful for constructing immutable
 * objects with multiple optional or required parameters.
 *
 * @method self withName(string $name)
 * @method self withPhone(string $phone)
 * @method self withShopId(?int $shopId)
 * @method self withId(?int $id)
 * @method self withBirthday(?\DateTimeImmutable $birthday)
 * @method self withGender(?Gender $gender)
 * @method self withEmail(?string $email)
 * @method self withChannel(?string $channel)
 * @method self withPersonalDataAccepted(?bool $personalDataAccepted)
 * @method self withPersonalDataAcceptedDate(?\DateTimeImmutable $personalDataAcceptedDate)
 * @method self withReceiveNewslettersAccepted(?bool $receiveNewslettersAccepted)
 * @method self withReferrer(?string $referrer)
 * @method self withTimezone(?\DateTimeZone $timezone)
 * @method self withState(?UserStatus $state)
 * @method self withDateConfirmed(?\DateTimeImmutable $dateConfirmed)
 * @method self withBlocked(?bool $blocked)
 * @method self withDateBlocked(?\DateTimeImmutable $dateBlocked)
 * @method self withCards(?array<CardDto> $cards)
 * @method self withDateState(?\DateTimeImmutable $dateState)
 * @method self withExternalId(?string $externalId)
 * @method self withLogin(?string $login)
 * @method self withPassword(?string $password)
 * @method self withProperties(?array<UserProperty> $properties)
 * @method self withDefaultCardId(?int $defaultCardId)
 *
 * @see UserDto
 */
final class Factory
{
    /** @var array<string> */
    private array $properties = [];

    /**
     * Creates a Factory instance from an existing UserDto
     */
    public static function fromDto(UserDto $dto): self
    {
        $factory = self::create();
        $reflection = new \ReflectionClass($dto);
        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();
            $factory->properties[$name] = $property->getValue($dto);
        }

        return $factory;
    }

    public static function create(): self
    {
        return new self;
    }

    /**
     * @param  array<mixed>  $arguments
     *
     * @throws InvalidArgumentException
     */
    public function __call(string $name, array $arguments): self
    {
        if (! str_starts_with($name, 'with')) {
            throw new InvalidArgumentException("Method $name does not exist");
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
    public function build(): UserDto
    {
        $reflection = new \ReflectionClass(UserDto::class);
        $constructor = $reflection->getConstructor();
        if (! $constructor) {
            throw new RuntimeException('UserDto has no constructor');
        }

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();

            if (! array_key_exists($name, $this->properties)) {
                if ($param->isDefaultValueAvailable()) {
                    $args[$name] = $param->getDefaultValue();
                } else {
                    throw new RuntimeException("Missing value for required property '$name'");
                }
            } else {
                $value = $this->properties[$name];
                $type = $param->getType();
                if ($type && ! $this->validateType($value, $type)) {
                    throw new \TypeError("Invalid type for property '$name'");
                }
                $args[$name] = $value;
            }
        }

        return new UserDto(...$args);
    }

    private function validateType(mixed $value, \ReflectionType $type): bool
    {
        if ($type instanceof \ReflectionNamedType) {
            $typeName = $type->getName();
            if ($value === null && $type->allowsNull()) {
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
