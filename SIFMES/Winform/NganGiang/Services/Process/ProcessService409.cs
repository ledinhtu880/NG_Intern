using NganGiang.Libs;
using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang.Services.Process
{
    internal class ProcessService409
    {
        public DataTable ShowContentPack()
        {
            string query = @"SELECT DISTINCT FK_Id_OrderLocal AS [Mã đơn hàng], Id_ContentPack AS [Mã gói hàng],
            CASE SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END AS [Loại hàng], 
            Name_State AS [Trạng thái], CONVERT(DATE, ProcessContentPack.Date_Start) AS [Ngày bắt đầu]
            FROM ProcessContentPack
                INNER JOIN ContentPack on ProcessContentPack.FK_Id_ContentPack = Id_ContentPack
                INNER JOIN DetailContentSimpleOfPack on ContentPack.Id_ContentPack = DetailContentSimpleOfPack.FK_Id_ContentPack
                INNER JOIN DetailContentPackOrderLocal on ContentPack.Id_ContentPack = DetailContentPackOrderLocal.FK_Id_ContentPack
                INNER JOIN State on FK_Id_State = Id_State
                INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal
            WHERE ProcessContentPack.FK_Id_Station = 409 AND FK_Id_State = 0              
            GROUP BY FK_Id_OrderLocal, Id_ContentPack, SimpleOrPack, Name_State, ProcessContentPack.Date_Start";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public DataTable getLocationMatrix()
        {
            // Lấy ra vị trí thùng hàng trong kho 409
            string query = "SELECT Rowi, Colj, Id_ContentPack, Count_Pack, " +
                "(Count_Pack - COALESCE(SUM(RegisterContentPackAtWareHouse.Count), 0)) as SoLuong " +
                "FROM ContentPack " +
                "LEFT JOIN RegisterContentPackAtWareHouse ON Id_ContentPack = FK_Id_ContentPack " +
                "JOIN DetailStateCellOfPackWareHouse p on Id_ContentPack = p.FK_Id_ContentPack " +
                "GROUP BY Rowi, Colj, Id_ContentPack, Count_Pack " +
                "ORDER BY RowI, Colj";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public WareHouse getRowAndCol()
        {
            // Lấy ra số hàng và số cột của kho 409
            WareHouse wareHouse = new WareHouse(409);
            string query = "SELECT numRow, numCol " +
                "FROM WareHouse " +
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
        public bool UpdateDetailStateCellOfPackWareHouse(int id)
        {
            try
            {
                string query = "UPDATE DetailStateCellOfPackWareHouse " +
                               "SET FK_Id_ContentPack = " + id + ", FK_Id_StateCell = 2 " +
                               "WHERE Rowi = (SELECT TOP 1 Rowi FROM DetailStateCellOfPackWareHouse " +
                               "WHERE FK_Id_StateCell = 1 AND FK_Id_Station = 409) AND " +
                               "Colj = (SELECT TOP 1 Colj FROM DetailStateCellOfPackWareHouse " +
                               "WHERE FK_Id_StateCell = 1 AND FK_Id_Station = 409)";
                int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
                if (rowAffected < 0)
                {
                    return false;
                }
                return true;
            }
            catch (Exception ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return false;
            }
        }
        public List<int> GetIdContentSimpleList(int id)
        {
            string query = @$"SELECT Id_ContentSimple AS [Mã thùng hàng] 
                FROM ContentSimple 
                INNER JOIN DetailContentSimpleOfPack ON Id_ContentSimple = FK_Id_ContentSimple 
                INNER JOIN DetailContentPackOrderLocal ON DetailContentPackOrderLocal.FK_Id_ContentPack = DetailContentSimpleOfPack.FK_Id_ContentPack 
                INNER JOIN RawMaterial on ContentSimple.FK_Id_RawMaterial = RawMaterial.Id_RawMaterial 
                WHERE DetailContentPackOrderLocal.FK_Id_ContentPack = {id} AND RawMaterial.FK_Id_RawMaterialType <> 0
                GROUP BY Id_ContentSimple";

            List<int> idContentSimpleList = new List<int>();

            DataTable result = DataProvider.Instance.ExecuteQuery(query);

            foreach (DataRow row in result.Rows)
            {
                int idContentSimple = Convert.ToInt32(row["Mã thùng hàng"]);
                idContentSimpleList.Add(idContentSimple);
            }

            return idContentSimpleList;
        }
        public void UpdateProcessContentPack(int id)
        {
            try
            {
                string query = $"UPDATE ProcessContentPack SET FK_Id_State = 2, Date_Fin = " +
                $"'{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' WHERE FK_Id_ContentPack = {id} AND FK_Id_Station = 409";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateProcessContentSimple(int id)
        {
            try
            {
                List<int> idArr = GetIdContentSimpleList(id);
                foreach (int each in idArr)
                {
                    string query = $"UPDATE ProcessContentSimple SET FK_Id_State = 2, Date_Fin = @Date_Fin " +
                        $"WHERE FK_Id_ContentSimple = @FK_Id_ContentSimple AND FK_Id_Station = 409";
                    SqlParameter[] parameters = new SqlParameter[]
                    {
                        new SqlParameter("@FK_Id_ContentSimple", each),
                        new SqlParameter("@Date_Fin", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                    };

                    DataProvider.Instance.ExecuteNonQuery(query, parameters);
                }
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public int GetIDOrder(int id)
        {
            try
            {
                string query = "select Id_Order from [Order] " +
                "inner join ContentPack on FK_Id_Order = Id_Order " +
                $"where Id_ContentPack = {id}";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows.Count > 0)
                {
                    // Lấy giá trị trạm tiếp theo từ kết quả
                    int Id_Order = Convert.ToInt32(result.Rows[0]["Id_Order"]);
                    return Id_Order;
                }
                else
                {
                    // Không có kết quả trả về
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy trạm tiếp theo.\n" + ex.Message);
                return -1;
            }
        }
        public void UpdateOrder(int id)
        {
            try
            {
                string query = "UPDATE [Order] SET Date_Delivery = @Date_Delivery WHERE Id_Order = " +
                    "(SELECT FK_Id_Order FROM ContentPack WHERE Id_ContentPack = @Id_ContentPack)";

                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@Id_ContentPack", id),
                    new SqlParameter("@Date_Delivery", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                };

                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateOrderLocal(int id)
        {
            try
            {
                string query = "update OrderLocal set Date_Fin = @Date_Fin " +
                    "where Id_OrderLocal = (select Id_OrderLocal from OrderLocal " +
                    "inner join DetailContentPackOrderLocal on Id_OrderLocal = FK_Id_OrderLocal " +
                    "where DetailContentPackOrderLocal.FK_Id_ContentPack = @FK_Id_ContentPack)";

                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@FK_Id_ContentPack", id),
                    new SqlParameter("@Date_Fin", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                };

                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public bool AreAllContentPacksInWareHouse(int id)
        {
            try
            {
                string query = "SELECT Id_ContentPack " +
                    "FROM ContentPack " +
                    $"WHERE FK_Id_Order = {GetIDOrder(id)} " +
                    "AND Id_ContentPack NOT IN (" +
                    "select Id_ContentPack from ContentPack " +
                    "inner join [Order] on FK_Id_Order = Id_Order " +
                    "inner join [DetailStateCellOfPackWareHouse] on FK_Id_ContentPack = Id_ContentPack " +
                    $"where FK_Id_Order = {GetIDOrder(id)})";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                return result.Rows.Count == 0;
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi kiểm tra ContentPack trong WareHouse.\n" + ex.Message);
                return false;
            }
        }
        public int GetNextStation(int id)
        {
            try
            {
                string query = "SELECT TOP 1 FK_Id_Station AS N'Trạm tiếp theo' FROM DispatcherOrder " +
                    "INNER JOIN DetailContentPackOrderLocal ON DispatcherOrder.FK_Id_OrderLocal = " +
                    "DetailContentPackOrderLocal.FK_Id_OrderLocal " +
                    "INNER JOIN DetailProductionStationLine ON DispatcherOrder.FK_Id_ProdStationLine = DetailProductionStationLine.FK_Id_ProdStationLine " +
                    $"WHERE FK_Id_Station > 409 AND FK_Id_ContentPack = {id}";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows.Count > 0)
                {
                    // Lấy giá trị trạm tiếp theo từ kết quả
                    int nextStation = Convert.ToInt32(result.Rows[0]["Trạm tiếp theo"]);
                    return nextStation;
                }
                else
                {
                    // Không có kết quả trả về
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy trạm tiếp theo.\n" + ex.Message);
                return -1;
            }
        }
    }
}
