<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Cards\DTO\Barcode;

/**
 * Class Barcode
 *
 * @package Rarus\BonusServer\Cards\DTO\Barcode
 */
final class Barcode
{
    /**
     * @var string
     */
    private $code;

    /**
     * Barcode constructor.
     *
     * @param string $barcode
     */
    public function __construct(string $barcode)
    {
        $this->code = $barcode;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
