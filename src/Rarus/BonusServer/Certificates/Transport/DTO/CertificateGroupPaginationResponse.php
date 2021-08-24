<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Certificates\Transport\DTO;

use Rarus\BonusServer\Certificates\DTO\CertificateGroupCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Transport\DTO\PaginationResponse;

/**
 * Class PaginationResponse
 *
 * @package Rarus\BonusServer\Cards\Transport\DTO
 */
class CertificateGroupPaginationResponse extends PaginationResponse
{
    /**
     * @var \Rarus\BonusServer\Certificates\DTO\CertificateGroupCollection
     */
    private $certificateGroupCollection;

    /**
     * PaginationResponse constructor.
     *
     * @param \Rarus\BonusServer\Certificates\DTO\CertificateGroupCollection $certificateGroupCollection
     * @param Pagination                                                     $pagination
     */
    public function __construct(CertificateGroupCollection $certificateGroupCollection, Pagination $pagination)
    {
        $this->certificateGroupCollection = $certificateGroupCollection;
        $this->pagination = $pagination;
    }

    /**
     * @return \Rarus\BonusServer\Certificates\DTO\CertificateGroupCollection
     */
    public function getCertificateGroupCollection(): CertificateGroupCollection
    {
        return $this->certificateGroupCollection;
    }
}
