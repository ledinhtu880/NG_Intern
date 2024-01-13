use SIFMES

-- Truy vấn cơ bản
select * from [SIFMES].dbo.[DetailContentSimpleOfPack]
select * from [SIFMES].dbo.[ContentPack]
select * from [SIFMES].dbo.[ContentSimple]
select * from [SIFMES].dbo.[Order]
select * from [SIFMES].dbo.[CustomerType]
select * from [SIFMES].dbo.[Customer]
select * from [SIFMES].dbo.[RawMaterial]
select * from [SIFMES].dbo.[OrderLocal]
select * from [SIFMES].dbo.[DetailContentSimpleOrderLocal]
select * from [SIFMES].dbo.[DetailContentPackOrderLocal]
select * from [SIFMES].dbo.[DetailStateCellOfSimpleWareHouse]
select * from [SIFMES].dbo.[DetailStateCellOfPackWareHouse]

-- Sửa độ dài của cột password trong bảng [User] (Chỉ dùng khi restore database)
alter table [User]
alter column password varchar(60)
select * from DetailStateCellOfSimpleWareHouse
/* update ContentSimple
    set ContainerProvided = 0, PedestalProvided = 0, RFIDProvided = 0, RFID = NULL,
        RawMaterialProvided = 0,CoverHatProvided = 0, QRCodeProvided = 0
update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_ContentSimple = NULL
update DetailStateCellOfPackWareHouse set FK_Id_StateCell = 1, FK_Id_ContentPack = NULL
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from DispatcherOrder
delete from OrderLocal
delete from RegisterContentSimpleAtWareHouse
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from ProcessContentPack
delete from ProcessContentSimple */
