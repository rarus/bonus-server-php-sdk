<?php
declare(strict_types=1);

use \Rarus\BonusServer\Users;
use \Rarus\BonusServer\Cards;
use \Rarus\BonusServer\Shops;
use \Rarus\BonusServer\Transactions;

/**
 * генератор тестовых демо-данных для использования в тестах
 * Class DemoDataGenerator
 */
class DemoDataGenerator
{
    /**
     * @param int $cardsCount
     *
     * @return Cards\DTO\CardCollection
     * @throws Exception
     */
    public static function createNewCardCollection(int $cardsCount): Cards\DTO\CardCollection
    {
        $cards = new Cards\DTO\CardCollection();
        for ($i = 1; $i <= $cardsCount; $i++) {
            $cards->attach(
                Cards\DTO\Fabric::createNewInstance(
                    'php-unit-test-card #' . $i,
                    (string)random_int(1000000, 100000000),
                    \TestEnvironmentManager::getDefaultCurrency())
            );
        }

        return $cards;
    }

    /**
     * @return Cards\DTO\Card
     * @throws Exception
     */
    public static function createNewCard(): Cards\DTO\Card
    {
        $cardPrefix = random_int(1000000, 100000000);

        return Cards\DTO\Fabric::createNewInstance(
            'php-unit-test-card' . $cardPrefix,
            (string)$cardPrefix,
            \TestEnvironmentManager::getDefaultCurrency());
    }

    /**
     * @param int $usersCount
     *
     * @return Users\DTO\UserCollection
     * @throws Exception
     */
    public static function createNewUserWithUserUidAndPasswordCollection(int $usersCount): Users\DTO\UserCollection
    {
        $newUsers = new Users\DTO\UserCollection();

        for ($i = 0; $i < $usersCount; $i++) {
            $newUsers->attach(self::createNewUserWithUserUidAndPassword('userID' . (string)rand(0, PHP_INT_MAX), 'userPass' . (string)rand(0, PHP_INT_MAX)));
        }

        return $newUsers;
    }

    /**
     * @param string $userUid
     * @param string $userPasswordHash
     *
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUserWithUserUidAndPassword(string $userUid, string $userPasswordHash): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return Users\DTO\Fabric::createNewInstance(
            $userUid,
            'Михаил Гришин | ' . $userUUID,
            '+79788882222',
            'grishi@rarus.ru',
            null,
            null,
            $userPasswordHash,
            new Users\DTO\UserId($userUid),
            Users\DTO\Status\Fabric::initDefaultStatusForNewUser()
        );
    }

    /**
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUser(): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . $userUUID,
            'Михаил Гришин | ' . $userUUID,
            '+7978 888 22 22',
            'grishi@rarus.ru',
            Users\DTO\Gender\Fabric::getMale(),
            new DateTime('27.08.2018 00:00:00', \TestEnvironmentManager::getDefaultTimezone())
        );
    }

    /**
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUserWithSummerBirthday(): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . $userUUID,
            'Михаил Гришин | ' . $userUUID,
            '+7978 888 22 22',
            'grishi@rarus.ru',
            Users\DTO\Gender\Fabric::getMale(),
            new DateTime('06.08.1995 00:00:00', \TestEnvironmentManager::getDefaultTimezone())
        );
    }

    /**
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUserWithNowDateTimeBirthday(): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . $userUUID,
            'Михаил Гришин | ' . $userUUID,
            '+7978 888 22 22',
            'grishi@rarus.ru',
            Users\DTO\Gender\Fabric::getMale(),
            new DateTime('now', \TestEnvironmentManager::getDefaultTimezone())
        );
    }

    /**
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUserWithWinterBirthday(): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . $userUUID,
            'Михаил Гришин | ' . $userUUID,
            '+7978 888 22 22',
            'grishi@rarus.ru',
            Users\DTO\Gender\Fabric::getMale(),
            new DateTime('06.01.1995 00:00:00', \TestEnvironmentManager::getDefaultTimezone())
        );
    }

    /**
     * @return Users\DTO\User
     * @throws Exception
     */
    public static function createNewUserWithoutBirthday(): \Rarus\BonusServer\Users\DTO\User
    {
        $userUUID = random_int(0, PHP_INT_MAX);

        return \Rarus\BonusServer\Users\DTO\Fabric::createNewInstance(
            'grishi-' . $userUUID,
            'Михаил Гришин | ' . $userUUID,
            '+7978 888 22 22',
            'grishi@rarus.ru',
            Users\DTO\Gender\Fabric::getMale()
        );
    }

    /**
     * @param Cards\DTO\Card  $card
     * @param Shops\DTO\Shop  $shop
     * @param \Money\Currency $defaultCurrency
     *
     * @return Transactions\DTO\Sale
     * @throws Exception
     */
    public static function createNewSaleTransaction(Cards\DTO\Card $card, Shops\DTO\Shop $shop, \Money\Currency $defaultCurrency): Transactions\DTO\Sale
    {
        $saleTransaction = new Transactions\DTO\Sale();
        $saleTransaction
            ->setCardId($card->getCardId())
            ->setShopId($shop->getShopId())
            ->setAuthorName('Кассир Иванов')
            ->setDescription(sprintf('Продажа по документу Чек№%s', \random_int(1, 5000)))
            ->setDocument(Transactions\DTO\Document\Fabric::createNewInstance((string)random_int(1000000, 100000000), 0))
            ->setCashRegister(\Rarus\BonusServer\Transactions\DTO\CashRegister\Fabric::createNewInstance((string)random_int(1000000, 100000000), 'касса 1'))
            ->setChequeNumber((string)random_int(1000000, 100000000))
            ->setBonusPayment(0)
            ->setChequeRows(self::createChequeRows(\random_int(2, 20), $defaultCurrency));

        return $saleTransaction;
    }

    /**
     * @param int             $rowCount
     * @param \Money\Currency $defaultCurrency
     *
     * @return Transactions\DTO\ChequeRows\ChequeRowCollection
     * @throws Exception
     */
    public static function createChequeRows(int $rowCount, \Money\Currency $defaultCurrency): Transactions\DTO\ChequeRows\ChequeRowCollection
    {
        $chequeRowCollection = new Transactions\DTO\ChequeRows\ChequeRowCollection();

        for ($i = 0; $i < $rowCount; $i++) {
            $productCnt = \random_int(1, 20);
            $productPrice = \random_int(50000, 10000000);

            $chequeRowCollection->attach((new Transactions\DTO\ChequeRows\ChequeRow())
                ->setLineNumber($i + 1)
                ->setArticleId(new \Rarus\BonusServer\Articles\DTO\ArticleId(sprintf('ART-[%s]-%s,', $i, md5((string)$i))))
                ->setName(sprintf('товар № %s', $i + 1))
                ->setQuantity($productCnt)
                ->setPrice(new \Money\Money($productPrice, $defaultCurrency))
                ->setSum(new \Money\Money($productCnt * $productPrice, $defaultCurrency))
                ->setDiscount(new \Money\Money(\random_int(1000, 100000), $defaultCurrency)));
        }

        return $chequeRowCollection;
    }
}