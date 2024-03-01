<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Holds\DTO;

use DateTime;
use InvalidArgumentException;
use Rarus\BonusServer\Cards\DTO\CardId;

final class NewHold
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
     * @var float
     */
    private $sum;

    /**
     * @var string|null
     */
    private $comment;

    /**
     * @var DateTime|null
     */
    private $dateTo;

    /**
     * @var int|null
     */
    private $duration;

    /**
     * @param HoldId $holdId
     * @param CardId $cardId
     * @param float $sum
     * @param string|null $comment
     * @param DateTime|null $dateTo
     * @param int|null $duration
     */
    public function __construct(
        HoldId $holdId,
        CardId $cardId,
        float $sum,
        ?string $comment,
        ?DateTime $dateTo,
        ?int $duration = null
    ) {
        if ($dateTo === null && $duration === null) {
            throw new InvalidArgumentException("At least one of the fields must be provided.");
        }

        $this->holdId = $holdId;
        $this->cardId = $cardId;
        $this->sum = $sum;
        $this->comment = $comment;
        $this->dateTo = $dateTo;
        $this->duration = $duration;
    }

    public function getHoldId(): HoldId
    {
        return $this->holdId;
    }

    public function getCardId(): CardId
    {
        return $this->cardId;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getDateTo(): ?DateTime
    {
        return $this->dateTo;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }
}
