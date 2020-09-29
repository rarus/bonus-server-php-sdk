<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Cards\DTO;

/**
 * Class UniqueField
 *
 * @package Rarus\BonusServer\Cards\DTO
 */
class UniqueField
{
    private const ID = 'id';
    private const CODE = 'code';
    private const BARCODE = 'barcode';

    /**
     * @var string
     */
    private $code;

    private function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function setId(): UniqueField
    {
        return new self(self::ID);
    }

    public static function setCode(): UniqueField
    {
        return new self(self::CODE);
    }

    public static function setBareCode(): UniqueField
    {
        return new self(self::BARCODE);
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
