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

select * from ProcessContentSimple
select * from ProcessContentPack
select * from ContentPack
select * from OrderLocal
select * from DetailStateCellOfSimpleWareHouse
select * from ContentSimple

select * from DetailProductionStationLine
select * from ProductionStationLine

delete from ProcessContentPack where FK_Id_Station = 410
update ProcessContentPack set FK_Id_State = 0, Data_Fin = NULL where FK_Id_Station = 409
update [DetailStateCellOfPackWareHouse] set FK_Id_StateCell = 1, FK_Id_PackContent = NULL

select * from [User]
select * from [Station]

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

select Id_Station, Name_Station from Station
inner join UserStationRole on Id_Station = FK_Id_Station
inner join [User] on Id_User = FK_Id_User
where username = 'admin'

