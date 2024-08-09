<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Util\DateTimeParser;

final class Fabric
{
    /**
     * @throws ApiClientException
     */
    public static function initHoldFromServerResponse(array $data, \DateTimeZone $dateTimeZone): Hold
    {
        $dateAdd = (DateTimeParser::parseTimestampFromServerResponse((string)$data['add_date'], $dateTimeZone));
        $dateTo = (DateTimeParser::parseTimestampFromServerResponse((string)$data['date_to'], $dateTimeZone));

        return new Hold(
            new HoldId($data['id']),
            new CardId($data['card_id']),
            $data['card_name'] ?? null,
            (float)$data['sum'],
            $data['comment'] ?? null,
            $dateAdd,
            $dateTo
        );
    }
}
