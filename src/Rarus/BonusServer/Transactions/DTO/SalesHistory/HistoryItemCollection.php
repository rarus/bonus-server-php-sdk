<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\SalesHistory;

use Rarus\BonusServer\Transactions\DTO\Products\ProductRow;

/**
 * Class ChequeRowCollection
 *
 * @method  attach(HistoryItem $historyItem, $data = null)
 * @method  HistoryItem current()
 *
 * @package Rarus\BonusServer\Transactions\DTO\Products
 */
class HistoryItemCollection extends \SplObjectStorage
{
}