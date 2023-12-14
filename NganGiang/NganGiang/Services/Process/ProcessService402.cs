using NganGiang.Models;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using NganGiang.Libs;

namespace NganGiang.Services.Process
{
    internal class ProcessService402
    {
        public DataTable getProcessContentSimple()
        {
            string query =
                "SELECT FK_Id_OrderLocal AS [Mã đơn hàng], " +
                "CASE SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END AS [Kiểu hàng], " +
                "Id_SimpleContent AS [Mã thùng hàng], " +
                "Name_RawMaterial AS [Tên nguyên liệu thô], RawMaterial.Count AS [Số lượng nguyên liệu tồn], " +
                "Count_RawMaterial * Count_Container AS [Số lượng nguyên liệu cần], Unit AS [Đơn vị], Name_State AS [Trạng thái], " +
                "CONVERT(date, ProcessContentSimple.Data_Start) AS [Ngày bắt đầu] " +
                "FROM ProcessContentSimple " +
                "INNER JOIN ContentSimple ON Id_SimpleContent = ProcessContentSimple.FK_Id_ContentSimple " +
                "INNER JOIN DetailContentSimpleOrderLocal ON Id_SimpleContent = DetailContentSimpleOrderLocal.FK_Id_ContentSimple " +
                "INNER JOIN RawMaterial ON Id_RawMaterial = FK_Id_RawMaterial " +
                "INNER JOIN State ON Id_State = FK_Id_State " +
                "INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal " +
                "WHERE FK_Id_Station = 402 AND FK_Id_State = 0 " +
                "group by FK_Id_OrderLocal, SimpleOrPack, Id_SimpleContent, Name_RawMaterial, RawMaterial.Count, Unit, Name_State, " +
                "Count_RawMaterial * Count_Container, CONVERT(date, ProcessContentSimple.Data_Start)";
            DataTable dt = DataProvider.Instance.ExecuteQuery(query);
            return dt;
        }

        public bool UpdateContentSimple(string Id_SimpleContent, out string message)
        {
            message = "";
            // Bảng ContentSimple: RawMaterialProvided chuyển thành True
            ContentSimple contentSimple = new ContentSimple();
            contentSimple.Id_SimpleContent = Convert.ToDecimal(Id_SimpleContent);
            contentSimple.RawMaterialProvided = true;

            string query = "UPDATE ContentSimple Set RawMaterialProvided = '" + contentSimple.RawMaterialProvided + "' WHERE Id_SimpleContent = " + contentSimple.Id_SimpleContent;
            int rowsAffected = DataProvider.Instance.ExecuteNonQuery(query);

            if (rowsAffected <= 0)
            {
                message = "Lỗi khi sửa bảng ContentSimple";
                return false;
            }
            return true;
        }
        public bool UpdateProcessContentSimple(string Id_SimpleContent, out string message)
        {
            message = "";
            // Bảng ProcessContentSimple: FK_Id_State chuyển thành 2 – Đã xử lý, cập nhật ngày hoàn thành Data_Fin
            ProcessContentSimple processContentSimple = new ProcessContentSimple();
            processContentSimple.FK_Id_ContentSimple = Convert.ToDecimal(Id_SimpleContent);
            processContentSimple.FK_Id_State = 2;
            processContentSimple.Data_Fin = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");

            string query = "UPDATE ProcessContentSimple SET FK_Id_State = " + processContentSimple.FK_Id_State +
                           ", Data_Fin = '" + processContentSimple.Data_Fin +
                           "' WHERE FK_Id_ContentSimple = " + processContentSimple.FK_Id_ContentSimple;
            int rowsAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowsAffected <= 0)
            {
                message = "Lỗi khi sửa bảng ProcessContentSimple";
                return false;
            }
            return true;
        }

