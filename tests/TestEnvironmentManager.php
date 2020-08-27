<?php

declare(strict_types=1);

use Monolog\Logger;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;

/**
 * фабрика создающая подключение к БС для прохождения интеграционных тестов
 *
 * Class TestEnvironmentManager
 */
class TestEnvironmentManager
{
    /**
     * @var string
     */
    private const URL = 'https://demo.bonus.rarus-online.com:88';
    /**
     * @var string
     */
    private const LOGIN = 'mesm';
    /**
     * @var string
     */
    private const PASSWORD = '3a9e090168bf592bcc35990bcc9fab9aff090004';
    /**
     * @var string
     */
    private const LOG_FILE = 'rarus-bonus-service-integration-tests.log';
    /**
     * @var string
     */
    private const DEFAULT_TIMEZONE = 'Europe/Moscow';

    /**
     * @return \Rarus\BonusServer\ApiClient
     * @throws Exception
     */
    public static function getInstanceForRoleOrganization(): \Rarus\BonusServer\ApiClient
    {
        $credentials = Rarus\BonusServer\Auth\Fabric::createCredentialsForRoleOrganization(self::LOGIN, self::PASSWORD);

        $log = self::getMonologInstance();

        $guzzleHandlerStack = HandlerStack::create();
        $guzzleHandlerStack->push(
            Middleware::log(
                $log,
                new MessageFormatter(MessageFormatter::SHORT)
            )
        );
        $httpClient = new \GuzzleHttp\Client();

        $apiClient = new Rarus\BonusServer\ApiClient(self::URL, new \GuzzleHttp\Client(), $log);
        $apiClient
            ->setTimezone(new \DateTimeZone(self::DEFAULT_TIMEZONE))
            ->setGuzzleHandlerStack($guzzleHandlerStack);

        $newAuthToken = $apiClient->getNewAuthToken($credentials);
        $apiClient->setAuthToken($newAuthToken);

        return $apiClient;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     * @throws Exception
     */
    public static function getMonologInstance(): \Psr\Log\LoggerInterface
    {
        static $log;

        if (null === $log) {
            $log = new Logger('rarus-bonus-service');
            $log->pushProcessor(new MemoryUsageProcessor());
            $log->pushProcessor(new MemoryUsageProcessor());
            $log->pushProcessor(new MemoryPeakUsageProcessor());
            $log->pushProcessor(new IntrospectionProcessor());
            $log->pushProcessor(new UidProcessor());

            $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/logs/' . self::LOG_FILE, Logger::DEBUG));
            $log->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', Logger::WARNING));
        }

        return $log;
    }

    /**
     * @return \Money\Currency
     */
    public static function getDefaultCurrency(): \Money\Currency
    {
        return new \Money\Currency('RUB');
    }

    /**
     * @return DateTimeZone
     */
    public static function getDefaultTimezone(): \DateTimeZone
    {
        return new \DateTimeZone(self::DEFAULT_TIMEZONE);
    }
}
