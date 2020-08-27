<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Document;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Transactions\DTO\Document
 */
class Fabric
{
    /**
     * @param string $id
     * @param int    $externalId
     *
     * @return Document
     */
    public static function createNewInstance(string $id, int $externalId): Document
    {
        $document = new Document();

        $document
            ->setId($id)
            ->setExternalId($externalId);

        return $document;
    }
}
