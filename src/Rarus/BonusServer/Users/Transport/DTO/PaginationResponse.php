<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Users\Transport\DTO;

use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users\DTO\UserCollection;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Cards\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var UserCollection
     */
    private $userCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param UserCollection $userCollection
     * @param Pagination     $pagination
     */
    public function __construct(UserCollection $userCollection, Pagination $pagination)
    {
        $this->userCollection = $userCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return UserCollection
     */
    public function getUsersCollection(): UserCollection
    {
        return $this->userCollection;
    }
}
