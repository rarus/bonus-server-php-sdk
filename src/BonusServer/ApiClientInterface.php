<?php
namespace Rarus\BonusServer;

use GuzzleHttp\Exception\GuzzleException;
use Rarus\BonusServer\Exceptions\BonusServerException;


/**
 * Class Client
 *
 * @package Rarus\BonusServer
 */
interface ApiClientInterface
{
    /**
     * @param $apiMethod
     * @param $requestType
     * @param $arHttpRequestOptions
     *
     * @throws \RuntimeException on failure.
     * @throws GuzzleException
     * @throws BonusServerException
     *
     * @return null|string
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = array());
}