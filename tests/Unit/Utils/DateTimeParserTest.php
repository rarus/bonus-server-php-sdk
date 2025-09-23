<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Tests\Unit\Utils;

use PHPUnit\Framework\TestCase;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Utils\DateTimeParser;

class DateTimeParserTest extends TestCase
{
    private \DateTimeZone $tz;

    /**
     * @throws ApiClientException
     */
    public function testFromTimestamp()
    {
        $dt = DateTimeParser::fromTimestamp(0, $this->tz);
        $this->assertSame('1970-01-01 03:00:00.000000', $dt->format('Y-m-d H:i:s.u'));
    }

    public function testNegativeTimestamp(): void
    {
        $dt = DateTimeParser::fromTimestamp(-275249147000, $this->tz);
        $this->assertSame('1961-04-12 08:54:13.000000', $dt->format('Y-m-d H:i:s.u'));
    }

    public function testTimestampWithMilliseconds(): void
    {
        $dt = DateTimeParser::fromTimestamp(1758614701883, $this->tz);
        $this->assertSame('2025-09-23 11:05:01.883000', $dt->format('Y-m-d H:i:s.u'));
    }

    public function testTimestampExactSecond(): void
    {
        $dt = DateTimeParser::fromTimestamp(1753995600000, $this->tz);
        $this->assertSame('2025-08-01 00:00:00.000000', $dt->format('Y-m-d H:i:s.u'));
    }

    public function testTimestampWithRandomMillis(): void
    {
        $dt = DateTimeParser::fromTimestamp(1758607419378, $this->tz);
        $this->assertSame('2025-09-23 09:03:39.378000', $dt->format('Y-m-d H:i:s.u'));
    }


    protected function setUp(): void
    {
        $this->tz = new \DateTimeZone(\TestEnvironmentManager::DEFAULT_TIMEZONE);
    }
}
