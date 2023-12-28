using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static Org.BouncyCastle.Math.EC.ECCurve;
using NganGiang.Libs;

namespace NganGiang.Services.Process
{
    internal class Helper
    {
        public static DataTable getInforContentSimpleByContentPack(ContentPack contentPack)
        {
            string query = $"SELECT FK_Id_ContentSimple as N'Mã thùng hàng', Name_RawMaterial as N'Nguyên liệu', Count_RawMaterial as N'Số lượng nguyên liệu',\r\nUnit as N'Đơn vị', Name_ContainerType as N'Thùng chứa',\r\nCount_Container as N'Số lượng thùng chứa', format(Price_Container, '##,###.## VNĐ') as N'Đơn giá'\r\nFROM ContentSimple CS\r\nINNER JOIN DetailContentSimpleOfPack DCSOP ON DCSOP.FK_Id_ContentSimple = CS.Id_ContentSimple\r\nINNER JOIN RawMaterial on Id_RawMaterial = FK_Id_RawMaterial\r\nINNER JOIN ContainerType on FK_Id_ContainerType = Id_ContainerType\r\nWHERE DCSOP.FK_Id_ContentPack = {contentPack.Id_ContentPack}";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        public static bool updateProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            processContentPack.FK_Id_State = 2;
            processContentPack.Date_Fin = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
            string query = $"UPDATE ProcessContentPack SET FK_Id_State = {processContentPack.FK_Id_State}, Date_Fin = '{processContentPack.Date_Fin}' WHERE FK_Id_ContentPack = {processContentPack.FK_Id_ContentPack}";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Cập nhật ProcessContentPack thất bại";
                return false;
            }
            return true;
        }

        public static bool createProcessContentPack(ProcessContentPack processContentPack, out string message)
        {
            message = "";
            processContentPack.FK_Id_State = 0;
            processContentPack.Date_Start = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
            string query = $"INSERT INTO ProcessContentPack(FK_Id_ContentPack, FK_Id_State, FK_Id_Station, Date_Start) VALUES({processContentPack.FK_Id_ContentPack}, {processContentPack.FK_Id_State}, {processContentPack.FK_Id_Station}, '{processContentPack.Date_Start}')";
            int rowAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowAffected <= 0)
            {
                message = "Tạo ProcessContentPack thất bại";
                return false;
            }
            return true;
        }

        public static List<decimal> getIdContentSimple(ProcessContentPack processContentPack, out string message)
        {
            try
            {
                message = "";
                string query = $"SELECT FK_Id_ContentSimple\r\nFROM DetailContentSimpleOfPack\r\nWHERE FK_Id_ContentPack = {processContentPack.FK_Id_ContentPack}";
                SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
                List<decimal> listIdContentSimples = new List<decimal>();
                while (reader.Read())
                {
                    listIdContentSimples.Add(reader.GetDecimal(0));
                }
                return listIdContentSimples;
            }
            catch (Exception e)
            {
                message = "Lỗi khi lấy IdContentSimple\n" + e.Message;
                throw;
            }
        }
    }
}
