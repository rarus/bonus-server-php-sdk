<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Document;

/**
 * Class DocumentId
 *
 * @package Rarus\BonusServer\Transactions\DTO\Document
 */
class DocumentId
{
    /**
     * @var string
     */
    private $id;

    /**
     * DocumentId constructor.
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