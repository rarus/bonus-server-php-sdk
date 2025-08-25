<?php

declare(strict_types=1);

namespace RarusBonus\Exceptions;

use RarusBonus\Transport\DTO\ErrorResponse;
use Throwable;

/**
 * Class ApiClientException
 */
class ApiClientException extends BaseException
{
    protected ?ErrorResponse $response;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $throwable = null,
        ?ErrorResponse $errorResponse = null
    ) {
        $this->response = $errorResponse;
        parent::__construct($message, $code, $throwable);
    }

    public function getResponse(): ?ErrorResponse
    {
        return $this->response;
    }
}
