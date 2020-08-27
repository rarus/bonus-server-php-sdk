<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Transactions\DTO\Products;

use Rarus\BonusServer\Transactions\DTO\Products\ProductRow;

/**
 * Class ChequeRowCollection
 *
 * @method  attach(ProductRow $productRow, $data = null)
 * @method  ProductRow current()
 *
 * @package Rarus\BonusServer\Transactions\DTO\Products
 */
class ProductRowCollection extends \SplObjectStorage
{
}
