<?
namespace Rarus\BonusServer\Card;

class Card implements CardInterface
{
    protected $id;
    protected $magCode;
    protected $barCode;
    protected $name;
    protected $description;
    protected $blocked;
    protected $active;
    protected $blockedDescription;
    protected $balance;
    protected $dateActive;
    protected $dateDeactivate;
    protected $dateLastTrahsaction;
    protected $lastTransaction;
    protected $image;

    public function __construct($arCard)
    {
        //var_dump($arCard);
        $this->id = $arCard["id"];
        $this->setMagCode($arCard["code"]);
        $this->setBarCode($arCard["barcode"]);
        $this->setName($arCard["name"]);
        $this->setDescription($arCard["description"]);
        $this->setBlockedStatus($arCard["blocked"]);
        $this->setActiveStatus($arCard["active"]);
        $this->setBlockedDescription($arCard["blocked_description"]);
        $this->setBalance($arCard["balance"]);
        $this->setDateActive($arCard["date_active"]);
        $this->setDateDeactivate($arCard["date_deactivate"]);
        $this->setDateLastTransaction($arCard["date_last_transaction"]);
        $this->setLastTransaction($arCard["last_transaction"]);
        $this->setImage($arCard["image"]);

    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMagCode()
    {
        return $this->magCode;
    }

    /**
     * @param string $magCode
     */
    public function setMagCode($magCode)
    {
        $this->magCode = $magCode;
    }

    /**
     * @return string
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * @param string $barCode
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function getBlockedStatus()
    {
        return $this->blocked;
    }

    /**
     * @param boolean $blocked
     */
    public function setBlockedStatus($blocked)
    {
        $this->blocked = $blocked;
    }

    /**
     * @return boolean
     */
    public function getActiveStatus()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActiveStatus($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getBlockedDescription()
    {
        return $this->blockedDescription;
    }

    /**
     * @param string $blockedDescription
     */
    public function setBlockedDescription($blockedDescription)
    {
        $this->blockedDescription = $blockedDescription;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getDateActive()
    {
        return $this->dateActive;
    }

    /**
     * @param string $dateActive
     */
    public function setDateActive($dateActive)
    {
        $this->dateActive = $dateActive;
    }

    /**
     * @return string
     */
    public function getDateDeactivate()
    {
        return $this->dateDeactivate;
    }

    /**
     * @param string $dateDeactivate
     */
    public function setDateDeactivate($dateDeactivate)
    {
        $this->dateDeactivate = $dateDeactivate;
    }

    /**
     * @return string
     */
    public function getDateLastTransaction()
    {
        return $this->dateLastTrahsaction;
    }

    /**
     * @param string $dateLastTransaction
     */
    public function setDateLastTransaction($dateLastTransaction)
    {
        $this->dateLastTrahsaction = $dateLastTransaction;
    }

    /**
     * @return string
     */
    public function getLastTransaction()
    {
        return $this->lastTransaction;
    }

    /**
     * @param string $lastTransaction
     */
    public function setLastTransaction($lastTransaction)
    {
        $this->lastTransaction = $lastTransaction;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }






}
?>