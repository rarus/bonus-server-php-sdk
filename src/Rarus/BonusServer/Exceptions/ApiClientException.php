<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Exceptions;

/**
 * Class ApiClientException
 *
 * @package Rarus\BonusServer\Exceptions
 */
class ApiClientException extends BonusServerException
{
    protected $response;

    function __construct($message = "", $code = 0, \Exception $previous = null, $response = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}
