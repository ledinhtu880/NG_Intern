using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Services.Process
{
    internal class ProcessService407
    {
        private DatabaseService dbserve { get; set; }

        public ProcessService407()
        {
            dbserve = new DatabaseService();
        }

        public void listProcessSimpleOrderLocal(DataGridView dgv)
        {
            try
            {
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "SELECT FK_Id_OrderLocal as id_orderlocal, Id_SimpleContent as id_simple, Name_RawMaterial as name_raw, RawMaterial.Count as quantity, \r\n\t\tUnit as unit, Count_RawMaterial * Count_Container as quantity_order, Name_State as status, ProcessContentSimple.Data_Start as date_start, SimpleOrPack as type_simple FROM ProcessContentSimple \r\nINNER JOIN ContentSimple on Id_SimpleContent = ProcessContentSimple.FK_Id_ContentSimple\r\nINNER JOIN DetailContentSimpleOrderLocal on Id_SimpleContent = DetailContentSimpleOrderLocal.FK_Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN [State] on Id_State = FK_Id_State\r\nINNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal\r\nWHERE FK_Id_Station = 407 and FK_Id_State = 0 order by date_start desc";
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
                MessageBox.Show("Đã có lỗi xảy ra!", $"{e.Message}", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        public bool IsLastStation(int id_simple_content)
        {
            var cmd = dbserve.SqlCommandText;
            cmd.CommandText = "SELECT FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine inner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal WHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal where FK_Id_ContentSimple = @id) and FK_Id_Station > 407";
            cmd.Parameters.AddWithValue("id", id_simple_content);
            DataTable dt = dbserve.ExecuteCommand(cmd);
            if (dt.Rows.Count > 0)
            {
                return false;
            }
            return true;
        }

        public byte[] GenerateQrCode(int id_simple_content)
        {
            string qrText = $"Thùng hàng số {id_simple_content}";

            byte[] binaryData = Encoding.UTF8.GetBytes(qrText);

            return binaryData;
        }

        public void UpdateQrCodeAndState(int id_simple_content)
        {
            try
            {
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update DetailStateCellOfSimpleWareHouse set FK_Id_StateCell = 1, FK_Id_SimpleContent = NULL where FK_Id_Station = 406 and FK_Id_SimpleContent = @id_content";
                cmd.Parameters.AddWithValue("id_content", id_simple_content);
                dbserve.ExecuteCommand(cmd);

                byte[] qrcode = GenerateQrCode(id_simple_content);
                cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ContentSimple set QRCode = @qr, QRCodeProvided = 1 where Id_SimpleContent = @id";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                cmd.Parameters.AddWithValue("qr", qrcode);
                dbserve.ExecuteCommand(cmd);

                cmd.CommandText = "Update ProcessContentSimple set FK_Id_State = 1 where FK_Id_ContentSimple = @id_simple";
                cmd.Parameters.AddWithValue("@id_simple", id_simple_content);
                dbserve.ExecuteCommand(cmd);
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
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ProcessContentSimple set FK_Id_State = 2, Data_fin = @date_fin where FK_Id_ContentSimple = @id and FK_Id_Station = 407";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                cmd.Parameters.AddWithValue("date_fin", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);

                cmd.CommandText = "insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Data_Start) values(@id_content, @station, @state, @date_start)";
                cmd.Parameters.AddWithValue("id_content", id_simple_content);
                cmd.Parameters.AddWithValue("station", 408);
                cmd.Parameters.AddWithValue("state", 0);
                cmd.Parameters.AddWithValue("date_start", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private List<int> contentPack = new List<int>();
        public void GetPackContent(int id_simple_content)
        {
            contentPack.Clear();
            try
            {
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "select Id_PackContent from ContentPack P join DetailContentSimpleOfPack DP on P.Id_PackContent = DP.FK_Id_PackContent where DP.FK_Id_SimpleContent = @id";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                DataTable dt = dbserve.ExecuteCommand(cmd);
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
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ProcessContentPack set FK_Id_State = 2, Data_fin = @date_fin where FK_Id_ContentPack = @id and FK_Id_Station = 407";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                cmd.Parameters.AddWithValue("date_fin", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);

                foreach (var item in contentPack)
                {
                    cmd.CommandText = "insert into ProcessContentPack(FK_Id_ContentPack, FK_Id_Station, FK_Id_State, Data_Start) values(@id_pack, @station, @state, @date_start)";
                    cmd.Parameters.AddWithValue("id_pack", item);
                    cmd.Parameters.AddWithValue("station", 408);
                    cmd.Parameters.AddWithValue("state", 0);
                    cmd.Parameters.AddWithValue("date_start", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                    dbserve.ExecuteCommand(cmd);
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
                var cmd = dbserve.SqlCommandText;
                cmd.CommandText = "Update ProcessContentSimple set FK_Id_State = 2, Data_fin = @date_fin where FK_Id_ContentSimple = @id and FK_Id_Station = 407";
                cmd.Parameters.AddWithValue("id", id_simple_content);
                cmd.Parameters.AddWithValue("date_fin", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);

                cmd.CommandText = "UPDATE OrderLocal set Data_Fin = @date_fin_local FROM DetailContentSimpleOrderLocal D JOIN OrderLocal O ON D.FK_Id_OrderLocal = O.Id_OrderLocal WHERE D.FK_Id_ContentSimple = @id_simple";
                cmd.Parameters.AddWithValue("id_simple", id_simple_content);
                cmd.Parameters.AddWithValue("date_fin_local", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);

                cmd.CommandText = "UPDATE dbo.[Order] SET Date_Dilivery = @date_delivery FROM ContentSimple C join dbo.[Order] O on C.FK_Id_Order = O.Id_Order WHERE C.Id_SimpleContent = @id_simple_content";
                cmd.Parameters.AddWithValue("id_simple_content", id_simple_content);
                cmd.Parameters.AddWithValue("date_delivery", DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss"));
                dbserve.ExecuteCommand(cmd);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
