<?php

declare(strict_types=1);


namespace src\Rarus\BonusServer\Articles\Transport\Role\Organization;

use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Articles\DTO\Article;
use Rarus\BonusServer\Articles\DTO\ArticleCollection;
use Rarus\BonusServer\Articles\DTO\ArticleFilter;
use Rarus\BonusServer\Articles\DTO\ArticleId;
use Rarus\BonusServer\Articles\DTO\Property\ArticleProperty;
use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyCollection;
use Rarus\BonusServer\Articles\DTO\Property\ArticlePropertyId;
use Rarus\BonusServer\Articles\Transport\Role\Organization\Fabric;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Segments\DTO\Segment;
use Rarus\BonusServer\Transactions\DTO\Products\ProductRowCollection;
use Rarus\BonusServer\Transport\DTO\Pagination;

/**
 * Class TransportTest
 *
 * @package src\Rarus\BonusServer\Segments\Transport\Role\Organization
 */
class TransportTest extends TestCase
{
    /**
     * @var \Rarus\BonusServer\Articles\Transport\Role\Organization\Transport
     */
    private $articleTransport;
    /**
     * @var \Rarus\BonusServer\Users\Transport\Role\Organization\Transport
     */
    private $userTransport;
    /**
     * @var \Rarus\BonusServer\Shops\Transport\Role\Organization\Transport
     */
    private $shopTransport;
    /**
     * @var \Rarus\BonusServer\Transactions\Transport\Role\Organization\Transport
     */
    private $transactionTransport;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testStoreMethod(): void
    {
        $articleId = 'id-' . random_int(0, PHP_INT_MAX);
        $newArticle = (new Article(new ArticleId($articleId), 'Test assortment2'));

        $propertyCollection = new ArticlePropertyCollection();
        $property = new ArticleProperty(
            new ArticlePropertyId('1'),
            'Цвет',
            'Красный'
        );
        $propertyCollection->attach($property);
        $newArticle->setPropertyCollection($propertyCollection);

        $articleCollection = new ArticleCollection();
        $articleCollection->attach($newArticle);

        $this->articleTransport->store($articleCollection);
        $article = $this->articleTransport->getByArticleId(new ArticleId($articleId));

        $this->assertEquals($newArticle->getArticleId()->getId(), $article->getArticleId()->getId());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testStoreGroupMethod(): void
    {
        $groupId = 'id-123' . random_int(0, PHP_INT_MAX);
        $newGroup = (new Article(new ArticleId($groupId), 'New Group'));

        $newGroup->setIsGroup(true);

        $articleCollection = new ArticleCollection();
        $articleCollection->attach($newGroup);

        $this->articleTransport->store($articleCollection);
        $article = $this->articleTransport->getByArticleId(new ArticleId($groupId));

        $this->assertEquals($newGroup->getArticleId()->getId(), $article->getArticleId()->getId());
    }

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function testListMethod(): void
    {
        $articleId = 'id-' . random_int(0, PHP_INT_MAX);
        $newArticle = (new Article(new ArticleId($articleId), 'Test assortment list'));

        $propertyCollection = new ArticlePropertyCollection();
        $property = new ArticleProperty(
            new ArticlePropertyId('1'),
            'Цвет',
            'Красный'
        );
        $propertyCollection->attach($property);
        $newArticle->setPropertyCollection($propertyCollection);

        $articleCollection = new ArticleCollection();
        $articleCollection->attach($newArticle);

        $this->articleTransport->store($articleCollection);
        $this->articleTransport->store($articleCollection);

        $articleFilter = new ArticleFilter();
        $articleFilter->setNameFilter('Test assortment list');
        $articleCollection = $this->articleTransport->list($articleFilter, new Pagination());

        $this->assertGreaterThanOrEqual(2, $articleCollection->getPagination()->getResultItemsCount());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->articleTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->userTransport = \Rarus\BonusServer\Users\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->shopTransport = \Rarus\BonusServer\Shops\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
        $this->transactionTransport = \Rarus\BonusServer\Transactions\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
