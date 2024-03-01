<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use Rarus\BonusServer\Cards\DTO\CardId;

final class Fabric
{
    public static function initHoldFromServerResponse(array $data): Hold
    {
        return new Hold(
            new HoldId($data['id']),
            new CardId($data['card_id']),
            $data['card_name'] ?? null,
            (float)$data['sum'],
            $data['comment'] ?? null,
            $data['add_date'] ? (new \DateTime())->setTimestamp($data['add_date']) : null,
            $data['date_to'] ? (new \DateTime())->setTimestamp($data['date_to']) : null
        );
    }
}
