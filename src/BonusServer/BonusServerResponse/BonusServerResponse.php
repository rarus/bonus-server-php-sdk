<?

namespace Rarus\BonusServer\BonusServerResponse;

/**
 * Class BonusServerResponse
 * @package Rarus\BonusServer\BonusServerResponse
 */
class BonusServerResponse
{
    protected $data;
    protected $pagination;

    public function __construct($obSplStorage, $arPagination = [])
    {
        $this->data = $obSplStorage;
        $this->pagination = $arPagination;
    }

    /**
     * @return _SplObjectStorage object
     */
    public function getResponseData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getResponsePagination()
    {
        return $this->pagination;
    }
}
?>