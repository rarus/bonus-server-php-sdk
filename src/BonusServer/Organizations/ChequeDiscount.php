<?php
namespace Rarus\BonusServer\Organizations;

/**
 * Class ChequeItem
 * @package Rarus\BonusServer\Organizations
 */
class ChequeDiscount
{
    /**
     * @var string
     */
    protected $lineNumber;

    /**
     * @var string
     */
    protected $discount_id;

    /**
     * @var string
     */
    protected $discount_type;

    /**
     * @var float
     */
    protected $discount_summ;

    /**
     * @var string
     */
    protected $gift_list_id;

    /**
     * @var string
     */
    protected $discount_name;
    /**
     * @var float
     */
    protected $discount_value;

    /**
     * ChequeDiscount constructor.
     * @param array $arChequeDiscItem
     */
    public function __construct(array $arChequeDiscItem)
    {
        $this->setLineNumber($arChequeDiscItem['line_number']);
        $this->setDiscountId($arChequeDiscItem['discount_id']);
        $this->setDiscountType($arChequeDiscItem['discount_type']);
        $this->setDiscountSumm($arChequeDiscItem['discount_summ']);
        $this->setGiftListId($arChequeDiscItem['gift_list_id']);
        $this->setDiscountName($arChequeDiscItem['discount_name']);
        $this->setDiscountValue($arChequeDiscItem['discount_value']);
    }

    /**
     * @param int $lineNumber
     */
    protected function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return string
     */
    public function getDiscountId()
    {
        return $this->discount_id;
    }

    /**
     * @param string $discount_id
     */
    public function setDiscountId($discount_id)
    {
        $this->discount_id = $discount_id;
    }

    /**
     * @return string
     */
    public function getDiscountType()
    {
        return $this->discount_type;
    }

    /**
     * @param string $discount_type
     */
    public function setDiscountType($discount_type)
    {
        $this->discount_type = $discount_type;
    }

    /**
     * @return float
     */
    public function getDiscountSumm()
    {
        return $this->discount_summ;
    }

    /**
     * @param float $discount_summ
     */
    public function setDiscountSumm($discount_summ)
    {
        $this->discount_summ = $discount_summ;
    }

    /**
     * @return string
     */
    public function getGiftListId()
    {
        return $this->gift_list_id;
    }

    /**
     * @param string $gift_list_id
     */
    public function setGiftListId($gift_list_id)
    {
        $this->gift_list_id = $gift_list_id;
    }

    /**
     * @return float
     */
    public function getDiscountValue()
    {
        return $this->discount_value;
    }

    /**
     * @param float $discount_value
     */
    public function setDiscountValue($discount_value)
    {
        $this->discount_value = $discount_value;
    }

    /**
     * @return string
     */
    public function getDiscountName()
    {
        return $this->discount_name;
    }

    /**
     * @param string $discount_name
     */
    public function setDiscountName($discount_name)
    {
        $this->discount_name = $discount_name;
    }
}