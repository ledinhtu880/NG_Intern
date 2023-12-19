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

CREATE TABLE UserStationRole (
    FK_Id_User SMALLINT,
    FK_Id_Station INT,
    PRIMARY KEY (FK_Id_User, FK_Id_Station),
    FOREIGN KEY (FK_Id_User) REFERENCES [User](Id_User),
    FOREIGN KEY (FK_Id_Station) REFERENCES Station(Id_Station)
);
insert into UserStationRole values
('0', '401'),
('0', '402'),
('0', '403'),
('0', '405'),
('0', '406'),
('0', '407'),
('0', '408'),
('0', '409'),
('0', '410'),
('0', '411');


update ContentSimple
    set ContainerProvided = 0, PedestalProvided = 0, RFIDProvided = 0, RFID = NULL,
        RawMaterialProvided = 0,CoverHatProvided = 0, QRCodeProvided = 0
update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_SimpleContent = NULL
update DetailStateCellOfPackWareHouse set FK_Id_StateCell = 1, FK_Id_PackContent = NULL
delete from ProcessContentSimple
delete from ProcessContentPack
delete from DetailContentSimpleOrderLocal
delete from DetailContentPackOrderLocal
delete from DispatcherOrder
delete from OrderLocal

select * from ProcessContentSimple order by FK_Id_ContentSimple asc, FK_Id_Station asc
select * from ProcessContentPack
select * from DetailContentSimpleOrderLocal
select * from DetailContentPackOrderLocal
select * from DispatcherOrder
select * from OrderLocal

select * from Station
select * from StationType

update StationType set PathImage = 'stations/sif-401.jpg' where Description = 'SIF-401'
update StationType set PathImage = 'stations/sif-402.jpg' where Description = 'SIF-402'
update StationType set PathImage = 'stations/sif-403.jpg' where Description = 'SIF-403'
update StationType set PathImage = 'stations/sif-404.jpg' where Description = 'SIF-404'
update StationType set PathImage = 'stations/sif-405.jpg' where Description = 'SIF-405'
update StationType set PathImage = 'stations/sif-406.jpg' where Description = 'SIF-406'
update StationType set PathImage = 'stations/sif-407.jpg' where Description = 'SIF-407'
update StationType set PathImage = 'storage/stations/sif-408.jpg' where Description = 'SIF-408'
update StationType set PathImage = 'storage/stations/sif-409.jpg' where Description = 'SIF-409'
update StationType set PathImage = 'storage/stations/sif-410.jpg' where Description = 'SIF-410'
update StationType set PathImage = 'storage/stations/sif-411.jpg' where Description = 'SIF-411'
update StationType set PathImage = 'storage/stations/sif-412.jpg' where Description = 'SIF-412'

select * from Warehouse
select * from DetailStateCellOfSimpleWareHouse
delete from Warehouse
delete from [DetailStateCellOfSimpleWareHouse]
delete from [DetailStateCellOfPackWareHouse]
