<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\AdditionalField;

final class AdditionalField
{
    /**
     * @var AdditionalFieldId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * 0. Строка(0), 1. Целое число(1), 2. Дата и время(2), 3. Булево(3), 4. Дробное число(4), 5. Дата(5), 6. Время(6)
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    public function __construct(AdditionalFieldId $id, string $name, int $type, string $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return AdditionalFieldId
     */
    public function getId(): AdditionalFieldId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