        public bool InsertProcessContentSimple(string Id_SimpleContent, out string message)
        {
            message = "";
            // ProcessContentSimple: Thêm bản ghi mới:
            // Vẫn mã FK_Id_ContentSimple như trên
            // Tuỳ theo mã trạm tiếp theo trong dây truyền xử lý là bao nhiêu FK_Id_Station là như vậy => Có thể là: 405(để cấp nắp đậy container)
            // FK_Id_State là 0 và ngày bắt đầu Data_Start
            ProcessContentSimple processContentSimple = new ProcessContentSimple();
            processContentSimple.FK_Id_ContentSimple = Convert.ToDecimal(Id_SimpleContent);
            processContentSimple.FK_Id_Station = 405;
            processContentSimple.FK_Id_State = 0;
            processContentSimple.Data_Start = DateTime.Now.ToString("yyyy-MM-dd hh:mm:ss");
            string query = "INSERT INTO ProcessContentSimple(FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Data_Start) " +
                           "VALUES(" + processContentSimple.FK_Id_ContentSimple +
                           ", " + processContentSimple.FK_Id_Station +
                           ", " + processContentSimple.FK_Id_State +
                           ", '" + processContentSimple.Data_Start +
                           "')";
            int rowsAffected = DataProvider.Instance.ExecuteNonQuery(query);
            if (rowsAffected <= 0)
            {
                message = "Lỗi khi thêm mới vào bảng ProcessContentSimple";
                return false;
            }
            return true;
        }

        public bool UpdateRawMaterial(string Id_SimpleContent, out string message)
        {
            message = "";
            // Cập nhật lại số lượng tồn kho của nguyên liệu thô
            string query = "SELECT * FROM ContentSimple WHERE Id_SimpleContent = " + Id_SimpleContent;
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            if (reader.Read())
            {
                ContentSimple contentSimple = new ContentSimple();
                RawMaterial rawMaterial = new RawMaterial();
                contentSimple.FK_Id_RawMaterial = Convert.ToInt32(reader["FK_Id_RawMaterial"]);
                contentSimple.Count_RawMaterial = Convert.ToInt32(reader["Count_RawMaterial"]);
                contentSimple.Count_Container = Convert.ToInt32(reader["Count_Container"]);
                reader.Close();
                string queryRawMaterial = "SELECT Id_RawMaterial, Count FROM RawMaterial WHERE Id_RawMaterial = " + contentSimple.FK_Id_RawMaterial;
                reader = DataProvider.Instance.ExecuteReader(queryRawMaterial);
                if (reader.Read())
                {
                    rawMaterial.Id_RawMaterial = Convert.ToInt32(reader["Id_RawMaterial"]);
                    rawMaterial.Count = Convert.ToInt32(reader["Count"]);
                }
                rawMaterial.Count -= contentSimple.Count_RawMaterial * contentSimple.Count_Container;
                reader.Close();
                query = "UPDATE RawMaterial SET Count = " + rawMaterial.Count + " WHERE Id_RawMaterial = " + rawMaterial.Id_RawMaterial;
                int result = DataProvider.Instance.ExecuteNonQuery(query);
                if (result <= 0)
                {
                    message = "Lỗi khi cập nhật lại số lượng tồn kho của nguyên liệu thô";
                    return false;
                }
                return true;
            }
            else
            {
                message = "Không tìm thấy bản ghi trong bảng ContentSimple";
                return false;
            }
        }

        public bool checkQuantity(string Id_SimpleContent)
        {
            string query = "SELECT [Count], Count_Container * Count_RawMaterial as Count_Need\r\nFROM ContentSimple\r\nINNER JOIN RawMaterial on FK_Id_RawMaterial = Id_RawMaterial\r\nWHERE Id_SimpleContent = " + Id_SimpleContent;
            SqlDataReader reader = DataProvider.Instance.ExecuteReader(query);
            if (reader.Read())
            {
                if (Convert.ToInt32(reader["Count"]) < Convert.ToInt32(reader["Count_Need"]))
                {
                    reader.Close();
                    return false;
                }
            }
            reader.Close();
            return true;
        }
    }
}
