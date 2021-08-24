<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO;


/**
 * Class CertificateGroupId
 *
 * @package Rarus\BonusServer\Certificates\DTO
 */
class CertificateGroupId
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * CertificateId constructor.
     *
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
