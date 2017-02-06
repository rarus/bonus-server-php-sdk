<?php
/*
 * This file is part of the Rarus\BonusServer package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rarus\BonusServer\Exceptions;
/**
 * Class BonusServerException
 *
 * \Exception
 *      BonusServerException — base class
 *          IoBonusServerException — I/O network errors
 *          ApiBonusServerException — API-level exceptions
 *
 * @package Rarus\BonusServer
 */
class BonusServerException extends \Exception
{
}