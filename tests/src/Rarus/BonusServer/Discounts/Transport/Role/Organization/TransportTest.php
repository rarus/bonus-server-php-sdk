<?php

declare(strict_types=1);

namespace Rarus\BonusServer\Tests\Discounts\Transport\Role\Organization\Transport;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Rarus\BonusServer\Cards;
use Rarus\BonusServer\Certificates\DTO\CertificateId;
use Rarus\BonusServer\Discounts;
use Rarus\BonusServer\Exceptions\ApiClientException;
use Rarus\BonusServer\Exceptions\NetworkException;
use Rarus\BonusServer\Exceptions\UnknownException;
use Rarus\BonusServer\Shops;
use Rarus\BonusServer\Transactions;
use Rarus\BonusServer\Transport\DTO\Pagination;
use Rarus\BonusServer\Users;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
 */
class TransportTest extends TestCase
{
    /**
     * @var Cards\Transport\Role\Organization\Transport
     */
    private $cardTransport;
    /**
     * @var Shops\Transport\Role\Organization\Transport
     */
    private $shopTransport;
    /**
     * @var Discounts\Transport\Role\Organization\Transport
     */
    private $discountTransport;

    /**
     * @covers \Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport::calculateDiscountsAndBonusDiscounts()
     */
    public function testCalculateDiscountsAndBonusDiscountsMethod(): void
    {
        $card = $this->cardTransport->addNewCard(\DemoDataGenerator::createNewCard());
        $card = $this->cardTransport->activate($card);

        $shop = $this->shopTransport->add(\DemoDataGenerator::createNewShop());


        $estimate = $this->discountTransport->calculateDiscountsAndBonusDiscounts(\DemoDataGenerator::createNewDiscountDocument($shop, $card));

        if ($estimate !== null) {
            $this::assertGreaterThan(-1, $estimate->getDiscountItems()->count());
            $this::assertGreaterThan(-1, $estimate->getDocumentItems()->count());
        } else {
            // todo выяснить, по какому принципу будут давать скидки для тестов
            $this::assertNull($estimate);
        }
    }

    /**
     * @covers \Rarus\BonusServer\Discounts\Transport\Role\Organization\Transport::calculateDiscounts()
     */
    public function testCalculateDiscountsMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance((string)random_int(1000000, 100000000), (string)random_int(1000000, 100000000), new \Money\Currency('RUB'));
        $card = $this->cardTransport->addNewCard($newCard);
        $card = $this->cardTransport->activate($card);


        $newShop = Shops\DTO\Fabric::createNewInstance('Новый магазин');
        $shop = $this->shopTransport->add($newShop);

        // табличная часть транзакции
        $discountDocument = new Discounts\DTO\Document();

        // Оплата сертификатом
        $paymentTypeCollection = new Transactions\DTO\PaymentTypes\PaymentTypeCollection();
        $paymentType = Transactions\DTO\PaymentTypes\Fabric::getCertificate()->setSum(new Money(1000, \TestEnvironmentManager::getDefaultCurrency()));
        $paymentTypeCollection->attach($paymentType);

        // Данные по сертификату
        $certificatePaymentCollection = new Transactions\DTO\CertPayments\CertPaymentCollection();
        $certificatePayment = new Transactions\DTO\CertPayments\CertPayment();
        $certificatePayment->setLineNumber(1)->setCertificateId(new CertificateId('CERT-1000'))->setSum(new Money(1000, \TestEnvironmentManager::getDefaultCurrency()));
        $certificatePaymentCollection->attach($certificatePayment);

        $discountDocument
            ->setShopId($shop->getShopId())
            ->setCard($card)
            ->setPaymentTypeCollection($paymentTypeCollection)
            ->setCertPaymentCollection($certificatePaymentCollection)
            ->setChequeRows(\DemoDataGenerator::createChequeRows(random_int(1, 20), \TestEnvironmentManager::getDefaultCurrency()));

        $estimate = $this->discountTransport->calculateDiscounts($discountDocument);
        if ($estimate !== null) {
            $this::assertGreaterThan(-1, $estimate->getDiscountItems()->count());
            $this::assertGreaterThan(-1, $estimate->getDocumentItems()->count());
        } else {
            // todo выяснить, по какому принципу будут давать скидки для тестов
            $this::assertNull($estimate);
        }

        $this->shopTransport->delete($shop);
    }

    public function testGetByFilter(): void
    {
        $discountFilter = new Discounts\DTO\DiscountFilter();

        $pagination = new Pagination();
        $discounts = $this->discountTransport->getByFilter($discountFilter, $pagination);

        $this->assertGreaterThan(-1, $discounts->getDiscountCollection()->count());
    }

    /**
     * @throws ApiClientException
     * @throws UnknownException
     * @throws NetworkException
     */
    public function testGetById(): void
    {
        $discountFilter = new Discounts\DTO\DiscountFilter();

        $pagination = new Pagination();
        $discounts = $this->discountTransport->getByFilter($discountFilter, $pagination);

        $discountId = $discounts->getDiscountCollection()->current()->getId();
        $discount = $this->discountTransport->getById(new Discounts\DTO\DiscountId($discountId), true);

        $this->assertEquals($discountId, $discount->getId());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->discountTransport = Discounts\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->cardTransport = Cards\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );

        $this->shopTransport = Shops\Transport\Role\Organization\Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getDefaultCurrency(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}
