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
using System.Windows.Controls.Primitives;
using Org.BouncyCastle.Asn1.Ocsp;
using System.Windows.Navigation;

namespace NganGiang.Services.Process
{
    internal class ProcessService408
    {
        public DataTable ShowContentPack()
        {
            string query = @"SELECT FK_Id_OrderLocal AS [Mã đơn hàng], ProcessContentPack.FK_Id_ContentPack AS [Mã gói hàng],
            CASE SimpleOrPack WHEN 0 THEN N'Thùng hàng' WHEN 1 THEN N'Gói hàng' END AS [Loại hàng], 
            Name_State AS [Trạng thái], CONVERT(DATE, ProcessContentPack.Date_Start) AS [Ngày bắt đầu]
            FROM ProcessContentPack
                INNER JOIN ContentPack on FK_Id_ContentPack = Id_ContentPack
                INNER JOIN DetailContentSimpleOfPack on ContentPack.Id_ContentPack = DetailContentSimpleOfPack.FK_Id_ContentPack
                INNER JOIN DetailContentPackOrderLocal on ContentPack.Id_ContentPack = DetailContentPackOrderLocal.FK_Id_ContentPack
                INNER JOIN State on FK_Id_State = Id_State
                INNER JOIN OrderLocal ON FK_Id_OrderLocal = Id_OrderLocal
            WHERE ProcessContentPack.FK_Id_Station = 408 AND FK_Id_State = 0 AND
            HaveEilmPE = 0 AND ProcessContentPack.FK_Id_ContentPack NOT IN (
            SELECT DCS.FK_Id_ContentPack FROM DetailContentSimpleOfPack DCS
            INNER JOIN ContentSimple CS ON DCS.FK_Id_ContentSimple = CS.Id_ContentSimple
            WHERE (CS.ContainerProvided <> 1 OR CS.PedestalProvided <> 1 OR CS.RFIDProvided <> 1
            OR CS.RawMaterialProvided <> 1 OR CS.CoverHatProvided <> 1) AND NOT (CS.FK_Id_RawMaterial IN (0, 1, 2)))
            GROUP BY FK_Id_OrderLocal, ProcessContentPack.FK_Id_ContentPack, SimpleOrPack, Name_State, ProcessContentPack.Date_Start";
            return DataProvider.Instance.ExecuteQuery(query);
        }

