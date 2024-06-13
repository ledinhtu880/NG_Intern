using NganGiang.Libs;
using System.Data;
using System.Data.SqlClient;

namespace NganGiang.Services.Process
{
    internal class ProcessService405
    {
        public void listProcessSimpleOrderLocal(DataGridView dgv)
        {
            try
            {
                string query = @"SELECT FK_Id_OrderLocal AS Id_OrderLocal, Id_ContentSimple AS Id_Simple, Name_RawMaterial AS Name_Raw, 
                    RawMaterial.Count AS Quantity, (SELECT Count FROM RawMaterial WHERE Id_RawMaterial = 0) AS quantity_container, Count_RawMaterial * Count_Container AS Quantity_Order, Unit AS Unit, Name_State AS Status, ProcessContentSimple.Date_Start AS Date_Start, 
                    SimpleOrPack AS Type_Simple
                    FROM ProcessContentSimple 
                    INNER JOIN ContentSimple on Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple
                    INNER JOIN DetailContentSimpleOrderLocal on Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple
                    INNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial
                    INNER JOIN [State] on Id_State = FK_Id_State
                    INNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal
                    WHERE FK_Id_Station = 405 and FK_Id_State != 2
                    ORDER BY Id_OrderLocal ASC, id_simple ASC, Date_Start DESC";
                DataTable dt = DataProvider.Instance.ExecuteQuery(query);

                dgv.AutoGenerateColumns = false;

                DataGridViewCheckBoxColumn column = new()
                {
                    HeaderText = "",
                };

                DataGridViewTextBoxColumn column1 = new()
                {
                    HeaderText = "Mã đơn hàng",
                    DataPropertyName = "Id_OrderLocal",
                    Name = "Id_OrderLocal",

                };

                DataGridViewTextBoxColumn column2 = new()
                {
                    HeaderText = "Loại hàng",
                    DataPropertyName = "Type_Simple",
                    Name = "Type_Simple",
                };

                DataGridViewTextBoxColumn column3 = new()
                {
                    HeaderText = "Mã thùng hàng",
                    DataPropertyName = "Id_Simple",
                    Name = "Id_Simple",
                };

                DataGridViewTextBoxColumn column4 = new()
                {
                    HeaderText = "Tên nguyên liệu thô",
                    DataPropertyName = "Name_Raw",
                    Name = "Name_Raw",
                };

                DataGridViewTextBoxColumn column5 = new()
                {
                    HeaderText = "Số lượng tồn",
                    DataPropertyName = "Quantity",
                    Name = "Quantity",
                };

                DataGridViewTextBoxColumn column6 = new()
                {
                    HeaderText = "Số lượng cần",
                    DataPropertyName = "Quantity_Order",
                    Name = "Quantity_Order",
                };

                DataGridViewTextBoxColumn column7 = new()
                {
                    HeaderText = "Số lượng cần",
                    DataPropertyName = "Quantity_Order",
                    Name = "Quantity_Order",
                };

                DataGridViewTextBoxColumn column8 = new()
                {
                    HeaderText = "Đơn vị",
                    DataPropertyName = "Unit",
                    Name = "Unit",
                };

                DataGridViewTextBoxColumn column9 = new()
                {
                    HeaderText = "Trạng thái",
                    DataPropertyName = "Status",
                    Name = "Status",
                };
                DataGridViewTextBoxColumn column10 = new()
                {
                    HeaderText = "Ngày bắt đầu",
                    DataPropertyName = "Date_Start",
                    Name = "Date_Start",
                };


                dgv.Columns.AddRange(column, column1, column2, column3, column4, column5, column6, column7, column8, column9, column10);
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
            string query = $"SELECT Count_Container * Count_RawMaterial AS quantity_simple FROM ContentSimple WHERE Id_ContentSimple = {id_simple_content}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int quantity = 0;
            if (dt.Rows.Count > 0)
            {
                quantity = Convert.ToInt32(dt.Rows[0][0]);
            }
            return quantity;
        }

        public bool checkQuantity(int id_simple_content)
        {
            string query = "SELECT Count FROM RawMaterial WHERE Id_RawMaterial = 2";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
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

        private int FindNextStation(int id_simple_content)
        {
            string query = $@"SELECT TOP 1 FK_Id_Station 
            FROM DetailProductionStationLine DP 
            INNER JOIN DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine 
            INNER JOIN OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal 
            WHERE FK_Id_OrderLocal = (SELECT FK_Id_OrderLocal FROM DetailContentSimpleOrderLocal WHERE FK_Id_ContentSimple = {id_simple_content}) AND FK_Id_Station > 405";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            int station = 0;
            if (dt.Rows.Count > 0)
            {
                station = Convert.ToInt32(dt.Rows[0][0]);
            }
            return station;
        }

        public void UpdateCoverHatProvided(int id_simple_content)
        {
            try
            {
                string query = $"Update ContentSimple set CoverHatProvided = 1 where Id_ContentSimple = {id_simple_content}";
                DataProvider.Instance.ExecuteNonQuery(query);

                var date = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
                query = $"Update ProcessContentSimple set FK_Id_State = 2, Date_Fin = '{date}' where FK_Id_ContentSimple = {id_simple_content} and FK_Id_Station = 405";
                DataProvider.Instance.ExecuteNonQuery(query);

                int quantity = getQuantityContentSimple(id_simple_content);
                query = $"update RawMaterial set Count = Count - {quantity} where Id_RawMaterial = 2";
                DataProvider.Instance.ExecuteNonQuery(query);

                int station = FindNextStation(id_simple_content);
                query = $"insert into ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values({id_simple_content}, {station}, 0, '{date}')";

                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException e)
            {
                MessageBox.Show($"Đã có lỗi xảy ra \n{e.Message}", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}