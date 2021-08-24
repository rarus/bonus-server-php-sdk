<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

use Rarus\BonusServer\Certificates;
use Rarus\BonusServer\Certificates\DTO\Certificate;
use Rarus\BonusServer\Certificates\DTO\CertificateGroup;
use Rarus\BonusServer\Certificates\DTO\CertificateGroupId;
use Rarus\BonusServer\Certificates\DTO\CertificateId;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPayment;
use Rarus\BonusServer\Transactions\DTO\CertPayments\CertPaymentCollection;
use Rarus\BonusServer\Util\MoneyParser;

// инициализируем транспорт для работы с сущностью Сертификаты
$certificateTransport = Certificates\Transport\Role\Organization\Fabric::getInstance($apiClient, new \Money\Currency('RUB'), $log);

$certificateGroup = new CertificateGroup();
$certificateGroup->setId(new CertificateGroupId('dc9699d4-86da-4ceb-bdbe-9d2b9d80e91d'));

$certificateId = uniqid('');
$newCertificate = new Certificate(
    new CertificateId($certificateId)
);
$newCertificate->setCertificateGroup($certificateGroup);

var_dump(Certificates\Formatters\Certificate::toArrayForCreateNewCertificate($newCertificate));

try {
    $certificate = $certificateTransport->add($newCertificate);

    // активация
    $sum = MoneyParser::parseFloat(100, new \Money\Currency('RUB'));
    $docId = null;
    $certificateTransport->activate($newCertificate->getCertificateId(), $sum, $docId);

    // оплата
    $docId = bin2hex(random_bytes(16));
    $certPaymentCollection = new CertPaymentCollection();
    $certificatePayment = new CertPayment();
    $certificatePayment->setLineNumber(1)->setCertificateId($certificate->getCertificateId())->setSum($certificate->getBalance());
    $certPaymentCollection->attach($certificatePayment);
    $certificateTransport->pay($docId, $certPaymentCollection);

    var_dump(Certificates\Formatters\Certificate::toArrayForCreateNewCertificate($certificate));
} catch (\Rarus\BonusServer\Exceptions\NetworkException | \Rarus\BonusServer\Exceptions\ApiClientException | \Rarus\BonusServer\Exceptions\UnknownException | Exception $e) {
}


