use SIFMES
update ContentSimple
    set ContainerProvided = 0, PedestalProvided = 0, RFIDProvided = 0, RFID = NULL,
        RawMaterialProvided = 0,CoverHatProvided = 0, QRCodeProvided = 0
update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_ContentSimple = NULL
update DetailStateCellOfPackWareHouse set FK_Id_StateCell = 1, FK_Id_ContentPack = NULL
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from DispatcherOrder
delete from OrderLocal
delete from RegisterContentSimpleAtWareHouse
delete from [Order]
delete from ContentSimple
delete from ContentPack
delete from DetailContentSimpleOfPack
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from ProcessContentPack
delete from ProcessContentSimple
delete from [Order]
