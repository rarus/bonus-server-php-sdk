<?php

namespace Rarus\BonusServer\Auth;

interface TokenInterface
{
    /**
     * @return int
     */
    public function getCompanyId();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return int
     */
    public function getExpires();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return int
     */
    public function getCode();
}
