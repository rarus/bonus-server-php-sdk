<?php

declare(strict_types=1);

use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Money\Currency;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\RarusLMS;

/**
 * Фабрика, создающая подключение к БС для прохождения интеграционных тестов
 *
 * Class TestEnvironmentManager
 */
class TestEnvironmentManager
{
    public const DEFAULT_TIMEZONE = 'Europe/Moscow';

    /**
     * @throws Exception|\Psr\SimpleCache\InvalidArgumentException
     */
    public static function getInstance(): Client
    {
        //        return RarusLMS::client(
        //            $_ENV['RARUS_BONUS_API_URL'],
        //            $_ENV['RARUS_BONUS_REGISTER_TOKEN']
        //        );

        $logger = self::getMonologInstance();

        $guzzleHandlerStack = HandlerStack::create();
        $guzzleHandlerStack->push(
            Middleware::log(
                $logger,
                new MessageFormatter(MessageFormatter::DEBUG)
            )
        );

        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => $_ENV['RARUS_BONUS_API_URL'],
            'headers' => [
                'Cache-Control' => 'no-cache',
                'Content-type' => 'application/json; charset=utf-8',
            ],
            'handler' => $guzzleHandlerStack,
        ]);

        return RarusLMS::factory()
            ->setApiUrl($_ENV['RARUS_BONUS_API_URL'])
            ->setApiKey($_ENV['RARUS_BONUS_REGISTER_TOKEN'])
            ->setHttpClient($httpClient)
            ->setLogger($logger)
            ->setCurrency(self::getDefaultCurrency())
            ->setDateTimeZone(self::getDefaultTimezone())
            ->create();
    }

    /**
     * @throws Exception
     */
    public static function getMonologInstance(): LoggerInterface
    {
        static $log;

        if ($log === null) {
            $log = new Logger('rarus-bonus-service');
            $log->pushProcessor(new MemoryUsageProcessor);
            $log->pushProcessor(new MemoryPeakUsageProcessor);
            $log->pushProcessor(new IntrospectionProcessor);
            $log->pushProcessor(new UidProcessor);

            $log->pushHandler(
                new StreamHandler($_ENV['INTEGRATION_TEST_LOG_FILE'], $_ENV['INTEGRATION_TEST_LOG_LEVEL'])
            );
        }

        return $log;
    }

    public static function getDefaultCurrency(): Currency
    {
        return new Currency('RUB');
    }

    public static function getDefaultTimezone(): DateTimeZone
    {
        return new DateTimeZone(self::DEFAULT_TIMEZONE);
    }
}
