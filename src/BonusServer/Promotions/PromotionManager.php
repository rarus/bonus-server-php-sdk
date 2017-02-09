<?
namespace Rarus\BonusServer\Promotions;

use Rarus\BonusServer\ApiClientInterface;
use Rarus\BonusServer\Promotions;

/**
 * Class PromotionManager
 * @package Rarus\BonusServer\Promotion
 */
class PromotionManager
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    public function __construct(ApiClientInterface $obApiClient)
    {
        $this->apiClient = $obApiClient;
    }

    /**
     * @param int $dateFrom
     * @return \SplObjectStorage
     */
    public function getPromotionsList($dateFrom = 0)
    {
        if(!$dateFrom)
        {
            $dateFrom = time();
        }
        $requestStr = '/user/promotion/';
        if((int)$dateFrom > 0)
        {
            $requestStr .= '?from='.(int)$dateFrom;
        }
        $arApiResponse = $this->apiClient->executeApiRequest((sprintf($requestStr)), 'GET');
        $obResult = new \SplObjectStorage();
        foreach($arApiResponse['promotions'] as $cnt => $arPromotionItem)
        {
            $obResult->attach(new Promotions\Promotion($arPromotionItem));
        }
        $obResult->rewind();

        return $obResult;
    }
}
?>