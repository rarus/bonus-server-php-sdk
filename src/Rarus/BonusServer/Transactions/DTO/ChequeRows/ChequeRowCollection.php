<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\ChequeRows;

use Rarus\BonusServer\Transactions\DTO\ChequeRows\ChequeRow;

/**
 * Class ChequeRowCollection
 *
 * @method  attach(ChequeRow $pointTrx, $data = null)
 * @method  ChequeRow current()
 *
 * @package Rarus\BonusServer\Transactions\DTO\ChequeRows
 */
class ChequeRowCollection extends \SplObjectStorage
{
}
