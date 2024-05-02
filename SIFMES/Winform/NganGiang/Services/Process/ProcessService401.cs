using NganGiang.Libs;
using System.Data;
using System.Data.SqlClient;

namespace NganGiang.Services.Process
{
    public class ProcessService401
    {
        public void listMakeContent(DataGridView dgv)
        {
            try
            {
                string query = "SELECT FK_Id_OrderLocal as id_orderlocal, Id_ContentSimple as id_simple, Name_RawMaterial as name_raw, RawMaterial.Count as quantity, \r\n\t\tUnit as unit, Count_RawMaterial * Count_Container as quantity_order, Name_State as status, ProcessContentSimple.Date_Start as date_start, SimpleOrPack as type_simple FROM ProcessContentSimple \r\nINNER JOIN ContentSimple on Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple\r\nINNER JOIN DetailContentSimpleOrderLocal on Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN [State] on Id_State = FK_Id_State\r\nINNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal\r\nWHERE FK_Id_Station = 401 and FK_Id_State = 0 AND OrderLocal.MakeOrPackOrExpedition = 0 order by id_orderlocal asc, id_simple asc, date_start desc";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);

                dgv.AutoGenerateColumns = false;

                DataGridViewCheckBoxColumn column = new()
                {
                    HeaderText = "",
                    FillWeight = 10
                };

                DataGridViewTextBoxColumn column1 = new()
                {
                    HeaderText = "Mã đơn hàng",
                    DataPropertyName = "id_orderlocal",
                    FillWeight = 80,
                };

                DataGridViewTextBoxColumn column2 = new()
                {
                    HeaderText = "Kiểu hàng",
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
                    HeaderText = "Số lượng tồn",
                    DataPropertyName = "quantity",
                    FillWeight = 70

                };

                DataGridViewTextBoxColumn column6 = new()
                {
                    HeaderText = "Số lượng cần",
                    DataPropertyName = "quantity_order",
                    FillWeight = 70,

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
                dgv.ColumnHeadersHeight = 60;
                dgv.RowTemplate.Height = 35;
                dgv.DataSource = dt;
            }

            catch (Exception e)
            {
                MessageBox.Show("Đã có lỗi xảy ra!", $"{e.Message}", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public int getQuantityContentSimple(int id_simple_content)
        {
            string query = $"select Count_Container * Count_RawMaterial as quantity_simple from ContentSimple where Id_ContentSimple = {id_simple_content}";

            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int quantity = 0;
            if (dt.Rows.Count > 0)
            {
                quantity = Convert.ToInt32(dt.Rows[0][0]);
            }
            return quantity;
        }

        public int getQuantityContainerRaw()
        {
            string query = "select Count from RawMaterial where Id_RawMaterial = 0";

            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int quantity_raw = 0;
            if (dt.Rows.Count > 0)
            {
                quantity_raw = Convert.ToInt32(dt.Rows[0][0]);
            }
            return quantity_raw;
        }

        public int getQuantityPedestalRaw()
        {
            string query = "select Count from RawMaterial where Id_RawMaterial = 1";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int quantity_raw = 0;
            if (dt.Rows.Count > 0)
            {
                quantity_raw = Convert.ToInt32(dt.Rows[0][0]);
            }
            return quantity_raw; ;
        }

        public bool checkQuantity(int id_simple_content)
        {
            int quantityContainer_raw = getQuantityContainerRaw();
            int quantityPedestal_raw = getQuantityPedestalRaw();
            int quantity_raw_simple = getQuantityContentSimple(id_simple_content);

            if (quantity_raw_simple > quantityContainer_raw || quantity_raw_simple > quantityPedestal_raw)
            {
                return false;
            }
            return true;
        }

        public void UpdateContainerProvided(int id_simple_content)
        {
            try
            {
                string query = $"Update ContentSimple set ContainerProvided = 1 where Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdatePesdestalProvided(int id_simple_content)
        {
            try
            {
                string query = $"Update ContentSimple set PedestalProvided = 1 where Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private static byte[] GenerateRandomBytes(int length)
        {
            byte[] randomBytes = new byte[length];
            using (var rng = new System.Security.Cryptography.RNGCryptoServiceProvider())
            {
                rng.GetBytes(randomBytes);
            }
            return randomBytes;
        }

        private int FindNextStation(int id_simple_content)
        {
            string query = $"SELECT FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine\r\n\t\t\t\t\t\t\t\t\t\tinner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal \r\nWHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal where FK_Id_ContentSimple = {id_simple_content})";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            List<int> station = new List<int>();
            if (dt.Rows.Count > 0)
            {
                foreach (DataRow dr in dt.Rows)
                {
                    station.Add(Convert.ToInt32(dr[0]));
                }
            }
            if (station.Contains(402))
            {
                return 402;
            }
            else
            {
                return 403;
            }
        }

        public void UpdateRFIDProvided(int id_simple_content)
        {
            try
            {
                byte[] rfidBytes = GenerateRandomBytes(16);
                string query = $"Update ContentSimple set RFIDProvided = 1, RFID = @rfid where Id_ContentSimple = @id_simple";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_simple_content),
                    new SqlParameter("@rfid", rfidBytes)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_Fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' where FK_Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);

                int station = FindNextStation(id_simple_content);
                query = $"insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values({id_simple_content}, {station}, 0, '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}')";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
