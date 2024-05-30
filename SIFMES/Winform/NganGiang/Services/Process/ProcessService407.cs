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
                string query = "SELECT FK_Id_OrderLocal as id_orderlocal, Id_ContentSimple as id_simple, Name_RawMaterial as name_raw, RawMaterial.Count as quantity, \r\n\t\tUnit as unit, Count_RawMaterial * Count_Container as quantity_order, Name_State as status, ProcessContentSimple.Date_Start as date_start, SimpleOrPack as type_simple FROM ProcessContentSimple \r\nINNER JOIN ContentSimple on Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple\r\nINNER JOIN DetailContentSimpleOrderLocal on Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN [State] on Id_State = FK_Id_State\r\nINNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal\r\nWHERE FK_Id_Station = 407 and FK_Id_State = 0 AND OrderLocal.MakeOrPackOrExpedition = 2 order by date_start desc";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);

                dgv.AutoGenerateColumns = false;

                DataGridViewCheckBoxColumn column = new()
                {
                    HeaderText = "",
                    FillWeight = 10,
                };

                DataGridViewTextBoxColumn column1 = new()
                {
                    HeaderText = "Mã đơn hàng",
                    DataPropertyName = "id_orderlocal",
                    FillWeight = 80,

                };

                DataGridViewTextBoxColumn column2 = new()
                {
                    HeaderText = "Loại hàng",
                    DataPropertyName = "type_simple",
                    FillWeight = 80,
                };

                DataGridViewTextBoxColumn column3 = new()
                {
                    HeaderText = "Mã thùng hàng",
                    DataPropertyName = "id_simple",
                    FillWeight = 80
                };

                DataGridViewTextBoxColumn column4 = new()
                {
                    HeaderText = "Tên nguyên liệu thô",
                    DataPropertyName = "name_raw"
                };

                DataGridViewTextBoxColumn column5 = new()
                {
                    HeaderText = "Số lượng nguyên liệu tồn",
                    DataPropertyName = "quantity",
                    FillWeight = 80

                };

                DataGridViewTextBoxColumn column6 = new()
                {
                    HeaderText = "Số lượng nguyên liệu cần",
                    DataPropertyName = "quantity_order",
                    FillWeight = 80,

                };

                DataGridViewTextBoxColumn column7 = new()
                {
                    HeaderText = "Đơn vị",
                    DataPropertyName = "Unit",
                    FillWeight = 50,

                };

                DataGridViewTextBoxColumn column8 = new()
                {
                    HeaderText = "Trạng thái",
                    DataPropertyName = "status"
                };

                DataGridViewTextBoxColumn column9 = new()
                {
                    HeaderText = "Ngày bắt đầu",
                    DataPropertyName = "date_start"
                };


                dgv.Columns.AddRange(column, column1, column2, column3, column4, column5, column6, column7, column8, column9);
                dgv.ColumnHeadersHeight = 70;
                dgv.RowTemplate.Height = 35;
                dgv.DataSource = dt;
            }

            catch (Exception e)
            {
                MessageBox.Show("Đã có lỗi xảy ra!" + $"{e.Message}", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public bool IsLastStation(int id_simple_content)
        {
            string query = $"SELECT FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine inner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal WHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal, OrderLocal \r\nwhere FK_Id_ContentSimple = {id_simple_content} and OrderLocal.Id_OrderLocal = DetailContentSimpleOrderLocal.FK_Id_OrderLocal and OrderLocal.MakeOrPackOrExpedition = 2) and FK_Id_Station > 407";
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
        public int getCountInRegister(int id_simple_content)
        {
            string query = $"select sum(Count) as countTotal from RegisterContentSimpleAtWareHouse where FK_Id_ContentSimple = {id_simple_content} group by FK_Id_ContentSimple";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int count = 0;
            if (dt.Rows.Count > 0)
            {
                count = Convert.ToInt32(dt.Rows[0][0]);
                return count;
            }
            return 0;
        }

        public bool IsOutOfStockContainer(int id_simple_content)
        {
            int countRegister = getCountInRegister(id_simple_content);
            string query = $"select Count_Container - {countRegister} from ContentSimple where Id_ContentSimple = {id_simple_content}";
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

        public byte[] GenerateQrCode(int id_simple_content)
        {
            string qrText = $"Thùng hàng số {id_simple_content}";

            byte[] binaryData = Encoding.UTF8.GetBytes(qrText);

            return binaryData;
        }

        public void FreeCellDetail(int id_simple_content)
        {
            try
            {
                string query = $"Update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_ContentSimple = NULL where FK_Id_Station = 406 and FK_Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateQrCodeAndState(int id_simple_content)
        {
            try
            {
                byte[] qrcode = GenerateQrCode(id_simple_content);
                string query = "Update ContentSimple set QRCode = @qr, QRCodeProvided = 1 where Id_ContentSimple = @id_simple";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_simple_content),
                    new SqlParameter("@qr", qrcode)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                query = $"Update ProcessContentSimple set FK_Id_State = 1 where FK_Id_ContentSimple = {id_simple_content} AND FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateAndInsertProcessSimple(int id_simple_content)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentSimple = {id_simple_content} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = "insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values(@id_content, @station, @state, @date_start)";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_content", id_simple_content),
                    new SqlParameter("@station", 408),
                    new SqlParameter("@state", 0),
                    new SqlParameter("@date_start", date)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                byte[] qrcode = GenerateQrCode(id_simple_content);
                query = "Update ContentSimple set QRCode = @qr, QRCodeProvided = 1 where Id_ContentSimple = @id_simple";
                parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_simple_content),
                    new SqlParameter("@qr", qrcode)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private List<int> contentPack = new List<int>();
        public void GetContentPack(int id_simple_content)
        {
            contentPack.Clear();
            try
            {
                string query = $"select Id_ContentPack from ContentPack P join DetailContentSimpleOfPack DP on P.Id_ContentPack = DP.FK_Id_ContentPack where DP.FK_Id_ContentSimple = {id_simple_content}";
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
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateAndInsertProcessPack(int id_simple_content)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"Update ProcessContentPack set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentPack = {id_simple_content} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);

                foreach (var item in contentPack)
                {
                    query = "insert into ProcessContentPack(FK_Id_ContentPack, FK_Id_Station, FK_Id_State, Date_Start) values(@id_pack, @station, @state, @date_start)";
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
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdateProcessAndOrder(int id_simple_content)
        {
            try
            {
                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                string query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_fin = '{date}' where FK_Id_ContentSimple = {id_simple_content} and FK_Id_Station = 407";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = $"UPDATE OrderLocal set Date_Fin = '{date}' FROM DetailContentSimpleOrderLocal D JOIN OrderLocal O ON D.FK_Id_OrderLocal = O.Id_OrderLocal WHERE D.FK_Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = $"UPDATE dbo.[Order] SET Date_Delivery = '{date}' FROM ContentSimple C join dbo.[Order] O on C.FK_Id_Order = O.Id_Order WHERE C.Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
