<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Articles\DTO\Property;

/**
 * Class ArticleProperty
 *
 * @package Rarus\BonusServer\Articles\DTO\Property
 */
class ArticleProperty
{
    /**
     * @var ArticlePropertyId
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    /**
     * ArticleProperty constructor.
     *
     * @param ArticlePropertyId $id
     * @param string            $name
     * @param string            $value
     */
    public function __construct(ArticlePropertyId $id, string $name, string $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * @return ArticlePropertyId
     */
    public function getPropertyId(): ArticlePropertyId
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


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

}
