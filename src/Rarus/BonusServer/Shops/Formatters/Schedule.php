<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Shops\Formatters;

use \Rarus\BonusServer\Shops;

/**
 * Class Schedule
 *
 * @package Rarus\BonusServer\Shops\Formatters
 */
class Schedule
{
    /**
     * @param Shops\DTO\Schedule $schedule
     *
     * @return array
     */
    public static function toArray(Shops\DTO\Schedule $schedule): array
    {
        return [
            'day_start' => $schedule->getDayStart(),
            'day_end' => $schedule->getDayEnd(),
            'time_start' => $schedule->getTimeStart(),
            'time_end' => $schedule->getTimeEnd(),
            'is_open' => $schedule->isOpen() ? 'true' : 'false',
        ];
    }
}