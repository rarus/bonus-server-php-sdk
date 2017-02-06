<?php
namespace Rarus\BonusServer\Organizations;

use Rarus\BonusServer\ApiClientInterface;

/**
 * Class ChequeItem
 * @package Rarus\BonusServer\Organizations
 */
class ChequeItem
{
    /**
     * @var string
     */
    protected $lineNumber;

    /**
     * @var string
     */
    protected $article;

    /**
     * @var float
     */
    protected $quantity;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var float
     */
    protected $discSum;

    /**
     * @var float
     */
    protected $sum;

    /**
     * @var int
     */
    protected $bonusPercent;

    /**
     * @var int
     */
    protected $bonusSum;
    /**
     * SettingsItem constructor.
     *
     * @param $arSettingsItem
     */
    public function __construct($arChequeItem)
    {
        $this->setLineNumber($arChequeItem['line_number']);
        $this->setArticle($arChequeItem['article']);
        $this->setQuantity($arChequeItem['quantity']);
        $this->setPrice($arChequeItem['price']);
        $this->setDiscSum($arChequeItem['discount_summ']);
        $this->setSum($arChequeItem['summ']);
        $this->setBonusPercent($arChequeItem['bonus_percet']);
        $this->setBonusSum($arChequeItem['bonus_summ']);
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
    protected function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @param string $article
     */
    protected function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @param string
     */
    protected function getArticle()
    {
        return $this->article;
    }


    /**
     * @param float $quantity
     */
    protected function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    protected function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $price
     */
    protected function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    protected function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $discSum
     */
    protected function setDiscSum($discSum)
    {
        $this->discSum = $discSum;
    }

    /**
     * @return float
     */
    protected function getDiscSum()
    {
        return $this->discSum;
    }

    /**
     * @param float $sum
     */
    protected function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return float
     */
    protected function getSum()
    {
        return $this->sum;
    }
    /**
     * @param int $bonusPercent
     */
    protected function setBonusPercent($bonusPercent)
    {
        $this->bonusPercent = $bonusPercent;
    }

    /**
     * @return int
     */
    protected function getBonusPercent()
    {
        return $this->bonusPercent;
    }

    /**
     * @param int $bonusSum
     */
    protected function setBonusSum($bonusSum)
    {
        $this->bonusSum = $bonusSum;
    }

    /**
     * @return int
     */
    protected function getBonusSum()
    {
        return $this->bonusSum;
    }
}