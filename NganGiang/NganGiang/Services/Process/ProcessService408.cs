using static System.ComponentModel.Design.ObjectSelectorEditor;
using static System.Runtime.InteropServices.JavaScript.JSType;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.SqlClient;
using NganGiang.Models;
using NganGiang.Libs;

namespace NganGiang.Services.Process
{
    internal class ProcessService408
    {
        public DataTable ShowContentPack()
        {
            string query = @"SELECT FK_Id_OrderLocal AS [Mã đơn hàng], FK_Id_PackContent AS [Mã gói hàng],
            CASE SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END AS [Kiểu hàng], 
            Name_State AS [Trạng thái], CONVERT(DATE, ProcessContentPack.Data_Start) AS [Ngày bắt đầu]
            FROM ProcessContentPack
                INNER JOIN ContentPack on FK_Id_ContentPack = Id_PackContent
                INNER JOIN DetailContentSimpleOfPack on ContentPack.Id_PackContent = DetailContentSimpleOfPack.FK_Id_PackContent
                INNER JOIN DetailContentPackOrderLocal on ContentPack.Id_PackContent = DetailContentPackOrderLocal.FK_Id_ContentPack
                INNER JOIN State on FK_Id_State = Id_State
                INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal
            WHERE ProcessContentPack.FK_Id_Station = 408 AND FK_Id_State = 0 AND
            HaveEilmPE = 0 AND FK_Id_PackContent NOT IN (
                SELECT DCS.FK_Id_PackContent FROM DetailContentSimpleOfPack DCS
                INNER JOIN ContentSimple CS ON DCS.FK_Id_SimpleContent = CS.Id_SimpleContent
                WHERE CS.ContainerProvided <> 1 OR CS.PedestalProvided <> 1 OR CS.RFIDProvided <> 1
                OR CS.RawMaterialProvided <> 1 OR CS.CoverHatProvided <> 1) 
            GROUP BY FK_Id_OrderLocal, FK_Id_PackContent, SimpleOrPack, Name_State, ProcessContentPack.Data_Start";
            return DataProvider.Instance.ExecuteQuery(query);
        }
        public void UpdateWarehouse(int id)
        {
            string query = $"UPDATE DetailStateCellOfSimpleWareHouse SET FK_Id_StateCell = 1, FK_Id_SimpleContent = NULL " +
                $"WHERE FK_Id_SimpleContent IN (SELECT DCS.FK_Id_SimpleContent FROM DetailContentSimpleOfPack DCS " +
                    $"WHERE DCS.FK_Id_PackContent = {id})";
            DataProvider.Instance.ExecuteNonQuery(query);
        }
        public void UpdateProcessContentPack(int id)
        {
            try
            {
                string query = $"UPDATE ProcessContentPack SET FK_Id_State = 2, Data_Fin = " +
                $"'{DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")}' WHERE FK_Id_ContentPack = {id} AND FK_Id_Station = 408";
                DataProvider.Instance.ExecuteNonQuery(query);

                query = "INSERT INTO ProcessContentPack (FK_Id_ContentPack, FK_Id_Station, FK_Id_State, Data_Start) " +
                "VALUES (@FK_Id_ContentPack, @FK_Id_Station, @FK_Id_State, @Data_Start)";

                SqlParameter[] parameters = new SqlParameter[]
                {
                    new SqlParameter("@FK_Id_ContentPack", id),
                    new SqlParameter("@FK_Id_Station", 409),
                    new SqlParameter("@FK_Id_State", SqlDbType.SmallInt) { Value = 0 },
                    new SqlParameter("@Data_Start", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                };

                DataProvider.Instance.ExecuteNonQuery(query, parameters);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public List<int> GetIdSimpleContentList(int id)
        {
            string query = $"SELECT Id_SimpleContent AS [Mã thùng hàng] " +
                $"FROM ContentSimple " +
                $"INNER JOIN DetailContentSimpleOfPack ON Id_SimpleContent = FK_Id_SimpleContent " +
                $"INNER JOIN DetailContentPackOrderLocal ON FK_Id_ContentPack = FK_Id_ContentPack " +
                $"WHERE FK_Id_PackContent = {id} " +
                $"GROUP BY Id_SimpleContent";

            List<int> idSimpleContentList = new List<int>();

            DataTable result = DataProvider.Instance.ExecuteQuery(query);

            foreach (DataRow row in result.Rows)
            {
                int idSimpleContent = Convert.ToInt32(row["Mã thùng hàng"]);
                idSimpleContentList.Add(idSimpleContent);
            }

            return idSimpleContentList;
        }
        public void UpdateProcessContentSimple(int id)
        {
            try
            {
                List<int> idArr = GetIdSimpleContentList(id);
                foreach (int each in idArr)
                {
                    string query = $"UPDATE ProcessContentSimple SET FK_Id_State = 2, Data_Fin = @Data_Fin " +
                        $"WHERE FK_Id_ContentSimple = @FK_Id_ContentSimple AND FK_Id_Station = 408";
                    SqlParameter[] parameters = new SqlParameter[]
                    {
                        new SqlParameter("@FK_Id_ContentSimple", each),
                        new SqlParameter("@Data_Fin", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                    };

                    DataProvider.Instance.ExecuteNonQuery(query, parameters);

                    query = $"insert into ProcessContentSimple (FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Data_Start) values " + $"(@FK_Id_ContentSimple, @FK_Id_Station, @FK_Id_State, @Data_Start); ";
                    parameters = new SqlParameter[]
                    {
                        new SqlParameter("@FK_Id_ContentSimple", each),
                        new SqlParameter("@FK_Id_Station", 409),
                        new SqlParameter("@FK_Id_State", SqlDbType.SmallInt) { Value = 0 },
                        new SqlParameter("@Data_Start", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                    };

                    DataProvider.Instance.ExecuteNonQuery(query, parameters);
                }
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
