<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Type;

final class Type
{
    /**
     * @var string
     */
    private $code;

    /**
     * Type constructor.
     *
     * @param string $typeCode
     */
    public function __construct(string $typeCode)
    {
        $this->code = $typeCode;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}