<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Articles\DTO;

final class ArticleSegmentFilterProperty
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $operator;

    /**
     * @param string|null $id
     * @param string $value
     * @param string $operator
     */
    public function __construct(?string $id, string $value, string $operator)
    {
        $this->id = $id;
        $this->value = $value;
        $this->operator = $operator;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

}
