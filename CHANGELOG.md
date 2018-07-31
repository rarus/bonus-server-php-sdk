# bonus-server-php-sdk change log

## 0.5.0 (27.07.2018)
- исправлен ошибочный 404 статус если нет скидок, результаты рассчёта скидок стали опциональными [issue#36](https://github.com/rarus/bonus-server-php-sdk/issues/36)
- для сущности `Cards` для роли `Organization` добавлен метод `getByBarcode` [issue#31](https://github.com/rarus/bonus-server-php-sdk/issues/31) 
- для сущности `Cards` для роли `Organization` добавлен метод `getByUser` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- для сущности `Transactions` для роли `Organization` добавлен метод `getTransactionsByCard` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- для сущности `Transactions` для роли `Organization` добавлен метод `getSalesHistoryByCard` [issue#37](https://github.com/rarus/bonus-server-php-sdk/issues/37)
- добавлен объект постраничной навигации `Pagination`
- добавлен объект идентификатор ККМ `CashRegisterId`
- добавлен объект идентификатор документа `DocumentId`
- добавлен объект идентификатор чека `ChequeId`

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