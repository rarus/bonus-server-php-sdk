<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Util;

use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class DateTimeParser
 *
 * @package Rarus\BonusServer\Util
 */
class DateTimeParser
{
    /**
     * парсим время в виде timestamp + milliseconds
     *
     * @param string $timestampStr
     * @param \DateTimeZone $dateTimeZone
     *
     * @return \DateTime
     * @throws ApiClientException
     */
    public static function parseTimestampFromServerResponse(
        string $timestampStr,
        \DateTimeZone $dateTimeZone
    ): \DateTime {
        if (!is_numeric($timestampStr)) {
            throw new ApiClientException(
                sprintf('некорректный формат времени в ответе сервера [%s]', $timestampStr)
            );
        }

        $milliseconds = (int)$timestampStr;
        $seconds = intdiv($milliseconds, 1000);
        $microseconds = ($milliseconds % 1000) * 1000;

        $formatted = sprintf('%d.%06d', $seconds, $microseconds);

        try {
            $dateTime = \DateTime::createFromFormat('U.u', $formatted);
            if ($dateTime === false) {
                throw new \RuntimeException('createFromFormat вернул false');
            }

            $dateTime = $dateTime->setTimezone($dateTimeZone);
        } catch (\Throwable $throwable) {
            throw new ApiClientException(
                sprintf('ошибка при разборе поля время в ответе сервера [%s]', $timestampStr),
                0,
                $throwable
            );
        }

        return $dateTime;
    }

    /**
     * сервер принимает значения таймстемпа с учётом микросекунд
     *
     * @param \DateTime $dateTime
     *
     * @return int
     */
    public static function convertToServerFormatTimestamp(\DateTime $dateTime): int
    {
        return $dateTime->getTimestamp() * 1000;
    }
}
