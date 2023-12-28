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
    internal class ProcessService403
    {
        #region Hàm lấy dữ liệu
        public DataTable GetCheckAmount(int id)
        {
            string query = $"SELECT (Count_RawMaterial * Count_Container) AS 'Số lượng'," +
                $"RawMaterial.Count AS N'Tồn kho' FROM ContentSimple" +
                $"\n INNER JOIN RawMaterial ON ContentSimple.FK_Id_RawMaterial = Id_RawMaterial" +
                $"\n WHERE Id_ContentSimple = {id}";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public int GetAmount(int id)
        {
            string query = $"SELECT (Count_RawMaterial * Count_Container) AS 'Số lượng'," +
                $"RawMaterial.Count AS N'Tồn kho' FROM ContentSimple" +
                $"\n INNER JOIN RawMaterial ON ContentSimple.FK_Id_RawMaterial = Id_RawMaterial" +
                $"\n WHERE Id_ContentSimple = {id}";
            return Convert.ToInt32(DataProvider.Instance.GetValue(query));
        }
        public int GetRawMaterialID(int id)
        {
            string query = $"SELECT FK_Id_RawMaterial from ContentSimple where ID_ContentSimple = {id}";
            return Convert.ToInt32(DataProvider.Instance.GetValue(query));
        }
        #endregion

        #region Trạm 403
        public DataTable ShowContentSimple()
        {
            string query =
                "SELECT FK_Id_OrderLocal AS [Mã đơn hàng], " +
                "CASE SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END AS [Kiểu hàng], " +
                "Id_ContentSimple AS [Mã thùng hàng], " +
                "Name_RawMaterial AS [Tên nguyên liệu thô], RawMaterial.Count AS [Số lượng nguyên liệu tồn], " +
                "Count_RawMaterial * Count_Container AS [Số lượng nguyên liệu cần], Unit AS [Đơn vị], Name_State AS [Trạng thái], " +
                "CONVERT(date, ProcessContentSimple.Date_Start) AS [Ngày bắt đầu] " +
                "FROM ProcessContentSimple " +
                "INNER JOIN ContentSimple ON Id_ContentSimple = ProcessContentSimple.FK_Id_ContentSimple " +
                "INNER JOIN DetailContentSimpleOrderLocal ON Id_ContentSimple = DetailContentSimpleOrderLocal.FK_Id_ContentSimple " +
                "INNER JOIN RawMaterial ON Id_RawMaterial = FK_Id_RawMaterial " +
                "INNER JOIN State ON Id_State = FK_Id_State " +
                "INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal " +
                "WHERE FK_Id_Station = 403 AND FK_Id_State = 0 " +
                "group by FK_Id_OrderLocal, SimpleOrPack, Id_ContentSimple, Name_RawMaterial, RawMaterial.Count, Unit, Name_State, " +
                "Count_RawMaterial * Count_Container, CONVERT(date, ProcessContentSimple.Date_Start)";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public void UpdateRawMaterial(int amount, int id)
        {
            string query = $"UPDATE RawMaterial set Count = Count - {amount} where Id_RawMaterial = {GetRawMaterialID(id)}";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
        public void UpdateContentSimple(int id)
        {
            string query = $"UPDATE ContentSimple SET RawMaterialProvided = '1' WHERE Id_ContentSimple = {id}";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
        public void UpdateProcessContentSimple(int id)
        {
            try
            {
                string query = $"UPDATE ProcessContentSimple SET FK_Id_State = 2, Date_Fin = " +
                $"'{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' WHERE FK_Id_ContentSimple = {id}";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = "INSERT INTO ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) " +
                "VALUES (@FK_Id_ContentSimple, @FK_Id_Station, @FK_Id_State, @Date_Start)";

                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@FK_Id_ContentSimple", id),
                    new SqlParameter("@FK_Id_Station", 405),
                    new SqlParameter("@FK_Id_State", SqlDbType.SmallInt) { Value = 0 },
                    new SqlParameter("@Date_Start", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                };

                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        #endregion
    }
}