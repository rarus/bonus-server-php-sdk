<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Users\DTO\Gender;

use Rarus\BonusServer\Exceptions\ApiClientException;

class Fabric
{
    /**
     * @param $genderCode
     *
     * @return Gender
     * @throws ApiClientException
     */
    public static function initFromServerResponse($genderCode): Gender
    {
        switch (strtolower($genderCode)) {
            case 'male':
                return new Male();
                break;
            case 'female':
                return new Female();
                break;
            default:
                return new None();
                break;
        }
    }

    /**
     * @return Gender
     */
    public static function getMale(): Gender
    {
        return new Male();
    }

    /**
     * @return Gender
     */
    public static function getFemale(): Gender
    {
        return new Female();
    }
}