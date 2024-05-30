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
                string query = "SELECT FK_Id_OrderLocal as id_orderlocal, Id_ContentSimple as id_simple, Name_RawMaterial as name_raw, RawMaterial.Count as quantity, \r\n\t\tUnit as unit, Count_RawMaterial * Count_Container as quantity_order, Name_State as status, ProcessContentSimple.Date_Start as date_start, SimpleOrPack as type_simple FROM ProcessContentSimple \r\nINNER JOIN ContentSimple on Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple\r\nINNER JOIN DetailContentSimpleOrderLocal on Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN [State] on Id_State = FK_Id_State\r\nINNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal\r\nWHERE FK_Id_Station = 405 and FK_Id_State = 0 order by id_orderlocal asc, id_simple asc, date_start desc";
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

        public bool checkQuantity(int id_simple_content)
        {
            string query = "select Count from RawMaterial where Id_RawMaterial = 2";
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
            string query = $"SELECT top 1 FK_Id_Station from DetailProductionStationLine DP inner join DispatcherOrder D on DP.FK_Id_ProdStationLine = D.FK_Id_ProdStationLine inner join OrderLocal O on O.Id_OrderLocal = D.FK_Id_OrderLocal WHERE FK_Id_OrderLocal =(select FK_Id_OrderLocal from DetailContentSimpleOrderLocal where FK_Id_ContentSimple = {id_simple_content}) and FK_Id_Station > 405";
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
