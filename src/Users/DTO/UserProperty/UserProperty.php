<?php

declare(strict_types=1);

namespace RarusBonus\Users\DTO\UserProperty;

use DateTimeInterface;
use RarusBonus\Exceptions\ApiClientException;

final class UserProperty
{
    public function __construct(
        public string $name,
        public int $id,
        public UserPropertyType $type,
        public string|int|bool|\DateTimeImmutable $value,
    ) {}

    /**
     * Creates an instance of the class from an associative array of data.
     *
     * @param  array<string, mixed>  $data  The associative array containing the necessary keys ('id', 'name', 'type', 'value').
     *                                      - 'id': An integer representing the unique identifier.
     *                                      - 'name': A string representing the name.
     *                                      - 'type': A string representing the type, which must correspond to a valid UserPropertyType.
     *                                      - 'value': The value corresponding to the type, which will be adjusted based on the type.
     * @return self An instance of the class populated with the provided data.
     *
     * @throws ApiClientException If required keys are missing in the array or if the data contains invalid values.
     */
    public static function createFromArray(array $data): self
    {
        if (! isset($data['id'], $data['name'], $data['type'], $data['value'])) {
            throw new ApiClientException('Invalid addition field data');
        }

        $type = UserPropertyType::from($data['type']);
        $rawValue = $data['value'];

        switch ($type) {
            case UserPropertyType::Int:
                $value = (int) $rawValue;
                break;

            case UserPropertyType::Bool:
                $value = filter_var($rawValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($value === null) {
                    throw new ApiClientException('Invalid bool value: '.var_export($rawValue, true));
                }
                break;

            case UserPropertyType::DateTime:
                try {
                    $value = new \DateTimeImmutable((string) $rawValue);
                } catch (\Exception $e) {
                    throw new ApiClientException('Invalid datetime value: '.var_export($rawValue, true));
                }
                break;

            default:
                $value = (string) $rawValue;
                break;
        }

        return new self(
            (string) $data['name'],
            (int) $data['id'],
            $type,
            $value
        );
    }

    /**
     * Converts the current object into an associative array representation.
     *
     * @return array<string, mixed> An associative array containing the following keys:
     *                              - 'name': The name of the property as a string.
     *                              - 'id': The unique identifier of the property as an integer.
     *                              - 'type': The string representation of the property's type.
     *                              - 'value': The property's value adjusted based on its type:
     *                              * Boolean values are converted to 'true' or 'false' strings.
     *                              * DateTime values are formatted as an ISO 8601 string (ATOM format).
     *                              * Integer values are cast to integers.
     *                              * Other types are cast to strings.
     */
    public function toArray(): array
    {
        $value = $this->value;

        switch ($this->type) {
            case UserPropertyType::Bool:
                $value = $value ? 'true' : 'false';
                break;

            case UserPropertyType::DateTime:
                if ($value instanceof DateTimeInterface) {
                    $value = $value->format(DATE_ATOM);
                } else {
                    $value = (string) $value;
                }
                break;

            case UserPropertyType::Int:
                // @phpstan-ignore-next-line
                $value = (int) $value;
                break;

            default:
                // @phpstan-ignore-next-line
                $value = (string) $value;
                break;
        }

        return [
            'name' => $this->name,
            'id' => $this->id,
            'type' => $this->type->value,
            'value' => $value,
        ];
    }
}