        public int checkCustomer(int id)
        {
            try
            {
                string query = $"SELECT CustomerType.ID " +
                    $"FROM ContentPack " +
                    $"JOIN [Order] ON ContentPack.FK_Id_Order = [Order].Id_Order " +
                    $"JOIN Customer ON [Order].FK_Id_Customer = Customer.Id_Customer " +
                    $"JOIN CustomerType ON Customer.FK_Id_CustomerType = CustomerType.Id " +
                    $"WHERE ContentPack.Id_ContentPack = {id}";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows.Count > 0 && result.Rows[0]["ID"] != DBNull.Value)
                {
                    // Lấy giá trị trạm tiếp theo từ kết quả
                    int customerType = Convert.ToInt32(result.Rows[0]["ID"]);
                    return customerType;
                }
                else
                {
                    // Không có kết quả trả về
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy kiểu khách hàng.\n" + ex.Message);
                return -1;
            }
        }
        public int GetTotalCountInRegister(int id)
        {
            try
            {
                string query = $"SELECT SUM(COUNT) as SoLuong FROM RegisterContentSimpleAtWareHouse " +
                    $"WHERE FK_Id_ContentSimple IN " +
                    $"(SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS WHERE DCS.FK_Id_ContentPack = {id})";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows[0]["SoLuong"] != DBNull.Value)
                {
                    int totalCount = Convert.ToInt32(result.Rows[0]["SoLuong"]);
                    return totalCount;
                }
                else
                {
                    return -1; // Hoặc giá trị tùy ý để chỉ ra rằng kết quả truy vấn là NULL
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy trạm tiếp theo.\n" + ex.Message);
                return -1;
            }
        }
        public int GetTotalCountInWarehouse(int id)
        {
            try
            {
                string query = $"Select SUM(Count_Container) as SoLuong from ContentSimple " +
                    $"inner join RawMaterial as rm on FK_Id_RawMaterial = rm.Id_RawMaterial " +
                    $"where Id_ContentSimple in (SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS " +
                    $"WHERE DCS.FK_Id_ContentPack = ${id}) and rm.FK_Id_RawMaterialType <> 0";

                DataTable result = DataProvider.Instance.ExecuteQuery(query);

                if (result.Rows[0]["SoLuong"] != DBNull.Value)
                {
                    // Lấy giá trị trạm tiếp theo từ kết quả
                    int totalCount = Convert.ToInt32(result.Rows[0]["SoLuong"]);
                    return totalCount;
                }
                else
                {
                    // Không có kết quả trả về
                    return -1;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Lỗi khi lấy số lượng thùng chứa của thùng hàng.\n" + ex.Message);
                return -1;
            }
        }
        public bool CheckWarehouse(int id)
        {
            try
            {
                return GetTotalCountInRegister(id) == GetTotalCountInWarehouse(id) ? true : false;
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return false;
            }
        }
        public void FreeContentSimple(int id)
        {
            try
            {
                string query = $"UPDATE DetailStateCellOfSimpleWareHouse SET FK_Id_StateCell = 1, " +
                    $"FK_Id_ContentSimple = NULL WHERE FK_Id_ContentSimple IN " +
                    $"(SELECT DCS.FK_Id_ContentSimple FROM DetailContentSimpleOfPack DCS " +
                    $"WHERE DCS.FK_Id_ContentPack = {id})";
                DataProvider.Instance.ExecuteNonQuery(query);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateProcessContentPack(int id)
        {
            try
            {
                string query = "UPDATE ProcessContentPack SET FK_Id_State = 2, Date_Fin = @Date_Fin WHERE FK_Id_ContentPack = @FK_Id_ContentPack AND FK_Id_Station = 408";
                SqlParameter[] updateParameters = new SqlParameter[]
                {
                    new SqlParameter("@Date_Fin", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                    new SqlParameter("@FK_Id_ContentPack", id)
                };
                DataProvider.Instance.ExecuteNonQuery(query, updateParameters);

                query = "INSERT INTO ProcessContentPack (FK_Id_ContentPack, FK_Id_Station, FK_Id_State, Date_Start) " +
                "VALUES (@FK_Id_ContentPack, @FK_Id_Station, @FK_Id_State, @Date_Start)";

                SqlParameter[] insertParameters = new SqlParameter[]
                {
                    new SqlParameter("@FK_Id_ContentPack", id),
                    new SqlParameter("@FK_Id_Station", 409),
                    new SqlParameter("@FK_Id_State", SqlDbType.SmallInt) { Value = 0 },
                    new SqlParameter("@Date_Start", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                };

                DataProvider.Instance.ExecuteNonQuery(query, insertParameters);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public List<int> GetIdContentSimpleList(int id)
        {
            string query = $"SELECT Id_ContentSimple AS [Mã thùng hàng] " +
                $"FROM ContentSimple " +
                $"INNER JOIN DetailContentSimpleOfPack ON Id_ContentSimple = FK_Id_ContentSimple " +
                $"INNER JOIN DetailContentPackOrderLocal ON DetailContentPackOrderLocal.FK_Id_ContentPack = DetailContentSimpleOfPack.FK_Id_ContentPack " +
                $"INNER JOIN RawMaterial on ContentSimple.FK_Id_RawMaterial = RawMaterial.Id_RawMaterial " +
                $"WHERE DetailContentPackOrderLocal.FK_Id_ContentPack = {id} AND RawMaterial.FK_Id_RawMaterialType <> 0" +
                $"GROUP BY Id_ContentSimple";

            List<int> idContentSimpleList = new List<int>();

            DataTable result = DataProvider.Instance.ExecuteQuery(query);

            foreach (DataRow row in result.Rows)
            {
                int idContentSimple = Convert.ToInt32(row["Mã thùng hàng"]);
                idContentSimpleList.Add(idContentSimple);
            }

            return idContentSimpleList;
        }
        public int GetBeforeStation(int id)
        {
            try
            {
                string query = "SELECT TOP 1 FK_Id_Station AS N'Trạm phía trước' FROM DispatcherOrder " +
                    "INNER JOIN DetailContentPackOrderLocal ON DispatcherOrder.FK_Id_OrderLocal = " +
                    "DetailContentPackOrderLocal.FK_Id_ContentPack " +
                    "INNER JOIN DetailProductionStationLine ON DispatcherOrder.FK_Id_ProdStationLine = DetailProductionStationLine.FK_Id_ProdStationLine " +
                    $"WHERE FK_Id_Station <= 408 AND DetailContentPackOrderLocal.FK_Id_ContentPack = {id}";

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
        public void UpdateProcessContentSimple(int id)
        {
            try
            {
                List<int> idArr = GetIdContentSimpleList(id);
                foreach (int each in idArr)
                {
                    string query = $"UPDATE ProcessContentSimple SET FK_Id_State = 2, Date_Fin = @Date_Fin " +
                        $"WHERE FK_Id_ContentSimple = @FK_Id_ContentSimple AND FK_Id_Station = 408";
                    SqlParameter[] parameters = new SqlParameter[]
                    {
                        new SqlParameter("@FK_Id_ContentSimple", each),
                        new SqlParameter("@Date_Fin", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
                    };

                    DataProvider.Instance.ExecuteNonQuery(query, parameters);

                    query = $"insert into ProcessContentSimple (FK_Id_ContentSimple, FK_Id_Station, FK_Id_State, Date_Start) values " + $"(@FK_Id_ContentSimple, @FK_Id_Station, @FK_Id_State, @Date_Start); ";
                    parameters = new SqlParameter[]
                    {
                        new SqlParameter("@FK_Id_ContentSimple", each),
                        new SqlParameter("@FK_Id_Station", 409),
                        new SqlParameter("@FK_Id_State", SqlDbType.SmallInt) { Value = 0 },
                        new SqlParameter("@Date_Start", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss")),
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
