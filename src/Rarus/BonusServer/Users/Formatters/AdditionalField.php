<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\Formatters;

final class AdditionalField
{
    public static function toArray(\Rarus\BonusServer\Users\DTO\AdditionalField\AdditionalField $additionalField): array
    {
        return [
            'id' => $additionalField->getId()->getId(),
            'name' => $additionalField->getName(),
            'type' => $additionalField->getType(),
            'value' => $additionalField->getValue(),
        ];
    }
}
