<?php

namespace Rarus\BonusServer\Promotions\DTO;

final class PromotionId
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @param string|null $id
     */
    public function __construct(?string $id = null)
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
