<?php
namespace Rarus\BonusServer\Organizations;

/**
 * Class DicountCalculateDocument
 *
 * @package Rarus\BonusServer\Organizations
 */
class DicountCalculateDocument
{
	/**
	 * @var \SplObjectStorage
	 */
    protected $cheque_items;
	/**
	 * @var \SplObjectStorage
	 */
	protected $cheque_discounts;

	/**
	 * DicountCalculateDocument constructor.
	 * @param $cheque_items
	 * @param $cheque_discounts
	 */
	public function __construct($cheque_items, $cheque_discounts)
    {
        $this->setChequeItems($cheque_items);
        $this->setChequeDiscounts($cheque_discounts);
    }

	/**
	 * @return \SplObjectStorage
	 */
	public function getChequeItems()
	{
		return $this->cheque_items;
	}

	/**
	 * @param \SplObjectStorage $cheque_items
	 */
	public function setChequeItems($cheque_items)
	{
		$this->cheque_items = $cheque_items;
	}

	/**
	 * @return \SplObjectStorage
	 */
	public function getChequeDiscounts()
	{
		return $this->cheque_discounts;
	}

	/**
	 * @param \SplObjectStorage $cheque_discounts
	 */
	public function setChequeDiscounts($cheque_discounts)
	{
		$this->cheque_discounts = $cheque_discounts;
	}

}