use NG_Job02

insert into RawMaterialType (Name_RawMaterialType) values
(N'Phụ kiện'), (N'Chất rắn'), (N'Chất lỏng');

insert into RawMaterial (Name_RawMaterial, Unit, Count, FK_Id_RawMaterialType) values
(N'Thùng chứa', N'cái', 300, 1),
(N'Đế thùng chứa', N'cái', 300, 1),
(N'Nắp đậy', N'cái', 300, 1),
(N'Hạt xanh', N'g (Gam)', 300, 2);

insert into ModeTransport (Name_ModeTransport) values
(N'Đường Bộ'),
(N'Đường Thủy'),
(N'Đường Sắt'),
(N'Đường không');

insert into Customer (Name_Customer, Name_Contact, Email, Phone, Address, ZipCode, FK_Id_Mode_Transport, Time_Reception) values
(N'Lê Đình Tú', N'Tus', 'ldt907@gmail.com', '0865176605', N'Đồng Nhân, Hai Bà Trưng, Hà Nội', '11608', '1', N'09/07/2023'),
(N'Trương Mỹ Hoa', N'Mic', 'tmh307@gmail.com', '0832498756', N'Lò Đúc, Hai Bà Trưng, Hà Nội', '11609', '2', N'03/07/2022'),
(N'Nguyễn Hải Tùng', N'Tũn', 'nht3107@gmail.com', '0938591792', N'Trần Khát Chân, Hai Bà Trưng, Hà Nội', '11623', '2', N'31/07/2023'),
(N'Hoàng Thanh Thủy', N'Tthuy', 'htt1412@gmail.com', '0393056789', N'Hương Viên, Hai Bà Trưng, Hà Nội', '11608', '3', N'14/12/2022'),
(N'Trần Công Thành', N'TTran', 'tct@gmail.com', '0912087956', N'Kim Ngưu, Hai Bà Trưng, Hà Nội', '11623', '4', N'04/08/2023');

insert into OrderType (Name_OrderType, IsOrderInSystem) values
('ToCustomer', 0),
('ToWareHouse', 0),
('MTO', 1),
('MTS', 1),
('EXP', 1);

insert into ContainerType (Name_ContainerType) values
(N'Hộp vuông'), (N'Hộp tròn');

select * from ContainerType
select * from DetailContentSimpleOfPack
select * from DetailStateCellOfPackWareHouse
select * from DetailStateCellOfSimpleWareHouse
select * from ContentSimple
select * from ContentPack
select * from [NG_Job02].[dbo].[Order]
select * from Customer
select * from RawMaterialType

