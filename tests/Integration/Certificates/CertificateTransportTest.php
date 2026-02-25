<?php

namespace Integration\Certificates;

use Exception;
use Money\Currency;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Rarus\LMS\SDK\Certificates\DTO\CertificateDto;
use Rarus\LMS\SDK\Client;
use Rarus\LMS\SDK\Documents\DTO\CertificateDocumentDto;
use Rarus\LMS\SDK\Documents\DTO\DocumentDto;
use Rarus\LMS\SDK\Documents\DTO\SaleItemDto;
use Rarus\LMS\SDK\Exceptions\ApiClientException;
use Rarus\LMS\SDK\Exceptions\NetworkException;
use Rarus\LMS\SDK\Exceptions\UnknownException;
use Rarus\LMS\SDK\Utils\MoneyParser;
use TestEnvironmentManager;

class CertificateTransportTest extends TestCase
{
    private Client $client;

    /**
     * @throws ApiClientException
     * @throws NetworkException
     * @throws UnknownException
     */
    public function test_get_certificate_by_id(): void
    {
        $code = 'PROMO-103';
        $certificateDto = $this->client->certificates()->getCertificateById($code);
        $this->assertInstanceOf(CertificateDto::class, $certificateDto);
    }

    public function test_create_certificate(): void
    {
        $code = 'TEST_' . random_int(100000000, 999999999);
        $parentId = '1';
        $newCertificateId = $this->client->certificates()->createCertificate($code, $parentId);
        $certificateDto = $this->client->certificates()->getCertificateById($code);
        $this->assertEquals($newCertificateId, $certificateDto->code);

        date_default_timezone_set('Europe/Moscow');
        $saleItemDto = new SaleItemDto(
            productId: 'id-1',
            productName: 'name-1',
            price: MoneyParser::parse('100', new Currency('RUB')),
            quantity: 1,
            certificates: [
                new CertificateDocumentDto(
                    balance: MoneyParser::parse('100', new Currency('RUB')),
                    code: $code,
                )
            ]
        );
        $products = [$saleItemDto];
        $documentDto = new DocumentDto(
            docNumber: '1234567890',
            registerId: '1234567890',
            shopId: '1',
            items: $products,
        );
        $result = $this->client->documents()->purchase($documentDto);
        $this->assertNotEmpty($result['items']);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = TestEnvironmentManager::getInstance();
    }
}
