<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transport\DTO;

/**
 * объект постраничной навигации
 *
 * Class Pagination
 *
 * @package Rarus\BonusServer\Transport\DTO
 */
final class Pagination
{
    /**
     * @var int размер страницы при постраничной навигации
     */
    private $pageSize;
    /**
     * @var int номер страницы при постраничной навигации
     */
    private $pageNumber;
    /**
     * @var int количество сущностей
     */
    private $resultItemsCount;
    /**
     * @var int количество страниц
     */
    private $resultPagesCount;

    /**
     * Pagination constructor.
     *
     * @param int $pageSize
     * @param int $pageNumber
     */
    public function __construct(int $pageSize = 10, int $pageNumber = 1)
    {
        $this->setPageSize($pageSize);
        $this->setPageNumber($pageNumber);
        $this->setResultItemsCount(0);
        $this->setResultPagesCount(0);
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     *
     * @return Pagination
     */
    public function setPageSize(int $pageSize): Pagination
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * @param int $pageNumber
     *
     * @return Pagination
     */
    public function setPageNumber(int $pageNumber): Pagination
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getResultItemsCount(): int
    {
        return $this->resultItemsCount;
    }

    /**
     * @param int $resultItemsCount
     *
     * @return Pagination
     */
    public function setResultItemsCount(int $resultItemsCount): Pagination
    {
        $this->resultItemsCount = $resultItemsCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getResultPagesCount(): int
    {
        return $this->resultPagesCount;
    }

    /**
     * @param int $resultPagesCount
     *
     * @return Pagination
     */
    public function setResultPagesCount(int $resultPagesCount): Pagination
    {
        $this->resultPagesCount = $resultPagesCount;

        return $this;
    }
}