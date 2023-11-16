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

INSERT INTO StationType (Id_StationType, Name_StationType, Description, PathImage)
VALUES
('401', N'Trạm cấp thùng chứa và để có mã RFID bằng robot', 'SIF-401', 'C:\\SIFMES\\Station\\401.jpg'),
('402', N'Trạm rót nguyên liệu rắn vào thùng chứa và nén chặt', 'SIF-402' , 'C:\\SIFMES\\Station\\402.jpg'),
('403', N'Trạm rót nguyên liệu lỏng', 'SIF-403' , 'C:\\SIFMES\\Station\\403.jpg'),
('404', N'Trạm rót tiếp nguyên liệu thứ 2 vào thùng chứa', 'SIF-404' , 'C:\\SIFMES\\Station\\404.jpg'),
('405', N'Đậy nắp bằng robot giám sát bằng camera', 'SIF-405' , 'C:\\SIFMES\\Station\\405.jpg'),
('406', N'Kho thùng chứa', 'SIF-406' , 'C:\\SIFMES\\Station\\406.jpg'),
('407', N'Cảng dãn nhãn thùng chứa và gửi đến khách hàng', 'SIF-407' , 'C:\\SIFMES\\Station\\407.jpg'),
('408', N'Xếp chồng các thùng chứa bằng robot để chuẩn bị đóng gói', 'SIF-408' , 'C:\\SIFMES\\Station\\408.jpg'),
('409', N'Kho thùng chứa xếp chồng', 'SIF-409' , 'C:\\SIFMES\\Station\\409.jpg'),
('410', N'Đóng gói thùng chứa xếp chồng bằng cách quần màng bọc PE', 'SIF-410' , 'C:\\SIFMES\\Station\\410.jpg'),
('411', N'Cấp và dẫn nhãn NFC cho các gói thùng chứa, mã NFC được quản lý', 'SIF-411' , 'C:\\SIFMES\\Station\\411.jpg'),
('412', N'Cảng gửi các gói đến khách hàng', 'SIF-412' , 'C:\\SIFMES\\Station\\412.jpg');

INSERT INTO Station (Name_Station, Ip_Address, FK_Id_StationType) VALUES
('SIF-401', '192.168.1.6', '401'),
('SIF-402', '192.168.1.7', '402'),
('SIF-403', '192.168.1.8', '403'),
('SIF-404', '192.168.1.9', '404'),
('SIF-405', '192.168.1.10', '405'),
('SIF-406', '192.168.1.11', '406'),
('SIF-407', '192.168.1.12', '407'),
('SIF-408', '192.168.1.13', '408'),
('SIF-409', '192.168.1.14', '409'),
('SIF-410', '192.168.1.15', '410'),
('SIF-411', '192.168.1.16', '411'),
('SIF-412', '192.168.1.17', '412');

select * from [NG_Job02].dbo.[order]
select * from [NG_Job02].dbo.[ContentSimple]
select * from [NG_Job02].dbo.[ContainerType]
select FK_ID_ContainerType from [ContentSimple]
