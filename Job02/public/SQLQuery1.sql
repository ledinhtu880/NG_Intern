use NG_Job02

insert into Customer (Id_Customer, Name_Customer, Name_Contact, Email, Phone, Address, ZipCode, FK_Id_Mode_Transport, Time_Reception) values
(1, N'Nội bộ - Lưu kho (Lê Đình Tú)', N'Tus', 'ldt907@gmail.com', '0865176605', N'Đồng Nhân, Hai Bà Trưng, Hà Nội', '11608', '0', N'09/07/2023'),
(2, N'Trương Mỹ Hoa', N'Mic', 'tmh307@gmail.com', '0832498756', N'Lò Đúc, Hai Bà Trưng, Hà Nội', '11609', '1', N'03/07/2022'),
(3, N'Nguyễn Hải Tùng', N'Tũn', 'nht3107@gmail.com', '0938591792', N'Trần Khát Chân, Hai Bà Trưng, Hà Nội', '11623', '2', N'31/07/2023'),
(4, N'Hoàng Thanh Thủy', N'Tthuy', 'htt1412@gmail.com', '0393056789', N'Hương Viên, Hai Bà Trưng, Hà Nội', '11608', '3', N'14/12/2022'),
(5, N'Trần Công Thành', N'TTran', 'tct@gmail.com', '0912087956', N'Kim Ngưu, Hai Bà Trưng, Hà Nội', '11623', '3', N'04/08/2023');

select * from [NG_Job02].dbo.[DetailContentSimpleOfPack]
select * from [NG_Job02].dbo.[ContentPack]
select * from [NG_Job02].dbo.[ContentSimple]
select * from [NG_Job02].dbo.[Order]
select * from [NG_Job02].dbo.[Customer]
select * from [NG_Job02].dbo.[RawMaterial]
select * from [NG_Job02].dbo.ProductionStationLine

delete from [NG_Job02].dbo.[DetailContentSimpleOfPack] where FK_Id_PackContent = 1
delete from [NG_Job02].dbo.[ContentSimple] where FK_Id_Order = 9
delete from [NG_Job02].dbo.[ContentPack] where FK_Id_Order = 9
delete from [NG_Job02].dbo.[Order] where Id_Order = 9

select Id_SimpleContent from ContentSimple where FK_Id_Order = 5

select FK_Id_Customer,Date_Order, Date_Dilivery, Date_Reception, Note
from [NG_Job02].dbo.[Order]
where Id_Order = 10

select Id_PackContent, Count_Pack, Price_Pack
from [NG_Job02].dbo.[ContentPack]
where FK_Id_Order = 10
