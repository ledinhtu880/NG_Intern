using NganGiang.Libs;
using NganGiang.Models;
using System.Data;
using System.Data.SqlClient;
using System.Windows.Forms;

namespace NganGiang.Services.Process
{
    public class ProcessService401
    {
        public void listMakeContent(DataGridView dgv)
        {
            try
            {
                string query = @"SELECT FK_Id_OrderLocal AS id_orderlocal, Id_ContentSimple AS id_simple, Name_RawMaterial AS name_raw, RawMaterial.Count AS quantity, (SELECT Count FROM RawMaterial WHERE Id_RawMaterial = 0) AS quantity_container, (select Count from RawMaterial where Id_RawMaterial = 1) AS quantity_pedestal, Unit AS unit, Count_Container AS quantity_order, Name_State AS status, CONVERT(date, ProcessContentSimple.Date_Start) AS date_start, SimpleOrPack AS type_simple, FK_Id_RawMaterial, FK_Id_ContainerType
                    FROM ProcessContentSimple
                    INNER JOIN ContentSimple ON Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple
                    INNER JOIN DetailContentSimpleOrderLocal ON Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple
                    INNER JOIN RawMaterial ON Id_RawMaterial = FK_Id_RawMaterial
                    INNER JOIN [State] ON [State].Id_State = FK_Id_State
                    INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal
                    WHERE FK_Id_Station = 401 and FK_Id_State != 2 AND OrderLocal.MakeOrPackOrExpedition = 0 
                    ORDER BY id_orderlocal ASC, id_simple ASC, date_start DESC";
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
                    Name = "id_orderlocal",
                    HeaderText = "Mã đơn hàng",
                    DataPropertyName = "id_orderlocal",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column2 = new()
                {
                    Name = "type_simple",
                    HeaderText = "Loại hàng",
                    DataPropertyName = "type_simple",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column3 = new()
                {
                    Name = "id_simple",
                    HeaderText = "Mã thùng hàng",
                    DataPropertyName = "id_simple",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column4 = new()
                {
                    Name = "name_raw",
                    HeaderText = "Tên nguyên liệu",
                    DataPropertyName = "name_raw",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column5 = new()
                {
                    Name = "quantity",
                    HeaderText = "Số lượng nguyên liệu tồn",
                    DataPropertyName = "quantity",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill,
                };

                DataGridViewTextBoxColumn column6 = new()
                {
                    Name = "quantity_container",
                    HeaderText = "Số lượng thùng chứa tồn",
                    DataPropertyName = "quantity_container",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill,
                };

                DataGridViewTextBoxColumn column7 = new()
                {
                    Name = "quantity_pedestal",
                    HeaderText = "Số lượng đế thùng tồn",
                    DataPropertyName = "quantity_pedestal",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill,
                };

                DataGridViewTextBoxColumn column8 = new()
                {
                    Name = "quantity_order",
                    HeaderText = "Số lượng cần",
                    DataPropertyName = "quantity_order",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column9 = new()
                {
                    Name = "Unit",
                    HeaderText = "Đơn vị",
                    DataPropertyName = "Unit",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column10 = new()
                {
                    Name = "status",
                    HeaderText = "Trạng thái",
                    DataPropertyName = "status",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column11 = new()
                {
                    Name = "date_start",
                    HeaderText = "Ngày bắt đầu",
                    DataPropertyName = "date_start",
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                    AutoSizeMode = DataGridViewAutoSizeColumnMode.AllCells,
                };

                DataGridViewTextBoxColumn column12 = new()
                {
                    Name = "FK_Id_RawMaterial",
                    DataPropertyName = "FK_Id_RawMaterial",
                    Visible = false,
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false
                };

                DataGridViewTextBoxColumn column13 = new()
                {
                    Name = "FK_Id_ContainerType",
                    DataPropertyName = "FK_Id_ContainerType",
                    Visible = false,
                    SortMode = DataGridViewColumnSortMode.NotSortable,
                    Frozen = false,
                };

                dgv.Columns.AddRange(column, column1, column2, column3, column4, column5, column6, column7, column8, column9, column10, column11, column12, column13);

                // Adjust the DataGridView column headers and rows
                dgv.ColumnHeadersHeight = 60;
                dgv.RowTemplate.Height = 35;
                dgv.DataSource = dt;
            }
            catch (Exception e)
            {
                MessageBox.Show(e.Message, $"Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public int getQuantityContentSimple(int id_content_simple)
        {
            string query = $"select Count_Container * Count_RawMaterial as quantity_simple from ContentSimple where Id_ContentSimple = {id_content_simple}";

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

        public bool checkQuantityContainer(int id_content_simple)
        {
            int quantityContainer = getQuantityContainerRaw();
            int quantityRawSimple = getQuantityContentSimple(id_content_simple);

            if (quantityRawSimple > quantityContainer)
            {
                return false;
            }
            return true;
        }

        public bool checkQuantityPedestal(int id_content_simple)
        {
            int quantityPedestal = getQuantityPedestalRaw();
            int quantityRawSimple = getQuantityContentSimple(id_content_simple);

            if (quantityRawSimple > quantityPedestal)
            {
                return false;
            }
            return true;
        }

        public void UpdateContainerProvided(int id_content_simple)
        {
            try
            {
                string query = $"Update ContentSimple set ContainerProvided = 1 where Id_ContentSimple = {id_content_simple}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public void UpdatePedestalProvided(int id_content_simple)
        {
            try
            {
                string query = $"Update ContentSimple set PedestalProvided = 1 where Id_ContentSimple = {id_content_simple}";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public static byte[] GenerateRandomBytes(int length)
        {
            byte[] randomBytes = new byte[length];
            using (var rng = new System.Security.Cryptography.RNGCryptoServiceProvider())
            {
                rng.GetBytes(randomBytes);
            }
            return randomBytes;
        }

        private int FindNextStation(int id_content_simple)
        {
            string query = $"SELECT FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine\r\n\t\t\t\t\t\t\t\t\t\tinner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal \r\nWHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal where FK_Id_ContentSimple = {id_content_simple})";
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

        public void UpdateRFIDProvided(int id_content_simple, byte[] rfidBytes)
        {
            try
            {
                string query = $"Update ContentSimple set RFIDProvided = 1, RFID = @rfid where Id_ContentSimple = @id_simple";
                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@id_simple", id_content_simple),
                    new SqlParameter("@rfid", rfidBytes)
                };
                DataProvider.Instance.ExecuteNonQuery(query, parameters);

                query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_Fin = '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' where FK_Id_ContentSimple = {id_content_simple}";
                DataProvider.Instance.ExecuteNonQuery(query);

                int station = FindNextStation(id_content_simple);
                query = $"insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values({id_content_simple}, {station}, 0, '{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}')";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo1", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateQuantityContainer(int quantityConsumed)
        {
            try
            {
                string query = $"Update RawMaterial set Count = Count - {quantityConsumed} where Id_RawMaterial = 0";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateQuantityPedestal(int quantityConsumed)
        {
            try
            {
                string query = $"Update RawMaterial set Count = Count - {quantityConsumed} where Id_RawMaterial = 1";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
