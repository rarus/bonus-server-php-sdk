<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Auth;

use Rarus\BonusServer\Auth\DTO\Credentials;
use Rarus\BonusServer\Auth\DTO\AuthToken;

/**
 * Class Fabric
 *
 * @package Rarus\BonusServer\Credentials
 */
class Fabric
{
    /**
     * @param int         $companyId
     * @param string      $login
     * @param string      $password
     * @param string|null $session
     *
     * @return Credentials
     */
    public static function createCredentialsForRoleClient(int $companyId, string $login, string $password, string $session = null): Credentials
    {
        return new Credentials($login, $password, 'client', $session, $companyId);
    }

    /**
     * @param string      $login
     * @param string      $password
     * @param string|null $session
     *
     * @return Credentials
     */
    public static function createCredentialsForRoleOrganization(string $login, string $password, string $session = null): Credentials
    {
        return new Credentials($login, $password, 'organization', $session, null);
    }

    /**
     * @param array $authToken
     *
     * @return AuthToken
     */
    public static function initAuthTokenFromResponseArray(array $authToken): AuthToken
    {
        return new AuthToken(
            (int)$authToken['code'],
            $authToken['message'],
            $authToken['token'],
            (int)$authToken['company_id'],
            (int)$authToken['expires']
        );
    }
}