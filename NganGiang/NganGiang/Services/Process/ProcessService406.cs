using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using NganGiang.Libs;

namespace NganGiang.Services.Process
{
    internal class ProcessService406
    {
        public DataTable getProcessAt406()
        {
            /**
             * Lấy ra các đơn hàng đang ở trạm 406 và chưa được xử lý
             * Trả về bảng các cột: Id_OrderLocal, Id_SimpleContent, Name_RawMaterial, RawMaterial.Count, Count_RawMaterial * Count_Container as Count_Need, Name_State, Data_Start, SimpleOrPack
             **/
            int FK_Id_Station = 406;
            int FK_Id_State = 0;
            string query = "SELECT FK_Id_OrderLocal, Id_SimpleContent, Name_RawMaterial, RawMaterial.Count, " +
                           "Count_RawMaterial * Count_Container as Count_Need, Name_State, " +
                           // Mã 103 là mã định dạng cho dd/mm/yyyy.
                           "CONVERT(varchar(30), ProcessContentSimple.Data_Start, 103) as Data_Start, " +
                           "CASE OrderLocal.SimpleOrPack WHEN 0 THEN N'Thùng hàng' ELSE N'Gói hàng' END as SimpleOrPack " +
                           "FROM ProcessContentSimple " +
                           "INNER JOIN ContentSimple on Id_SimpleContent = ProcessContentSimple.FK_Id_ContentSimple " +
                           "INNER JOIN DetailContentSimpleOrderLocal on Id_SimpleContent = DetailContentSimpleOrderLocal.FK_Id_ContentSimple " +
                           "INNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial " +
                           "INNER JOIN [State] on Id_State = FK_Id_State " +
                           "INNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal " +
                           "WHERE FK_Id_Station = " + FK_Id_Station + "and FK_Id_State = " + FK_Id_State;
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }
        public DataTable getInforOrderByIdSimpleContent(ContentSimple contentSimple)
        {
            // Lấy ra thông tin đơn hàng theo Id_SimpleContent
            string query = $"SELECT  Name_RawMaterial as N'Nguyên liệu', Count_RawMaterial as N'Số lượng nguyên liệu',\r\n\t\tUnit as N'Đơn vị', Name_ContainerType as N'Thùng chứa',\r\n\t\tCount_Container as N'Số lượng thùng chứa', format(Price_Container, '##,###.## VNĐ') as N'Đơn giá'\r\nFROM ContentSimple \r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN ContainerType on FK_Id_ContainerType = Id_ContainerType\r\nWHERE Id_SimpleContent = {contentSimple.Id_SimpleContent}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }
        public bool updateProcessContentSimple(ProcessContentSimple processContentSimple, out string message)
        {
            /**
             * Bảng ProcessContentSimple: FK_Id_State chuyển thành 2 – Đã xử lý, cập nhật ngày hoàn thành Data_Fin
             */
            try
            {
                message = "";
                processContentSimple.FK_Id_State = 2;
                processContentSimple.FK_Id_Station = 406;
                processContentSimple.Data_Fin = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");

                string query = @"UPDATE ProcessContentSimple SET " +
                "FK_Id_State = '" + processContentSimple.FK_Id_State + "'" +
                ", Data_Fin = '" + processContentSimple.Data_Fin + "'" +
                " WHERE FK_Id_ContentSimple = '" + processContentSimple.FK_Id_ContentSimple + "'" +
                " AND FK_Id_Station = '" + processContentSimple.FK_Id_Station + "'";

                int rowsAffected = DataProvider.Instance.ExecuteNonQuery(query);

                if (rowsAffected <= 0)
                {
                    message = "Lỗi khi cập nhật bảng ProcessContentSimple";
                    return false;
                }
                return true;
            }
            catch (Exception ex)
            {
                message = "Lỗi ProcessContentSimple: " + ex.Message;
                return false;
            }

        }
        public bool updateDetailStateCellOfSimpleWareHouse(ProcessContentSimple processContentSimple, out string message)
        {
            /**
             * Bảng DetailStateCellOfSimpleWareHouse: 
             * Cập nhật FK_Id_SimpleContent
             * Cập nhật FK_Id_StateCell = 2
             **/
            try
            {
                string query = "UPDATE DetailStateCellOfSimpleWareHouse " +
                               "SET FK_Id_SimpleContent = " + processContentSimple.FK_Id_ContentSimple +
                               ", FK_Id_StateCell = 2 " +
                               "WHERE Rowi = (SELECT TOP 1 Rowi FROM DetailStateCellOfSimpleWareHouse " +
                               "WHERE FK_Id_StateCell = 1 AND FK_Id_Station = 406) AND " +
                               "Colj = (SELECT TOP 1 Colj FROM DetailStateCellOfSimpleWareHouse " +
                               "WHERE FK_Id_StateCell = 1 AND FK_Id_Station = 406)";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected < 0)
                {
                    message = "Lỗi khi cập nhật bảng DetailStateCellOfSimpleWareHouse";
                    return false;
                }
                message = "";
                return true;
            }
            catch (Exception ex)
            {
                message = "Lỗi khi cập nhật bảng DetailStateCellOfSimpleWareHouse: " + ex.Message;
                return false;
            }
        }
        public WareHouse getRowAndCol()
        {
            // Lấy ra số hàng và số cột của kho 406
            WareHouse wareHouse = new WareHouse(406);
            string query = "SELECT numRow, numCol\r\nFROM WareHouse\r\nWHERE FK_Id_Station = 406";
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            if (reader.Read())
            {
                wareHouse.numRow = reader.GetInt32(0);
                wareHouse.numCol = reader.GetInt32(1);
            }
            reader.Close();
            return wareHouse;
        }
        public DataTable getLocationMatrix()
        {
            // Lấy ra vị trí thùng hàng trong kho 406
            string query = "SELECT Id_SimpleContent, Rowi, Colj\r\nFROM DetailStateCellOfSimpleWareHouse\r\nINNER JOIN ContentSimple ON FK_Id_SimpleContent = Id_SimpleContent";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        private List<decimal> getIdSimpleContentsByDetailContentSimpleOrderLocal(OrderLocal orderLocal)
        {
            // Lấy ra danh sách Id_SimpleContent theo Id_OrderLocal
            List<decimal> Id_SimpleContents = new List<decimal>();
            string query = $"SELECT FK_Id_ContentSimple\r\nFROM DetailContentSimpleOrderLocal\r\nWHERE FK_Id_OrderLocal = {orderLocal.Id_OrderLocal}";
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            while (reader.Read())
            {
                Id_SimpleContents.Add(reader.GetDecimal(0));
            }
            reader.Close();
            return Id_SimpleContents;
        }

        private bool checkStation406AndSate2(List<decimal> Id_SimpleContents)
        {
            bool check = true;
            foreach (int Id_SimpleContent in Id_SimpleContents)
            {
                string query = $"SELECT *\r\nFROM ProcessContentSimple\r\nWHERE FK_Id_ContentSimple = {Id_SimpleContent} AND FK_Id_State = 2 AND FK_Id_Station = 406";
                SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
                if (!reader.HasRows)
                {
                    check = false;
                    reader.Close();
                    break;
                }
            }
            return check;
        }

        public bool updateOrderLocal(ProcessContentSimple processContentSimple, out string message)
        {
            // Cập nhật bảng OrderLocal
            // Bảng OrderLocal cập nhật Data_Fin

            string queryGetIdOrderLocal = $"SELECT FK_Id_OrderLocal\r\nFROM DetailContentSimpleOrderLocal\r\nWHERE FK_Id_ContentSimple = {processContentSimple.FK_Id_ContentSimple}";

            OrderLocal orderLocal = new OrderLocal();
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(queryGetIdOrderLocal);
            if (reader.Read())
            {
                orderLocal.Id_OrderLocal = reader.GetDecimal(0);
            }

            List<decimal> Id_SimpleContents = this.getIdSimpleContentsByDetailContentSimpleOrderLocal(orderLocal);
            message = "";

            orderLocal.Data_Fin = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");

            if (this.checkStation406AndSate2(Id_SimpleContents))
            {
                // Cập nhật bảng Order
                string query = $"UPDATE OrderLocal SET Data_Fin = '{orderLocal.Data_Fin}' WHERE Id_OrderLocal = {orderLocal.Id_OrderLocal}";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    // Cập nhật thất bại
                    message = "Cập nhật bảng OrderLocal thất bại";
                    return false;
                }
            }

            return true;
        }

