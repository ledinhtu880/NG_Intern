use SIFMES

insert into Customer (Id_Customer, Name_Customer, Name_Contact, Email, Phone, Address, ZipCode, FK_Id_Mode_Transport, Time_Reception, FK_Id_CustomerType) values
(1, N'Lê Đình Tú', N'Tus', 'ldt907@gmail.com', '0865176605', N'Đồng Nhân, Hai Bà Trưng, Hà Nội', '11608', '0', N'09/07/2023', '1'),
(2, N'Trương Mỹ Hoa', N'Mic', 'tmh307@gmail.com', '0832498756', N'Lò Đúc, Hai Bà Trưng, Hà Nội', '11609', '1', N'03/07/2022', '0'),
(3, N'Nguyễn Hải Tùng', N'Tũn', 'nht3107@gmail.com', '0938591792', N'Trần Khát Chân, Hai Bà Trưng, Hà Nội', '11623', '2', N'31/07/2023', '0'),
(4, N'Hoàng Thanh Thủy', N'Tthuy', 'htt1412@gmail.com', '0393056789', N'Hương Viên, Hai Bà Trưng, Hà Nội', '11608', '3', N'14/12/2022', '0'),
(5, N'Trần Công Thành', N'TTran', 'tct@gmail.com', '0912087956', N'Kim Ngưu, Hai Bà Trưng, Hà Nội', '11623', '3', N'04/08/2023', '0');

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
select * from [SIFMES].dbo.DetailStateCellOfSimpleWareHouse

-- Sửa độ dài của cột password trong bảng [User] (Chỉ dùng khi restore database)
alter table [User]
alter column password varchar(60)

SELECT
    ContentSimple.Id_SimpleContent,
    RawMaterial.Name_RawMaterial,
    ContentSimple.Count_RawMaterial,
    Customer.Name_Customer,
    ContainerType.Name_ContainerType,
    ContentSimple.Count_Container,
    ContentSimple.Price_Container
FROM
    [Order]
JOIN
    ContentSimple ON [Order].Id_Order = ContentSimple.FK_Id_Order
JOIN
    Customer ON [Order].FK_Id_Customer = Customer.Id_Customer
JOIN
    ContainerType ON ContentSimple.FK_Id_ContainerType = ContainerType.Id_ContainerType
JOIN
    CustomerType ON Customer.FK_Id_CustomerType = CustomerType.Id
JOIN
    RawMaterial ON FK_Id_RawMaterial = Id_RawMaterial
JOIN
    DetailStateCellOfSimpleWareHouse on ContentSimple.Id_SimpleContent = FK_Id_SimpleContent
WHERE
    Customer.FK_Id_CustomerType = 0
    AND ContentSimple.ContainerProvided = 0
    AND ContentSimple.PedestalProvided = 0
    AND [Order].SimpleOrPack = 0
    AND ContentSimple.Id_SimpleContent NOT IN (
        SELECT FK_Id_ContentSimple
        FROM ProcessContentSimple
    );

select * from DetailStateCellOfSimpleWareHouse


delete from [SIFMES].dbo.[DetailContentSimpleOfPack]
delete from [SIFMES].dbo.[ContentPack]
delete from [SIFMES].dbo.[ContentSimple]
delete from [SIFMES].dbo.[Order]

delete from [SIFMES].dbo.[OrderLocal]
delete from [SIFMES].dbo.[DetailContentSimpleOrderLocal]
delete from [SIFMES].dbo.[DetailContentPackOrderLocal]
delete from [SIFMES].dbo.DetailStateCellOfSimpleWareHouse

