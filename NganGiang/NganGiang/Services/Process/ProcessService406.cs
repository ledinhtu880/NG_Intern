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
             * Trả về bảng các cột: Id_OrderLocal, Id_ContentSimple, Name_RawMaterial, RawMaterial.Count, Count_RawMaterial * Count_Container as Count_Need, Name_State, Date_Start, SimpleOrPack
             **/
            int FK_Id_Station = 406;
            int FK_Id_State = 0;
            string query = "SELECT FK_Id_OrderLocal, Id_ContentSimple, Name_RawMaterial, RawMaterial.Count, " +
                           "Count_RawMaterial * Count_Container as Count_Need, Name_State, " +
                           // Mã 103 là mã định dạng cho dd/mm/yyyy.
                           "CONVERT(varchar(30), ProcessContentSimple.Date_Start, 103) as Date_Start, " +
                           "CASE OrderLocal.SimpleOrPack WHEN 0 THEN N'Thùng hàng' ELSE N'Gói hàng' END as SimpleOrPack " +
                           "FROM ProcessContentSimple " +
                           "INNER JOIN ContentSimple on Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple " +
                           "INNER JOIN DetailContentSimpleOrderLocal on Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple " +
                           "INNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial " +
                           "INNER JOIN [State] on Id_State = FK_Id_State " +
                           "INNER JOIN OrderLocal on FK_Id_OrderLocal = Id_OrderLocal " +
                           "WHERE FK_Id_Station = " + FK_Id_Station + "and FK_Id_State = " + FK_Id_State;
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }
        public DataTable getInforOrderByIdContentSimple(ContentSimple contentSimple)
        {
            // Lấy ra thông tin đơn hàng theo Id_ContentSimple
            string query = $"SELECT  Name_RawMaterial as N'Nguyên liệu', Count_RawMaterial as N'Số lượng nguyên liệu', " +
                $"Unit as N'Đơn vị', Name_ContainerType as N'Thùng chứa', " +
                $"Count_Container as N'Số lượng thùng chứa', format(Price_Container, '##,###.## VNĐ') as N'Đơn giá' " +
                $"FROM ContentSimple " +
                $"INNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial " +
                $"INNER JOIN ContainerType on FK_Id_ContainerType = Id_ContainerType " +
                $"WHERE Id_ContentSimple = {contentSimple.Id_ContentSimple}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }
        public bool updateProcessContentSimple(ProcessContentSimple processContentSimple, out string message)
        {
            /**
             * Bảng ProcessContentSimple: FK_Id_State chuyển thành 2 – Đã xử lý, cập nhật ngày hoàn thành Date_Fin
             */
            try
            {
                message = "";
                processContentSimple.FK_Id_State = 2;
                processContentSimple.FK_Id_Station = 406;
                processContentSimple.Date_Fin = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");

                string query = @"UPDATE ProcessContentSimple SET " +
                "FK_Id_State = '" + processContentSimple.FK_Id_State + "'" +
                ", Date_Fin = '" + processContentSimple.Date_Fin + "'" +
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
             * Cập nhật FK_Id_ContentSimple
             * Cập nhật FK_Id_StateCell = 2
             **/
            try
            {
                string query = $"DECLARE @rowi INT; DECLARE @colj INT; " +
                    $"SELECT TOP 1 @rowi = Rowi, @colj = Colj " +
                    $"FROM DetailStateCellOfSimpleWareHouse " +
                    $"WHERE FK_Id_ContentSimple IS NULL AND FK_Id_StateCell = 1 " +
                    $"ORDER BY Rowi, Colj; " +
                    $"UPDATE DetailStateCellOfSimpleWareHouse " +
                    $"SET FK_Id_ContentSimple = {processContentSimple.FK_Id_ContentSimple}, FK_Id_StateCell = 2 " +
                    $"WHERE Rowi = @rowi AND Colj = @colj;";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Kho đầy";
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
            string query = $"SELECT numRow, numCol " +
                $"FROM WareHouse " +
                $"WHERE FK_Id_Station = {wareHouse.FK_Id_Station}";
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
            string query = "SELECT RowI, ColJ, Id_ContentSimple, (Count_Container - COALESCE(SUM(RegisterContentSimpleAtWareHouse.Count), 0)) as SoLuong FROM ContentSimple LEFT JOIN RegisterContentSimpleAtWareHouse ON Id_ContentSimple = FK_Id_ContentSimple JOIN DetailStateCellOfSimpleWareHouse on Id_ContentSimple = DetailStateCellOfSimpleWareHouse.FK_Id_ContentSimple GROUP BY RowI, ColJ, Id_ContentSimple, Count_Container";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }
        private List<decimal> getIdContentSimplesByDetailContentSimpleOrderLocal(OrderLocal orderLocal)
        {
            // Lấy ra danh sách Id_ContentSimple theo Id_OrderLocal
            List<decimal> Id_ContentSimples = new List<decimal>();
            string query = $"SELECT FK_Id_ContentSimple " +
                $"FROM DetailContentSimpleOrderLocal " +
                $"WHERE FK_Id_OrderLocal = {orderLocal.Id_OrderLocal}";
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            while (reader.Read())
            {
                Id_ContentSimples.Add(reader.GetDecimal(0));
            }
            reader.Close();
            return Id_ContentSimples;
        }

        private bool checkStation406AndSate2(List<decimal> Id_ContentSimples)
        {
            bool check = true;
            foreach (int Id_ContentSimple in Id_ContentSimples)
            {
                string query = $"SELECT * " +
                    $"FROM ProcessContentSimple " +
                    $"WHERE FK_Id_ContentSimple = {Id_ContentSimple} AND FK_Id_State = 2 AND FK_Id_Station = 406";
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
            // Bảng OrderLocal cập nhật Date_Fin

            string queryGetIdOrderLocal = $"SELECT FK_Id_OrderLocal\r\nFROM DetailContentSimpleOrderLocal\r\nWHERE FK_Id_ContentSimple = {processContentSimple.FK_Id_ContentSimple}";

            OrderLocal orderLocal = new OrderLocal();
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(queryGetIdOrderLocal);
            if (reader.Read())
            {
                orderLocal.Id_OrderLocal = reader.GetDecimal(0);
            }

            List<decimal> Id_ContentSimples = this.getIdContentSimplesByDetailContentSimpleOrderLocal(orderLocal);
            message = "";

            orderLocal.Date_Fin = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");

            if (this.checkStation406AndSate2(Id_ContentSimples))
            {
                // Cập nhật bảng Order
                string query = $"UPDATE OrderLocal SET Date_Fin = '{orderLocal.Date_Fin}' WHERE Id_OrderLocal = {orderLocal.Id_OrderLocal}";
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

        private decimal getIdOrderByContentSimple(ProcessContentSimple process)
        {
            string query = $"SELECT FK_Id_Order\r\nFROM ContentSimple\r\nWHERE Id_ContentSimple = {process.FK_Id_ContentSimple}";
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
            // Bảng Order cập nhật Date_Delivery
            message = "";
            Order order = new Order();
            order.Id_Order = this.getIdOrderByContentSimple(process);
            order.Date_Delivery = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");
            string query = $"SELECT Id_ContentSimple\r\nFROM ContentSimple\r\nWHERE FK_Id_Order = {order.Id_Order}";
            List<decimal> Id_ContentSimples = new List<decimal>();
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            while (reader.Read())
            {
                Id_ContentSimples.Add(reader.GetDecimal(0));
            }


            if (this.checkStation406AndSate2(Id_ContentSimples))
            {
                query = $"UPDATE [Order] SET Date_Delivery = '{order.Date_Delivery}' WHERE Id_Order = {order.Id_Order}";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected <= 0)
                {
                    message = "Cập nhật bảng Order thất bại";
                    return false;
                }
            }
            return true;
        }
    }
}