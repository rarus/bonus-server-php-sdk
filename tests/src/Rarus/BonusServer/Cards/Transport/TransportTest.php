<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Cards\Transport;

use \Rarus\BonusServer\Cards;

/**
 * Class TransportTest
 *
 * @package Rarus\BonusServer\Cards\Transport
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rarus\BonusServer\ApiClient
     */
    private $apiClient;
    /**
     * @var Transport
     */
    private $cardTransport;

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::list()
     */
    public function testListMethod(): void
    {
        $shopCollection = $this->cardTransport->list();
    }

    /**
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::addNewCard()
     * @covers \Rarus\BonusServer\Cards\Transport\Transport::getByCardId()
     */
    public function testAddNewCardMethod(): void
    {
        $newCard = Cards\DTO\Fabric::createNewInstance('php-unit-test-card', (string)random_int(1000000, 100000000));
        $card = $this->cardTransport->addNewCard($newCard);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->cardTransport = Fabric::getInstance(
            \TestEnvironmentManager::getInstanceForRoleOrganization(),
            \TestEnvironmentManager::getMonologInstance()
        );
    }
}