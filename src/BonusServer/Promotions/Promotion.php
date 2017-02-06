<?
namespace Rarus\BonusServer\Promotions;

/**
 * Class Promotion
 * @package Rarus\BonusServer\Promotion
 */
class Promotion
{
    protected $id;
    protected $startDate;
    protected $endDate;
    protected $shopId;
    protected $name;
    protected $shortDescription;
    protected $fullDescription;
    protected $promoUrl;
    protected $image;

    public function __construct($arPromotion)
    {
        $this->id = $arPromotion["id"];
        $this->startDate = $arPromotion["start_date"];
        $this->endDate = $arPromotion["end_date"];
        $this->shopId = $arPromotion["shop_id"];
        $this->name = $arPromotion["name"];
        $this->shortDescription = $arPromotion["short_description"];
        $this->fullDescription = $arPromotion["full_description"];
        $this->image = $arPromotion["image"];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param int $startDate
     */
    protected function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param int $endDate
     */
    protected function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param string $shopId
     */
    protected function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    protected function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getFullDescription()
    {
        return $this->fullDescription;
    }

    /**
     * @param string $fullDescription
     */
    protected function setFullDescription($fullDescription)
    {
        $this->fullDescription = $fullDescription;
    }

    /**
     * @return string
     */
    public function getPromoUrl()
    {
        return $this->promoUrl;
    }

    /**
     * @param string $promoUrl
     */
    protected function setPromoUrl($promoUrl)
    {
        $this->promoUrl = $promoUrl;
    }

}?>