        private decimal getIdOrderBySimpleContent(ProcessContentSimple process)
        {
            string query = $"SELECT FK_Id_Order\r\nFROM ContentSimple\r\nWHERE Id_SimpleContent = {process.FK_Id_ContentSimple}";
            decimal Id_Order = -1;
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            if (reader.Read())
            {
                Id_Order = reader.GetDecimal(0);
            }
            reader.Close();
            return Id_Order;
        }

        public bool updateOrder(ProcessContentSimple process, out string message)
        {
            // Cập nhật bảng Order
            // Bảng Order cập nhật Date_Dilivery
            message = "";
            Order order = new Order();
            order.Id_Order = this.getIdOrderBySimpleContent(process);
            order.Date_Dilivery = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");
            string query = $"SELECT Id_SimpleContent\r\nFROM ContentSimple\r\nWHERE FK_Id_Order = {order.Id_Order}";
            List<decimal> Id_ContentSimples = new List<decimal>();
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            while (reader.Read())
            {
                Id_ContentSimples.Add(reader.GetDecimal(0));
            }


            if (this.checkStation406AndSate2(Id_ContentSimples))
            {
                query = $"UPDATE [Order] SET Date_Dilivery = '{order.Date_Dilivery}' WHERE Id_Order = {order.Id_Order}";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Cập nhật bảng Order thất bại";
                    return false;
                }
            }
            return true;
        }

        public int getStateByRowAndCol(int row, int col)
        {
            // Kiểm tra trạng thái trong kho 406 bằng dòng và cột nếu không có trả về -1
            string query = $"SELECT FK_Id_StateCell\r\nFROM DetailStateCellOfSimpleWareHouse\r\nWHERE Rowi = {row} AND Colj = {col}";
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            if (reader.Read())
            {
                return reader.GetInt32(0);
            }
            return -1;
        }

        public bool updateStateCellOfSimpleWareHouse(int row, int col, int state, out string message)
        {
            // Cập nhật trạng thái của kho 406
            message = "";
            string query = $"UPDATE DetailStateCellOfSimpleWareHouse SET FK_Id_StateCell = {state} WHERE Rowi = {row} AND Colj = {col}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật bảng DetailStateCellOfSimpleWareHouse thất bại";
                return false;
            }
            return true;
        }
    }
}
