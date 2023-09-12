<?php

declare(strict_types=1);

namespace Rarus\BonusServer\DiscountConditions\DTO;

use InvalidArgumentException;
use Rarus\BonusServer\Util\Utils;
use TypeError;

final class Fabric
{
    public static function initDiscountConditionFromServerResponse(array $data): DiscountCondition
    {
        $dto = new DiscountCondition();

        foreach ($data as $key => $value) {
            $setterMethod = 'set' . ucfirst(Utils::snakeToCamel($key));

            if (method_exists($dto, $setterMethod)) {
                try {
                    $dto->$setterMethod($value);
                } catch (TypeError $e) {
                    throw new InvalidArgumentException("Invalid data type for property '$key'");
                }
            }
        }

        return $dto;
    }
}
