using NganGiang.Models;
using System.Data;
using System.Data.SqlClient;

namespace NganGiang.Services.Process
{
    public class ProcessService401
    {
        private DatabaseService dbserve { get; set; }
        public ProcessService401()
        {
            dbserve = new DatabaseService();
        }

        public void listMakeContent(DataGridView dgv)
        {
            try
            {
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "SELECT FK_Id_OrderLocal as id_orderlocal, Id_SimpleContent as id_simple, Name_RawMaterial as name_raw, RawMaterial.Count as quantity, \r\n\t\tUnit as unit, Count_RawMaterial * Count_Container as quantity_order, Name_State as status, ProcessContentSimple.Data_Start as date_start, SimpleOrPack as type_simple FROM ProcessContentSimple \r\nINNER JOIN ContentSimple on Id_SimpleContent = ProcessContentSimple.FK_Id_ContentSimple\r\nINNER JOIN DetailContentSimpleOrderLocal on Id_SimpleContent = DetailContentSimpleOrderLocal.FK_Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN [State] on Id_State = FK_Id_State\r\nINNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal\r\nWHERE FK_Id_Station = 401 and FK_Id_State = 0 order by date_start desc";
                DataTable dt = new DataTable();
                using (var reader = dbserve.ExecuteCommand(cmd).CreateDataReader())
                {
                    dt.Load(reader);
                }

                dgv.AutoGenerateColumns = false;

                DataGridViewCheckBoxColumn column = new()
                {
                    HeaderText = "",
                    FillWeight = 50,
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
            var cmd = dbserve.SqlCommandText;
            cmd.CommandText = "select Count_Container * Count_RawMaterial as quantity_simple from ContentSimple where Id_SimpleContent = @id";
            cmd.Parameters.AddWithValue("id", id_simple_content);
            DataTable dt = dbserve.ExecuteCommand(cmd);
            int quantity = 0;
            if (dt.Rows.Count > 0)
            {
                quantity = Convert.ToInt32(dt.Rows[0][0]);
            }
            return quantity;
        }

        public bool checkQuantity(int id_simple_content)
        {
            var cmd = dbserve.SqlCommandText;
            cmd.CommandText = "select Count from RawMaterial where Id_RawMaterial = 2";
            DataTable dt = dbserve.ExecuteCommand(cmd);
            int quantity_raw = 0;
            int quantity_raw_simple = getQuantityContentSimple(id_simple_content);
            if (dt.Rows.Count > 0)
            {
                quantity_raw = Convert.ToInt32(dt.Rows[0][0]);
            }

            if (quantity_raw_simple > quantity_raw)
            {
                return false;
            }
            return true;
        }

        public void UpdateContainerProvided(int id_simple_content)
        {
            try
            {
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "update ProcessContentSimple set FK_Id_State = 1 where FK_Id_ContentSimple = @fk_id";
                cmd.Parameters.AddWithValue("fk_id", id_simple_content);
                dbserve.ExecuteCommand(cmd);

                cmd.CommandText = "Update ContentSimple set ContainerProvided = 1 where Id_SimpleContent = @id";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                dbserve.ExecuteCommand(cmd);

                int count = getQuantityContentSimple(id_simple_content);
                cmd.CommandText = "Update RawMaterial set Count = Count - @count_rawmaterial where Id_RawMaterial = 0";
                cmd.Parameters.AddWithValue("count_rawmaterial", count);
                dbserve.ExecuteCommand(cmd);
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
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ContentSimple set PedestalProvided = 1 where Id_SimpleContent = @fk_id";
                cmd.Parameters.AddWithValue("fk_id", id_simple_content);
                dbserve.ExecuteCommand(cmd);

                int count = getQuantityContentSimple(id_simple_content);
                cmd.CommandText = "Update RawMaterial set Count = Count - @count_rawmaterial where Id_RawMaterial = 1";
                cmd.Parameters.AddWithValue("count_rawmaterial", count);
                dbserve.ExecuteCommand(cmd);
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
            var cmd = dbserve.SqlCommandText;
            cmd.CommandText = "SELECT FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine\r\n\t\t\t\t\t\t\t\t\t\tinner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal \r\nWHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal where FK_Id_ContentSimple = @id)";
            cmd.Parameters.AddWithValue("id", id_simple_content);
            DataTable dt = dbserve.ExecuteCommand(cmd);
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
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ContentSimple set RFIDProvided = 1, RFID = @rfid where Id_SimpleContent = @fk_id";
                byte[] rfidBytes = GenerateRandomBytes(16);
                cmd.Parameters.AddWithValue("fk_id", id_simple_content);
                cmd.Parameters.AddWithValue("rfid", rfidBytes);
                dbserve.ExecuteCommand(cmd);


                cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ProcessContentSimple set FK_Id_State = 2, Data_Fin = @date_fin where FK_Id_ContentSimple = @id";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                cmd.Parameters.AddWithValue("date_fin", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);

                int station = FindNextStation(id_simple_content);
                cmd = dbserve.SqlCommandText;
                cmd.CommandText = "insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Data_Start) values(@id_content, @station, @state, @date_start)";
                cmd.Parameters.AddWithValue("id_content", id_simple_content);
                cmd.Parameters.AddWithValue("station", station);
                cmd.Parameters.AddWithValue("state", 0);
                cmd.Parameters.AddWithValue("date_start", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);
            }
            catch (SqlException e)
            {
                //MessageBox.Show("Đã có lỗi xảy ra khi dán đế! Xin vui lòng thử lại sau.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
