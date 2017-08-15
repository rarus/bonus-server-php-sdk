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
     * @throws BonusServerException
     *
     * @return null|array
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = array());
}