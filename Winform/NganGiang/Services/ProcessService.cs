using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Services
{
    internal class ProcessService
    {
        public DataTable ShowContentSimple()
        {
            string query = 
                "SELECT O.Id_OrderLocal as N'Mã đơn hàng', P.FK_Id_ContentSimple as N'Mã thùng hàng', " +
                "CASE O.SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END as N'Kiểu hàng', " +
                "S.Name_State as N'Trạng thái', P.Data_Start as N'Ngày bắt đầu', P.Data_Fin as N'Ngày kết thúc' " +
                "FROM OrderLocal O " +
                "INNER JOIN DetailContentSimpleOrderLocal D ON O.Id_OrderLocal = D.FK_Id_OrderLocal " +
                "INNER JOIN ProcessContentSimple P ON P.FK_Id_ContentSimple = D.FK_Id_ContentSimple " +
                "INNER JOIN State S ON S.Id_State = P.FK_Id_State " +
                "WHERE P.FK_Id_Station = 403 AND P.FK_Id_State = 0";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public DataTable GetCheckAmount(int id)
        {
            string query = $"SELECT (Count_RawMaterial * Count_Container) AS 'Số lượng'," +
                $"RawMaterial.Count AS N'Tồn kho' FROM ContentSimple" +
                $"\n INNER JOIN RawMaterial ON ContentSimple.FK_Id_RawMaterial = Id_RawMaterial" +
                $"\n WHERE Id_SimpleContent = {id}";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public int GetAmount(int id)
        {
            string query = $"SELECT (Count_RawMaterial * Count_Container) AS 'Số lượng'," +
                $"RawMaterial.Count AS N'Tồn kho' FROM ContentSimple" +
                $"\n INNER JOIN RawMaterial ON ContentSimple.FK_Id_RawMaterial = Id_RawMaterial" +
                $"\n WHERE Id_SimpleContent = {id}";
            return Convert.ToInt32(DataProvider.Instance.GetValue(query));
        }
        public int GetRawMaterialID(int id)
        {
            string query = $"SELECT FK_Id_RawMaterial from ContentSimple where ID_SimpleContent = {id}";
            return Convert.ToInt32(DataProvider.Instance.GetValue(query));
        }
        public void UpdateRawMaterial(int amount, int id)
        {
            string query = $"UPDATE RawMaterial set Count = Count - {amount} where Id_RawMaterial = {GetRawMaterialID(id)}";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
        public void UpdateContentSimple(int id)
        {
            string query = $"UPDATE ContentSimple SET RawMaterialProvided = '1' WHERE Id_SimpleContent = {id}";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
        public void UpdateProcessContentSimple(int id)
        {
            string query = $"UPDATE ProcessContentSimple SET FK_Id_State = 2, Data_Fin = " +
                $"'{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' WHERE FK_Id_ContentSimple = {id}";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
    }
}