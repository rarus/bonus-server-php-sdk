<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use DateTime;
use Rarus\BonusServer\Cards\DTO\CardId;

final class Hold
{
    /**
     * @var HoldId
     */
    private $holdId;

    /**
     * @var CardId
     */
    private $cardId;

    /**
     * @var string|null
     */
    private $cardName;

    /**
     * @var float
     */
    private $sum;

    /**
     * @var string|null
     */
    private $comment;

    /**
     * @var DateTime
     */
    private $addDate;

    /**
     * @var DateTime
     */
    private $dateTo;

    /**
     * @param HoldId $holdId
     * @param CardId $cardId
     * @param string|null $cardName
     * @param float $sum
     * @param string|null $comment
     * @param DateTime $addDate
     * @param DateTime $dateTo
     */
    public function __construct(
        HoldId $holdId,
        CardId $cardId,
        ?string $cardName,
        float $sum,
        ?string $comment,
        DateTime $addDate,
        DateTime $dateTo
    ) {
        $this->holdId = $holdId;
        $this->cardId = $cardId;
        $this->cardName = $cardName;
        $this->sum = $sum;
        $this->comment = $comment;
        $this->addDate = $addDate;
        $this->dateTo = $dateTo;
    }

    public function getHoldId(): HoldId
    {
        return $this->holdId;
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    public function getCardName(): ?string
    {
        return $this->cardName;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getAddDate(): DateTime
    {
        return $this->addDate;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }
}
