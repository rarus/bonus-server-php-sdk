<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use DateTime;
use Rarus\BonusServer\Cards\DTO\CardId;

final class HoldFilter
{
    /**
     * @var CardId|null
     */
    private $cardId;

    /**
     * @var DateTime|null
     */
    private $startDateFrom;

    /**
     * @var DateTime|null
     */
    private $startDateTo;

    /**
     * @var DateTime|null
     */
    private $endDateFrom;

    /**
     * @var DateTime|null
     */
    private $endDateTo;

    public function getCardId(): ?CardId
    {
        return $this->cardId;
    }

    public function setCardId(?CardId $cardId): HoldFilter
    {
        $this->cardId = $cardId;
        return $this;
    }

    public function getStartDateFrom(): ?DateTime
    {
        return $this->startDateFrom;
    }

    public function setStartDateFrom(?DateTime $startDateFrom): HoldFilter
    {
        $this->startDateFrom = $startDateFrom;
        return $this;
    }

    public function getStartDateTo(): ?DateTime
    {
        return $this->startDateTo;
    }

    public function setStartDateTo(?DateTime $startDateTo): HoldFilter
    {
        $this->startDateTo = $startDateTo;
        return $this;
    }

    public function getEndDateFrom(): ?DateTime
    {
        return $this->endDateFrom;
    }

    public function setEndDateFrom(?DateTime $endDateFrom): HoldFilter
    {
        $this->endDateFrom = $endDateFrom;
        return $this;
    }

    public function getEndDateTo(): ?DateTime
    {
        return $this->endDateTo;
    }

    public function setEndDateTo(?DateTime $endDateTo): HoldFilter
    {
        $this->endDateTo = $endDateTo;
        return $this;
    }
}
