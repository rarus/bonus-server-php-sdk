<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Transport\DTO;

final readonly class ErrorResponse
{
    public function __construct(
        public string $message,
        public string $details,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): ErrorResponse
    {
        $errorDetailsString = '';
        if (! empty($data['error'])) {
            $errorDetailsString = implode(
                ', ',
                array_map(
                    fn ($key, $value): string => $key.': '.(is_scalar($value) ? $value : json_encode($value)),
                    array_keys($data['error']),
                    array_values($data['error'])
                )
            );
        }

        return new ErrorResponse($data['message'], $errorDetailsString);
    }
}
