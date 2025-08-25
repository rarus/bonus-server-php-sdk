<?php

declare(strict_types=1);

namespace RarusBonus\Util;

use DateTime;
use DateTimeZone;
use RarusBonus\Exceptions\ApiClientException;

/**
 * Class DateTimeParser
 */
class DateTimeParser
{
    /**
     * @var int
     */
    private const MIN_TIMESTAMP_LENGTH = 11;

    /**
     * Парсим время в виде timestamp + milliseconds
     *
     *
     * @throws ApiClientException
     */
    public static function fromTimestamp(string|int $timestampStr, DateTimeZone $dateTimeZone): \DateTimeImmutable
    {
        if (\strlen((string) $timestampStr) < self::MIN_TIMESTAMP_LENGTH) {
            throw new ApiClientException(
                sprintf(
                    'неизвестный формат времени в ответе сервера [%s], ожидали %s или больше символов, получили %s',
                    $timestampStr,
                    self::MIN_TIMESTAMP_LENGTH,
                    \strlen((string) $timestampStr)
                ),
                0,
                null
            );
        }

        $seconds = (int) substr((string) $timestampStr, 0, -3);
        $milliseconds = (int) substr((string) $timestampStr, -3);

        $timestampFloat = $seconds + $milliseconds / 1000;

        try {
            $dateTime = (new \DateTimeImmutable('@'.$timestampFloat))
                ->setTimezone($dateTimeZone);
        } catch (\Exception $e) {
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
