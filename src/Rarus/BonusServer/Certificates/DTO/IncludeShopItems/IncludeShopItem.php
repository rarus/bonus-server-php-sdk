<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO\IncludeShopItems;


use Rarus\BonusServer\Shops\DTO\ShopId;

/**
 * Class IncludeShopItem
 *
 * @package Rarus\BonusServer\Certificates\DTO\IncludeShopItems
 */
class IncludeShopItem
{
    /**
     * @var ShopId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * IncludeShopItem constructor.
     *
     * @param ShopId $id
     * @param string $name
     */
    public function __construct(ShopId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return ShopId
     */
    public function getId(): ShopId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

