<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\AdditionalField;

final class Fabric
{
    public static function initAdditionFieldFromResponse(array $arAdditionField): AdditionalField
    {
        if (!isset($arAdditionField['id'], $arAdditionField['name'], $arAdditionField['type'], $arAdditionField['value'])) {
            throw new \InvalidArgumentException('Invalid addition field data');
        }

        return new AdditionalField(
            new AdditionalFieldId($arAdditionField['id']),
            (string)$arAdditionField['name'],
            (int)$arAdditionField['type'],
            (string)$arAdditionField['value']
        );
    }
}
