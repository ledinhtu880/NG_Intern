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
                string query = $"SELECT FK_Id_ContentSimple FROM ContentSimple cs " +
                    $"inner join DetailContentSimpleOfPack dcsp on cs.Id_ContentSimple = dcsp.FK_Id_ContentSimple " +
                    $"inner join RawMaterial on cs.FK_Id_RawMaterial = RawMaterial.Id_RawMaterial " +
                    $"WHERE FK_Id_ContentPack = {processContentPack.FK_Id_ContentPack} and RawMaterial.FK_Id_RawMaterialType <> 0";
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

        public static bool UpdateState(int id_simple_content, int state, int station)
        {
            try
            {
                string query = $"UPDATE ProcessContentSimple SET FK_Id_State = {state} WHERE FK_Id_ContentSimple = {id_simple_content} AND FK_Id_Station = {station}";
                return true;
            }
            catch (SqlException e)
            {
                MessageBox.Show($"{e.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return false;
            }
        }

        public static string getRFID(int id_simple_content)
        {
            string query = $"SELECT RFID FROM ContentSimple WHERE Id_ContentSimple = {id_simple_content}";
            return DataProvider.Instance.GetValue(query);
        }
    }
}
