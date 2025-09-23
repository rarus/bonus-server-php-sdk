<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Utils;

use DateTime;
use DateTimeZone;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\RuntimeException;

/**
 * Class DateTimeParser
 */
class DateTimeParser
{
    /**
     * Парсим время в виде timestamp + milliseconds
     *
     *
     * @throws ApiClientException
     */
    public static function fromTimestamp(string|int $timestampStr, DateTimeZone $dateTimeZone): \DateTimeImmutable
    {
        $timestampStr = (string)$timestampStr;

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
            $dateTime = \DateTimeImmutable::createFromFormat('U.u', $formatted)->setTimezone($dateTimeZone);
            if ($dateTime === false) {
                throw new RuntimeException('createFromFormat вернул false');
            }
        } catch (\Throwable $e) {
            throw new ApiClientException(
                sprintf('ошибка при разборе поля время в ответе сервера [%s]', $timestampStr),
                0,
                $e
            );
        }

        return $dateTime;
    }

    /**
     * Сервер принимает значения таймстемпа с учётом миллисекунд
     */
    public static function toTimestamp(DateTime|\DateTimeImmutable $dateTime): int
    {
        return $dateTime->getTimestamp() * 1000;
    }

    /**
     * @throws ApiClientException
     */
    public static function timeZoneFromString(?string $tz): ?\DateTimeZone
    {
        if ($tz === null) {
            return null;
        }

        try {
            return new \DateTimeZone($tz);
        } catch (\Exception $e) {
            throw new ApiClientException("Invalid timezone: {$tz}", 0, $e);
        }
    }
}
