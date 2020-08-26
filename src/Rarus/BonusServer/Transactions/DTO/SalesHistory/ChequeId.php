<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\SalesHistory;

/**
 * Class ChequeId
 *
 * @package Rarus\BonusServer\Transactions\DTO\SalesHistory
 */
class ChequeId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ChequeId constructor.
     *
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
