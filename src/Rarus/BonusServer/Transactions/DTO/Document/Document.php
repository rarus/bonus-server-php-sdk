<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Document;

/**
 * информация по документу из внешней системы
 *
 * Class Document
 *
 * @package Rarus\BonusServer\Transactions\DTO\Document
 */
final class Document
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var int
     */
    private $externalId;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Document
     */
    public function setId(string $id): Document
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getExternalId(): int
    {
        return $this->externalId;
    }

    /**
     * @param int $externalId
     *
     * @return Document
     */
    public function setExternalId(int $externalId): Document
    {
        $this->externalId = $externalId;

        return $this;
    }
}
