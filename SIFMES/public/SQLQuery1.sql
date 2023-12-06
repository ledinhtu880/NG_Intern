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

select * from ProductionStationLine
select * from Station
select * from DetailProductionStationLine
select * from ProductionStationLine
select * from ProcessContentSimple
select * from DispatcherOrder

select O.Id_OrderLocal as N'Mã đơn hàng', P.FK_Id_ContentSimple as N'Mã thùng hàng', O.SimpleOrPack as N'Kiểu hàng', S.Name_State as N'Trạng thái', P.Data_Start as N'Ngày bắt đầu', P.Data_Fin as N'Ngày kết thúc'
from OrderLocal O
    inner join DetailContentSimpleOrderLocal D on O.Id_OrderLocal = D.FK_Id_OrderLocal
    inner join ProcessContentSimple P on P.FK_Id_ContentSimple = D.FK_Id_ContentSimple
	inner join State S on S.Id_State = P.FK_Id_State 
	where P.FK_Id_Station = 403 and	P.FK_Id_State = 0

SELECT DP.* from DetailProductionStationLine DP
    inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine
    inner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal 
    inner join DetailContentSimpleOrderLocal DSO on O.Id_OrderLocal = DSO.FK_Id_OrderLocal
    where Id_OrderLocal = 1
    group by DP.FK_Id_Station, DP.FK_Id_ProdStationLine

    select * from ProcessContentSimple
    select * from DispatcherOrder
    update DispatcherOrder set FK_Id_ProdStationLine = 3 where FK_Id_OrderLocal = 2

select * from RawMaterial
select * from ContentSimple
select * from ProcessContentSimple

    update RawMaterial set Count = 500
update ProcessContentSimple  set FK_ID_Station = 403,  FK_ID_State = 0
