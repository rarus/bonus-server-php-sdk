<?php

declare(strict_types=1);


namespace Rarus\BonusServer\Certificates\DTO;


/**
 * Class CertificateId
 *
 * @package Rarus\BonusServer\Certificates\DTO
 */
class CertificateId
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
