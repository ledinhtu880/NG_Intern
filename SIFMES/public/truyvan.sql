use SIFMES
/* update ContentSimple set ContainerProvided = 0, PedestalProvided = 0, RFIDProvided = 0, RFID = NULL, RawMaterialProvided = 0, CoverHatProvided = 0, QRCodeProvided = 0, QRCode = NULL
update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_ContentSimple = NULL
update DetailStateCellOfPackWareHouse set FK_Id_StateCell = 1, FK_Id_ContentPack = NULL
delete from DetailContentSimpleOfPack
delete from RegisterContentSimpleAtWareHouse
delete from RegisterContentPackAtWareHouse
delete from DispatcherOrder
delete from OrderLocal
delete from RegisterContentSimpleAtWareHouse
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from ProcessContentPack
delete from ProcessContentSimple
delete from DetailContentSimpleOfPack
delete from ContentSimple
delete from ContentPack
delete from [Order]
*/

SELECT *
FROM [Order]
JOIN ContentPack ON [Order].Id_Order = ContentPack.FK_Id_Order
JOIN ProcessContentPack ON ProcessContentPack.FK_Id_ContentPack = ContentPack.Id_ContentPack
LEFT JOIN DetailStateCellOfPackWareHouse ON DetailStateCellOfPackWareHouse.FK_Id_ContentPack = ContentPack.Id_ContentPack
JOIN Customer ON Customer.Id_Customer = [Order].FK_Id_Customer
WHERE [Order].SimpleOrPack = 1
AND ProcessContentPack.FK_Id_Station = 409
AND ContentPack.Id_ContentPack NOT IN (
    SELECT Id_ContentPack
    FROM ContentPack
    JOIN DetailContentPackOrderLocal ON ContentPack.Id_ContentPack = DetailContentPackOrderLocal.FK_Id_ContentPack
    JOIN OrderLocal ON DetailContentPackOrderLocal.FK_Id_OrderLocal = OrderLocal.Id_OrderLocal
    WHERE OrderLocal.MakeOrPackOrExpedition = 2
);

select * from DetailStateCellOfPackWareHouse

update DetailStateCellOfPackWareHouse set FK_Id_ContentPack = 1 where RowI = 1 AND Colj = 1
update DetailStateCellOfPackWareHouse set FK_Id_ContentPack = 2 where RowI = 1 AND Colj = 2
update DetailStateCellOfPackWareHouse set FK_Id_ContentPack = 3 where RowI = 1 AND Colj = 3
select * from ContentPack
