using NganGiang.Libs;
using System.Data;
using System.Data.SqlClient;
using System.Text;

namespace NganGiang.Services.Process
{
    internal class ProcessService407
    {
        public void listProcessSimpleOrderLocal(DataGridView dgv)
        {
            try
            {
                string query = @"SELECT FK_Id_OrderLocal AS Id_OrderLocal, Id_ContentSimple AS Id_Simple, Name_RawMaterial AS Name_Raw,
	                                RawMaterial.Count AS Quantity, Unit AS unit, Count_RawMaterial * Count_Container AS Quantity_Order,
	                                Name_State AS Status, ProcessContentSimple.Date_Start AS Date_Start, SimpleOrPack AS Type_Simple 
                                FROM ProcessContentSimple 
                                INNER JOIN ContentSimple ON Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple
                                INNER JOIN DetailContentSimpleOrderLocal ON Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple
                                INNER JOIN RawMaterial ON Id_RawMaterial = FK_Id_RawMaterial
                                INNER JOIN [State] ON Id_State = FK_Id_State
                                INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal
                                WHERE FK_Id_Station = 407 and FK_Id_State <> 2 AND OrderLocal.MakeOrPackOrExpedition = 2 
                                ORDER BY Date_Start DESC";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);

                dgv.AutoGenerateColumns = false;

                DataGridViewCheckBoxColumn column = new()
                {
                    HeaderText = "",
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column1 = new()
                {
                    Name = "Id_OrderLocal",
                    HeaderText = "Mã đơn hàng",
                    DataPropertyName = "Id_OrderLocal",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,

                };

                DataGridViewTextBoxColumn column2 = new()
                {
                    Name = "Type_Simple",
                    HeaderText = "Loại hàng",
                    DataPropertyName = "Type_Simple",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column3 = new()
                {
                    Name = "Id_Simple",
                    HeaderText = "Mã thùng hàng",
                    DataPropertyName = "Id_Simple",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column4 = new()
                {
                    Name = "Name_Raw",
                    HeaderText = "Tên nguyên liệu",
                    DataPropertyName = "Name_Raw",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column5 = new()
                {
                    Name = "Quantity",
                    HeaderText = "Số lượng nguyên liệu tồn",
                    DataPropertyName = "Quantity",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill,

                };

                DataGridViewTextBoxColumn column6 = new()
                {
                    Name = "Quantity_Order",
                    HeaderText = "Số lượng nguyên liệu cần",
                    DataPropertyName = "Quantity_Order",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill,

                };

                DataGridViewTextBoxColumn column7 = new()
                {
                    Name = "Unit",
                    HeaderText = "Đơn vị",
                    DataPropertyName = "Unit",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,

                };

                DataGridViewTextBoxColumn column8 = new()
                {
                    Name = "Status",
                    HeaderText = "Trạng thái",
                    DataPropertyName = "Status",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column9 = new()
                {
                    Name = "Date_Start",
                    HeaderText = "Ngày bắt đầu",
                    DataPropertyName = "Date_Start",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };


                dgv.Columns.AddRange(column, column1, column2, column3, column4, column5, column6, column7, column8, column9);
                dgv.ColumnHeadersHeight = 60;
                dgv.RowTemplate.Height = 35;
                dgv.DataSource = dt;
            }

            catch (Exception e)
            {
                MessageBox.Show("Đã có lỗi xảy ra!" + $"{e.Message}", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public bool IsLastStation(int id_content_simple)
        {
            string query = @$"SELECT FK_Id_Station FROM DetailProductionStationLine DP 
                            INNER JOIN DispatcherOrder D ON DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine 
                            INNER JOIN OrderLocal O ON O.Id_OrderLocal = D.FK_Id_OrderLocal 
                            WHERE FK_Id_OrderLocal = (SELECT FK_Id_OrderLocal FROM DetailContentSimpleOrderLocal, OrderLocal 
                                                    WHERE FK_Id_ContentSimple = {id_content_simple} AND OrderLocal.Id_OrderLocal = DetailContentSimpleOrderLocal.FK_Id_OrderLocal 
                                                    AND OrderLocal.MakeOrPackOrExpedition = 2) AND FK_Id_Station > 407";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            if (dt.Rows.Count > 0)
            {
                return false;
            }
            return true;
        }
        public int checkCustomer(int id)
        {
            try
            {
                string query = $"SELECT CustomerType.ID " +
                    $"FROM ContentSimple " +
                    $"JOIN [Order] ON ContentSimple.FK_Id_Order = [Order].Id_Order " +
                    $"JOIN Customer ON [Order].FK_Id_Customer = Customer.Id_Customer " +
                    $"JOIN CustomerType ON Customer.FK_Id_CustomerType = CustomerType.Id " +
                    $"WHERE ContentSimple.Id_ContentSimple= {id}";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows.Count > 0 && result.Rows[0]["ID"] != DBNull.Value)
                {
                    // Lấy giá trị trạm tiếp theo từ kết quả
                    int customerType = Convert.ToInt32(result.Rows[0]["ID"]);
                    return customerType;
                }
                else
                {
                    // Không có kết quả trả về
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy kiểu khách hàng.\n" + ex.Message);
                return -1;
            }
        }
        public int getCountInRegister(int id_content_simple)
        {
            string query = $"select sum(Count) as countTotal from RegisterContentSimpleAtWareHouse where FK_Id_ContentSimple = {id_content_simple} group by FK_Id_ContentSimple";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int count = 0;
            if (dt.Rows.Count > 0)
            {
                count = Convert.ToInt32(dt.Rows[0][0]);
                return count;
            }
            return 0;
        }

        public bool IsOutOfStockContainer(int id_content_simple)
        {
            int countRegister = getCountInRegister(id_content_simple);
            string query = $"select Count_Container - {countRegister} from ContentSimple where Id_ContentSimple = {id_content_simple}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            if (dt.Rows.Count > 0)
            {
                int countLeft = Convert.ToInt32(dt.Rows[0][0]);
                if (countLeft > 0)
                {
                    return false;
                }
            }
            return true;
        }

        public byte[] GenerateQrCode(int id_content_simple)
        {
            string qrText = $"Thùng hàng số {id_content_simple}";

            byte[] binaryData = Encoding.UTF8.GetBytes(qrText);

            return binaryData;
        }

        public void FreeCellDetail(int id_content_simple)
        {
            try
            {
                string query = $"Update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_ContentSimple = NULL where FK_Id_Station = 406 and FK_Id_ContentSimple = {id_content_simple}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateQrCodeAndState(int id_content_simple)
        {
            try
            {
                byte[] qrcode = GenerateQrCode(id_content_simple);
                string query = "Update ContentSimple set QRCode = @qr, QRCodeProvided = 1 where Id_ContentSimple = @id_simple";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_content_simple),
                    new SqlParameter("@qr", qrcode)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                query = $"Update ProcessContentSimple set FK_Id_State = 1 where FK_Id_ContentSimple = {id_content_simple} AND FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateAndInsertProcessSimple(int id_content_simple)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentSimple = {id_content_simple} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = "insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values(@id_content, @station, @state, @date_start)";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_content", id_content_simple),
                    new SqlParameter("@station", 408),
                    new SqlParameter("@state", 0),
                    new SqlParameter("@date_start", date)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                byte[] qrcode = GenerateQrCode(id_content_simple);
                query = "Update ContentSimple set QRCode = @qr, QRCodeProvided = 1 where Id_ContentSimple = @id_simple";
                parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_content_simple),
                    new SqlParameter("@qr", qrcode)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private List<int> contentPack = new List<int>();
        public void GetContentPack(int id_content_simple)
        {
            contentPack.Clear();
            try
            {
                string query = $"select Id_ContentPack from ContentPack P join DetailContentSimpleOfPack DP on P.Id_ContentPack = DP.FK_Id_ContentPack where DP.FK_Id_ContentSimple = {id_content_simple}";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);
                if (dt.Rows.Count > 0)
                {
                    foreach (DataRow dr in dt.Rows)
                    {
                        contentPack.Add(Convert.ToInt32(dr[0]));
                    }
                }
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateAndInsertProcessPack(int id_content_simple)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query/* = $"Update ProcessContentPack set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentPack = {id_content_simple} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query)*/;

                foreach (var item in contentPack)
                {
                    query = "insert into ProcessContentPack(FK_Id_ContentPack, FK_Id_Station, FK_Id_State, Date_Start) values (@id_pack, @station, @state, @date_start)";
                    SqlParameter[] parameters = new SqlParameter[]
                    {
                        new SqlParameter("@id_pack", item),
                        new SqlParameter("@station", 408),
                        new SqlParameter("@state", 0),
                        new SqlParameter("@date_start", date)
                    };
                    DataProvider.Instance.ExecuteNonQuery(query, parameters);
                }
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateProcessAndOrder(int id_content_simple)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentSimple = {id_content_simple} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = $"SELECT * FROM ContentSimple WHERE Id_ContentSimple = {id_content_simple} AND QRCode IS NULL";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);
                if (dt.Rows.Count == 0)
                {
                    query = $"UPDATE OrderLocal set Date_Fin = '{date}' FROM DetailContentSimpleOrderLocal D JOIN OrderLocal O ON D.FK_Id_OrderLocal = O.Id_OrderLocal WHERE D.FK_Id_ContentSimple = {id_content_simple}";
                    DataProvider.Instance.ExecuteNonQuery(query);

                    query = $"UPDATE dbo.[Order] SET Date_Delivery = '{date}' FROM ContentSimple C join dbo.[Order] O on C.FK_Id_Order = O.Id_Order WHERE C.Id_ContentSimple = {id_content_simple}";
                    DataProvider.Instance.ExecuteNonQuery(query);
                }
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
