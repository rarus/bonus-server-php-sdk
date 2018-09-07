<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport\DTO;

use Rarus\BonusServer\Cards\DTO\CardCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Cards\Transport\DTO
 */
class PaginationResponse extends \Rarus\BonusServer\Transport\DTO\PaginationResponse
{
    /**
     * @var CardCollection
     */
    private $cardCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param CardCollection $cardCollection
     * @param Pagination     $pagination
     */
    public function __construct(CardCollection $cardCollection, Pagination $pagination)
    {
        $this->cardCollection = $cardCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return CardCollection
     */
    public function getCardCollection(): CardCollection
    {
        return $this->cardCollection;
    }
}