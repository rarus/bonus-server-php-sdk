# bonus-server-php-sdk change log

## 0.5.4 (7.09.2018)
- для сущности `Transactions` для роли `Organization` для метода `getTransactionsByCard` изменён тип возвращаемого результата на `PaginationResponse`  [issue#64](https://github.com/rarus/bonus-server-php-sdk/issues/64)
- исправления ошибок в тестах
- переписан пример `complex.s2.php` с учётом требуемых сценариев

## 0.5.3 (31.08.2018)
- добавлены уровни для карт [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61)
- для сущности `Cards` для роли `Organization` добавлен метод `getCardLevelList` [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61) 
- для сущности `Cards` для роли `Organization` исправлена ошибка в методе `setAccumulationAmount` [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61) 
- для сущности `Transactions` для роли `Organization` исправлена ошибка в методе `getSalesHistoryByCard` [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61) 
- для сущности `Cards` для роли `Organization` исправлена ошибка в постраничной навигации [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61)
- для сущности `Cards` для роли `Organization` для метода `addNewCard` добавлена возможность указать начальный баланс карты [issue#61](https://github.com/rarus/bonus-server-php-sdk/issues/61) 
- множественные исправления в тестах

## 0.5.2 (27.08.2018)
- исправлена ошибка c часовыми поясами и добавлены проверки в тесты `Rarus\BonusServer\Util\DateTimeParser` [issue#58](https://github.com/rarus/bonus-server-php-sdk/issues/58)

## 0.5.1 (20.08.2018)
- исправлена ошибка с точностью в парсере timestamp `Rarus\BonusServer\Util\DateTimeParser` [issue#55](https://github.com/rarus/bonus-server-php-sdk/issues/55)
- исправлена ошибка с некорректными датами рождения при добавлении новых пользователей [issue#55](https://github.com/rarus/bonus-server-php-sdk/issues/55)
- исправлена ошибка с получением пустого логина для всех пользователей [issue#55](https://github.com/rarus/bonus-server-php-sdk/issues/55)
- подробный лог работы юнит-тестов теперь сохраняется в папке `/tests/logs/`
- в ApiClient добавлена поддержка таймзон и метод `setTimezone` который позволяет указать нужную таймзону

## 0.5.0 (6.08.2018)
- исправлен ошибочный 404 статус если нет скидок, результаты рассчёта скидок стали опциональными [issue#36](https://github.com/rarus/bonus-server-php-sdk/issues/36)
- для сущности `Cards` для роли `Organization` добавлен метод `getByBarcode` [issue#31](https://github.com/rarus/bonus-server-php-sdk/issues/31) 
- для сущности `Cards` для роли `Organization` добавлен метод `getByUser` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- для сущности `Transactions` для роли `Organization` добавлен метод `getTransactionsByCard` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- для сущности `Transactions` для роли `Organization` добавлен метод `getSalesHistoryByCard` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- для сущности `User` для роли `Organization` добавлен метод `addNewUserAndAttachFreeCard` [issue#32](https://github.com/rarus/bonus-server-php-sdk/issues/32)
- добавлен объект постраничной навигации `Pagination`
- добавлен объект идентификатор ККМ `CashRegisterId`
- добавлен объект идентификатор документа `DocumentId`
- добавлен объект идентификатор чека `ChequeId`
- добавлен парсер timestamp `Rarus\BonusServer\Util\DateTimeParser` [issue#40](https://github.com/rarus/bonus-server-php-sdk/issues/40)
- для сущности `Cards` для роли `Organization` добавлен метод `getAccountStatement` [issue#40](https://github.com/rarus/bonus-server-php-sdk/issues/40)
- добавлен объект выписка по карточному счёту `AccountStatement`
- добавлен объект идентификатор уровня карты `LevelId`
- для сущности `Cards` для роли `Organization` в методе `levelUp` теперь возвращается обновлённый объект карты
- для сущности `Cards` для роли `Organization` добавлен метод `getPaymentBalance` [issue#45](https://github.com/rarus/bonus-server-php-sdk/issues/45)
- добавлен объект доступный для платежа баланс по карточному счёту `PaymentBalance`
- исправлены ошибки при конвертации дат и времени, добавлен служебный класс `Rarus\BonusServer\Util\DateTimeParser` [issue#47](https://github.com/rarus/bonus-server-php-sdk/issues/47) 
- для сущности `Cards` для роли `Organization`для метода `list` добавлена обязательная постраничная навигация [issue#50](https://github.com/rarus/bonus-server-php-sdk/issues/50)
- для сущности `Shops` для роли `Organization`добавлен метод `isShopExistsWithId` [issue#49](https://github.com/rarus/bonus-server-php-sdk/issues/49)
- для сущности `Shops` добавлена роль `Organization` [issue#49](https://github.com/rarus/bonus-server-php-sdk/issues/49)


## 0.3.5 (24.07.2018)
- для сущности `Transactions` в транспорте для роли `Organization` добавлен метод `addRefundTransaction`

## 0.3.4 (23.07.2018)
- для сущности `Discounts` в транспорте для роли `Organization` добавлен метод `calculateDiscountsAndBonusDiscounts`

## 0.3.3 (28.06.2018)
- для сущности `Discounts` добавлен транспорт для роли `Organization` с методом `calculateDiscounts`
- добавлен форматер для сущности `ChequeRow`

## 0.3.2 (20.06.2018)
- для сущности `Users` добавлен транспорт для роли `User` с методом `current`

## 0.3.1 (19.06.2018)
- для сущности `Cards` под ролью `User` добавлен метод `getBalanceInfo`

## 0.3.0 (18.06.2018)
- для сущности `Transactions` добавлены роли `Organization` и `User`
- для сущности `Transactions` в транспорт роли `User` добавлен метод `getSalesHistory`

## 0.2.0 (15.06.2018)
- добавлена поддержка ролей для транспорта сущности `User`
- добавлен метод `importNewUsers` для транспорта сущности `User`
- добавлен метод `attachToUser` для траспорта сущности `Cards`
- добавлен транспорт роли `User` для сущности `Card`
- добавлена сущность `ShopId` для сущности `Shop`
- добавлена сущность `ArticleId` для сущности `Article`
- добавлена сущность `Transactions`

## 0.1.2 (25.05.2018)
- добавлен транспорт для сущности `User` c методами `addNewUser` и `getByUserId`

## 0.1.1 (10.05.2018)
- для транспорта сущности `Card` добавлены методы `isCardCanLevelUp` и `levelUp` 

## 0.1.0 (10.01.2018)
* первоначальная заливка текущей сборки библиотеки