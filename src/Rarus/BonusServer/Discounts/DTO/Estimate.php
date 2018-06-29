<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Discounts\DTO;

use Rarus\BonusServer\Discounts\DTO\DiscountItems\DiscountItemCollection;
use Rarus\BonusServer\Discounts\DTO\DocumentItems\DocumentItemCollection;

/**
 * Class Estimate
 *
 * @package Rarus\BonusServer\Discounts\DTO
 */
final class Estimate
{
    /**
     * @var DocumentItemCollection
     */
    private $documentItems;
    /**
     * @var DiscountItemCollection
     */
    private $discountItems;

    /**
     * @return DiscountItemCollection
     */
    public function getDiscountItems(): DiscountItemCollection
    {
        return $this->discountItems;
    }

    /**
     * @param DiscountItemCollection $discountItems
     *
     * @return Estimate
     */
    public function setDiscountItems(DiscountItemCollection $discountItems): Estimate
    {
        $this->discountItems = $discountItems;

        return $this;
    }

    /**
     * @return DocumentItemCollection
     */
    public function getDocumentItems(): DocumentItemCollection
    {
        return $this->documentItems;
    }

    /**
     * @param DocumentItemCollection $documentItems
     *
     * @return Estimate
     */
    public function setDocumentItems(DocumentItemCollection $documentItems): Estimate
    {
        $this->documentItems = $documentItems;

        return $this;
    }
}